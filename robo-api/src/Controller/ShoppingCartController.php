<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use RestApi\Controller\ApiController;

/**
 * ShoppingCart Controller
 * 
 * @property \App\Model\Table\ShoppingCartTable $Shopping
 * @method \App\Model\Entity\ShoppingCart[]|\Cake\Datasource\ResultSetInterface paginate($obkect = null, array $settings = [])
 */

class ShoppingCartController extends ApiController
{
    /**
    * Inicialização de componentes necessários
    */
    
    public function initialize()
    {
        $this->loadModel('Providers');
        $this->loadModel('S3Tools');
        $this->loadModel('ErrorList');
        $this->loadModel('Users');
        $this->loadModel('People');
        $this->loadModel('Clients');
        $this->loadModel('Margin');
        $this->loadComponent('OneSignal');
        return parent::initialize();
    }

    /**
     * Adicionar serviços ao carrinho de compras
     */

    public function searchCartID() {
        $token = $this->jwtPayload;
        $sql = 'SELECT (id_cart +1) AS idp1 FROM shopping_cart WHERE status <> \'carrinho\' ORDER BY id DESC LIMIT 1';
        $id_cart = $this->query($sql);

        if(empty($id_cart)){
            $id_cart[0] = 1;
        }

        $this->apiResponse['carrinho'] = $id_cart[0];
        return;
    }
    public function addCart() {
        $token = $this->jwtPayload;

        $client = $this->request->data('id_client');
        $company = $this->request->data('id_service');
        $service = $this->request->data('name_service');
        $price = $this->request->data('price');
        $addinfo = $this->request->data('addinfo');
        $hora = $this->request->data('hora');
        $data = $this->request->data('data');
        $id_cart = $this->request->data('id_cart');

        if($id_cart === 'undefined'){
            $id_cart = '1'; 
        }
        
        $cart = $this->ShoppingCart->newEntity();
        
        if($this->request->is('post')) {
            $cart->id_cart = $id_cart;
            $cart->client_id = $client;
            $cart->company_id = $company;
            $cart->service = $service;
            $cart->price = $price;
            $cart->dia = $data;
            $cart->horario = $hora;
            $cart->status = 'carrinho';
            $cart->status_cliente = 'carrinho';
            $cart->created = date('Y-m-d H:i:s');
            $cart->modified = date('Y-m-d H:i:s');
            $cart->cautions = $addinfo;

            if(!$this->ShoppingCart->save($cart)) {
                $this->apiResponse['message'] = 'Erro, não foi possível adicionar ao carrinho.';
                return;
            }
            $this->apiResponse['SERVIÇO'] = $cart->id;
            return;
        }
    }

    /**
     * Contar os pedidos dentro do carrinho do cliente
     */

    public function countServices() {
        $token = $this-> jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);
        
        if($this->request->is('get')) {
            $sql = 'SELECT COUNT(*) AS contar FROM shopping_cart WHERE status_cliente = \'carrinho\' AND client_id = '. $client->id;

            $count = $this->ShoppingCart->find()->where([
                'status_cliente' => 'carrinho',
                'client_id' => $client->id,
            ])->toArray();
            $result = $this->query($sql);

            $this->apiResponse['count'] = $count;
            return;
        }
    }

    /**
     * Localizar todos os serviços adicionados ao carrinho
     */

    public function setAllServices(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);

        $person = $this->People->get($client->person_id);
        $text = 'carrinho';

        $this->apiResponse['CLIENT'] = $person;

        if($this->request->is('get')){
            $services = $this->ShoppingCart->find()->where([
                'client_id' => $client->id,
                'status' => $text
            ])->toArray();
            $this->apiResponse['services'] = $services;
            return;
        }
    }

    /**
     * Deletar algum serviço adicionado ao carrinho
     */
    public function deleteServices($idS){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);

        $person = $this->People->get($client->person_id);

        if($this->request->is('post')){
            $service = $this->ShoppingCart->get($idS);
            $result = $this->ShoppingCart->delete($service);

            if($result){
                $this->apiResponse['message'] = 'Delete realizado com sucesso.';
            }else{ $this->apiResponse['message'] = 'Falha ao tentar deletar o serviço.'; }
            return;
        }
    }

    /**
     * Confirmando o pedido do serviço
     */
    public function confirmation(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('post')){
           $confirm = $this->request->data('id');

            $sql = $this->ShoppingCart->find()->where([
                'id' => $confirm
            ])->first();

            if(!$sql || $sql == "") {
                $this->responseStatus = false;
                $this->apiResponse = [
                    'save' => false,
                    'erro' => 'Produto não encontrado'
                ];
                return;
            };

            $tb_shop = TableRegistry::get('ShoppingCart');
            $shop = $tb_shop->find()->where([
                'id' => $confirm,
            ])->first();

            $shop->status = 'requisitado';
            $shop->status_cliente = 'aceito';
            if($tb_shop->save($shop)) {
                $this->apiResponse = [
                    'save' => true,
                    'msg' => 'Requisição aprovada',
                ];
                $this->OneSignal->sendNotificationUser('Você tem um novo pedido', 'Robocomp', $sql->company_id);
                return;
            };
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg' => 'Requisição recusada',
            ];
            return;
        }
    }

    /**
     * Carregar serviços com status de requisitado,
     * aceito ou negado
     */
    public function setWaitingServices()
    {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);

        $person = $this->People->get($client->person_id);

        if($this->request->is('get')){
            $categories = $this->ShoppingCart->find('all')->where([
                'status LIKE' => 'requisitado',
                // 'OR' => $aceito,
                // 'OR' => $negado,
            ])->toArray();
            $this->apiResponse['categories'] = $categories;
            return;
        }
    }
    
    /**
     * Mostrar somente os serviços daquela empresa com o status de 'REQUISITADO'
     */
    public function requestServices(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('get')){
            $sql = 'SELECT shopping_cart.*, users.name, people.address, people.number,
            people.district, people.complement, people.city, people.state, people.cep
            FROM shopping_cart INNER JOIN users INNER JOIN people
            WHERE shopping_cart.company_id = '.$client->id.' AND status = \'requisitado\' AND shopping_cart.client_id = users.id AND users.person_id = people.id';

            $services = $this->query($sql);
            // $services = $this->ShoppingCart->find()->where([
            //     'company_id' => $client->id,
            //     'status' => 'requisitado',
            // ])->toArray();
            $this->apiResponse['requisitados'] = $services;
            return;
        }
    }
    /**
     * Mostrar somente os serviços daquela empresa com o status de 'ACEITO' em diante
     */
    public function acceptServices(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('get')){

            $sql = 'SELECT shopping_cart.*, users.name, people.address, people.number,
            people.district, people.complement, people.city, people.state, people.cep
            FROM shopping_cart INNER JOIN users INNER JOIN people
            WHERE shopping_cart.company_id = '.$client->id.' AND status = \'aceito\'
            AND shopping_cart.client_id = users.id AND users.person_id = people.id';
            
            $services = $this->query($sql);
            $this->apiResponse['requisitados'] = $services;
            $this->apiResponse['TESTE'] = $sql;
            return;
        }
    }

    /**
     * Mostrar somente os serviços daquele cliente com o status de 'REQUISITADO' em diante
     */
    public function requestFollowServices(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('get')){

            $sql = 'SELECT shopping_cart.*, users.name FROM shopping_cart INNER JOIN users 
            WHERE shopping_cart.client_id = '.$client->id.' AND status_cliente = \'aceito\' AND status <> \'negado\' AND shopping_cart.company_id = users.id';
            
            $services = $this->query($sql);
                // $this->ShoppingCart->find()->where([
                //     'client_id' => $client->id,
                //     'status_cliente' => 'aceito',
                //     'status !=' => 'negado',
                // ])->toArray();
            
            $this->apiResponse['requisitados'] = $services;
            return;
        }
    }

    /**
     * Filtrar serviços 'REQUISITADOS'
     */
    public function filterRequestServices(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        $text = '%' . $this->request->data('search') . '%';
        $select = $this->request->data('filter');
        $aux = 'Todas as categorias';

        if($this->request->is('post')){
            if($select == $aux){
                $filter = $this->MyServices->find()->where([
                    'service_name LIKE' => $text,
                    'company_id' => $client->id,
                    'status LIKE' => 'requisitado',
                ])->toArray();

                $this->apiResponse['services'] = $filter;
                $this->apiResponse['SELECIONADO'] = $select;
                return;
            }
            else{
                $filter = $this->MyServices->find()->where([
                    'service_name LIKE' => $text,
                    'company_id' => $client->id,
                    'status LIKE' => 'requisitado',
                    'category' => $select,
                ])->toArray();

                $this->apiResponse['services'] = $filter;
                $this->apiResponse['SELECIONADO'] = $select;
                return;
            }
        }
    }

    /**
     * Mudar o status do pedido para aceito ou negado
     */

     public function updateService(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('post')){
            $confirm = $this->request->data('id');
            $status = $this->request->data('status');

            $table = TableRegistry::get('ShoppingCart');
            $query = $table->find()->where([
                'id' => $confirm,
            ])->first();

            $query->status = $status;

            if(!$query||$query == ''){
                $this->responseStatus = false;
                $this->apiResponse = [
                    'save' => false,
                    'erro' => 'Produto não encontrado'
                ];
                return;
            };

            if($table->save($query)){
                $this->apiResponse = [
                    'save' => true,
                    'msg' => 'Mudança de status funcionou',
                ];
                return;
            }

            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg' => 'Mudança de status falhou',
            ];
            return;
        }
    }

    /**
      * Filtrar serviços requisitados e aceitos
      */
    public function setFilterServices()
    {
        $text = '%' . $this->request->data('search') . '%';
        $select = $this->request->data('filter');

        if($this->request->is('post')){
            $filter = $this->MyServices->find()->where([
                'service_name LIKE' => $text,
                'company_id' => $client->id,
                'status LIKE' => 'requisitado',
            ])->orWhere([
                'service_name LIKE' => $text,
                'company_id' => $client->id,
                'status LIKE' => 'aceito',
            ])->toArray();

            $this->apiResponse['services'] = $filter;
            $this->apiResponse['SELECIONADO'] = $select;
            return;
        }
    }

    /**
      * Filtrar serviços requisitados e aceitos para o usuário visualizar
      */
    public function setFilterFollowServices()
    {
        $text = '%' . $this->request->data('search') . '%';
        $select = $this->request->data('filter');
        $aux = 'Todas as categorias';

        

        if($select == $aux) {
            if($this->request->is('post')){
                $filter = $this->MyServices->find()->where([
                    'service_name LIKE' => $text,
                    'client_id' => $client->person_id,
                    'status LIKE' => 'requisitado',
                ])->orWhere([
                    'service_name LIKE' => $text,
                    'client_id' => $client->person_id,
                    'status LIKE' => 'aceito',
                ])->toArray();

                $this->apiResponse['services'] = $filter;
                $this->apiResponse['SELECIONADO'] = $select;
                return;
            }
        }
        else{
            if($this->request->is('post')){
                $filter = $this->MyServices->find()->where([
                    'service_name LIKE' => $text,
                    'category' => $select,
                    'client_id' => $client->person_id,
                    'status LIKE' => 'requisitado',
                ])->orWhere([
                    'service_name LIKE' => $text,
                    'category' => $select,
                    'client_id' => $client->person_id,
                    'status LIKE' => 'aceito',
                ])->toArray();

                $this->apiResponse['services'] = $filter;
                $this->apiResponse['SELECIONADO'] = $select;

                return;
            }
        }
    }

    /**
     * Finalizando a OS
     */

    public function finishingClientOS(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('post')){
            $confirm = $this->request->data('id');

            $table = TableRegistry::get('ShoppingCart');
            $query = $table->find()->where([
                'id' => $confirm,
            ])->first();
            $query->status_cliente = 'finalizado';

            if($table->save($query)){
                $this->apiResponse = [
                    'save' => true,
                    'erro' => 'Mudança de status funcionou',
                ];
                return;
            }

            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'erro' => 'Mudança de status falhou',
            ];
            return;
        }
    }

    public function finishingOS(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('post')){
            $confirm = $this->request->data('id');

            $table = TableRegistry::get('ShoppingCart');
            $query = $table->find()->where([
                'id' => $confirm,
            ])->first();
            $query->status = 'finalizado';
            $query->modified = date('Y-m-d H:i:s');

            if($table->save($query)){
                $this->apiResponse = [
                    'save' => true,
                    'erro' => 'Mudança de status funcionou',
                ];
                return;
            }

            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'erro' => 'Mudança de status falhou',
            ];
            return;
        }
    }
    
    /**
     * Puxar somente as OS finalizadas daquele técnico
     */
    public function finishedServices(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('get')){

            $sql = 'SELECT shopping_cart.*, users.name, people.address, people.number, people.district, people.complement, people.city, people.state
            FROM shopping_cart INNER JOIN users INNER JOIN people
            WHERE shopping_cart.company_id = '.$client->id.' AND shopping_cart.client_id = users.id AND users.person_id = people.id
            AND (status = \'finalizado\' OR status = \'avaliado\');';
            // $services = $this->query($sql);
            // $services = $this->ShoppingCart->find()->where([
            //     'company_id' => $client->id,
            //     'status' => 'finalizado',
            // ])->orWhere([
            //     'company_id' => $client->id,
            //     'status' => 'avaliado',
            // ])->toArray();

            $services = $this->query($sql);
            // $this->apiResponse['SQL'] = $services;

            // $s = explode('-', $services->workday);
            // $s2 = explode('T',$s[2]);
            // $services->workday = $s[0].'/'.$s[1] .'/'.$s[0];
            
            $this->apiResponse['finalizados'] = $services;
            return;
        }
    }

    /**
     * Puxar somente as OS finalizadas daquele cliente
     */
    public function finishedServicesClient(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('get')){
            $sql = 'SELECT shopping_cart.*, users.name, people.address, people.number,
            people.district, people.complement, people.city, people.state
            FROM shopping_cart INNER JOIN users INNER JOIN people
            WHERE shopping_cart.client_id = ' . $client->id . ' AND (status_cliente = \'finalizado\' OR status_cliente = \'avaliado\') AND shopping_cart.company_id = users.id AND users.person_id = people.id';
            $services = $this->query($sql);
            
            // $services = $this->ShoppingCart->find()->where([
            //     'client_id' => $client->id,
            //     'status_cliente' => 'finalizado',
            // ])->orWhere([
            //     'client_id' => $client->id,
            //     'status_cliente' => 'avaliado',
            // ])->toArray();
            $this->apiResponse['SQL'] = $sql;
            $this->apiResponse['finalizados'] = $services;
            return;
        }
    }

    /**
     * Cadastrar avaliação do técnico sobre o serviço realizado e sobre o cliente
     */

    public function avaliationClient(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('post')){
            $id = $this->request->data('id');
            $rating = $this->request->data('rating');
            $cliente = $this->request->data('client');
            $company = $this->request->data('company');
            $obs = $this->request->data('obs');

            $table = TableRegistry::get('ShoppingCart');
            $table2 = TableRegistry::get('Users');

            $queryT = $table->find()->where([
                'id' => $id,
            ])->first();
            
            $queryT->avaliation = $obs;
            $queryT->status = 'avaliado';

            $queryT2 = $table2->find()->where([
                'id' => $cliente,
            ])->first();

            $o = 1;
            $queryT2->num_rating = $queryT2->num_rating + $o;
            $queryT2->tot_rating = $queryT2->tot_rating + $rating;

            if(!$table->save($queryT)){
                $this->apiResponse = [
                    'save' => false,
                    'erro' => 'Erro na hora de salvar a observação',
                ];
                return;
            }

            if(!$table2->save($queryT2)){
                $this->apiResponse = [
                    'save' => false,
                    'erro' => 'Erro na hora de salvar a avaliação',
                ];
                return;
            }
            return;
        }
    }
    /**
     * Cadastrar avaliação do cliente sobre o serviço realizado e sobre o técnico
     */

    public function avaliationTechnic(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('post')){
            $id = $this->request->data('id');
            $rating = $this->request->data('rating');
            $cliente = $this->request->data('client');
            $company = $this->request->data('company');
            $obs = $this->request->data('obs');

            $table = TableRegistry::get('ShoppingCart');
            $table2 = TableRegistry::get('Users');

            $queryT = $table->find()->where([
                'id' => $id,
            ])->first();
            
            //Avaliações do cliente para o cliente (observações e mudança de status)
            $queryT->avaliation_client = $obs;
            $queryT->status_cliente = 'avaliado';

            $queryT2 = $table2->find()->where([
                'id' => $company,
            ])->first();
            
            //Avaliações do cliente para o servidor (nota de 1 a 5, as estrelas)
            $o = 1;
            $queryT2->num_rating = $queryT2->num_rating + $o;
            $queryT2->tot_rating = $queryT2->tot_rating + $rating;

            if(!$table->save($queryT)){
                $this->apiResponse = [
                    'save' => false,
                    'erro' => 'Erro na hora de salvar a observação',
                ];
                return;
            }

            if(!$table2->save($queryT2)){
                $this->apiResponse = [
                    'save' => false,
                    'erro' => 'Erro na hora de salvar a avaliação',
                ];
                return;
            }
            return;
        }
    }

    /**
     * Funções auxiliares, não deletar ou modificar
     */
    public function query($sql){
        $connection = ConnectionManager::get('default');
        $query = $connection->execute($sql)->fetchall('assoc');
        return $this->arrayToArrayObj($query);
    }
    public function arrayToObj($arr){
        $object = (object) [];
        foreach ($arr as $key => $value)
        {
            if(is_float($value) && strlen($value) <= 8) { $value = (float)$value;} 
        
            if(is_int($value) && strlen($value) <= 8) { $value = (int)$value;} 
            $object->$key = $value;
        }
        return $object;
    }

    public function arrayToArrayObj($arr){
        $arr2 = [];
        foreach ($arr as $key => $value){ 
            $value2 = $this->arrayToObj($value);
            array_push($arr2,$value2);
        }
        return $arr2;
    }
}