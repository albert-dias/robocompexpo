<?php

namespace App\Controller;

use RestApi\Controller\ApiController;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use RestApi\Utility\JwtToken;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends ApiController
{

    public function initialize()
    {
        $this->loadModel('Plans');
        $this->loadModel('People');
        $this->loadModel('Clients');
        $this->loadModel('Users');
        return parent::initialize();
    }
    /**
     * Verifica se prestador pode logar
     */
    public function loginProvider()
    {
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password'],
                    'scope' => array('Users.users_types_id' => 4)
                ]
            ]
        ]);

        if ($this->request->is('post')) {

            $user = $this->Auth->identify();
            $provider = $this->checkUserProvider($user);

            if ($provider) {
                    $payload = ['email' => $provider['email'], 'id' => $provider['provider_id'], 'date'=>date('Y-m-d h:i:s')]; // 

                    $this->apiResponse['token']   = JwtToken::generateToken($payload);
                    $this->apiResponse['authorized'] = true;
                    $this->apiResponse['user'] = $provider;
                    return;
                
            }

            $this->apiResponse['token']   = false;
            $this->apiResponse['authorized'] = false;
            $this->apiResponse['user'] = false;
        }
    }
    
    /**
     * Verifica se cliente pode logar
     */
    public function loginClient()
    {
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'cpf', 'password' => 'password']
                ]
            ]
        ]);

        // $filter = $this->Users->find()->where([
        //     'cpf' => $this->request->data('cpf'),
        // ])->first();

        if($this->request->is('post')){
            $user = $this->Auth->identify();

            $client = $this->checkUserClient($user);

            if($client){
                $payload = ['email' => $client['email'], 'id' => $client['client_id'], 'date'=>date('Y-m-d h:i:s')];

                $this->apiResponse['token'] = JwtToken::generateToken($payload);
                $this->apiResponse['authorized'] = true;
                $this->apiResponse['user'] = $client;
                return;
            }

            $this->responseStatus               = false;
            $this->apiResponse['token']         = false;
            $this->apiResponse['authorized']    = false;
            $this->apiResponse['user']          = false;
            // if($filter){
            //     $this->apiResponse['active']        = $filter->cpf;
            //     $this->apiResponse['active2']       = $filter->active;
            // }
        }
    }

    /**
     * verifica se usuário de prestador está dentro das regras
     */
    private function checkUserProvider($user){
        if(!$user){
            return false;
        }

        if($user['users_types_id'] != 4){
            return false;
        }
        
        if(!$user['active']){
            return false;
        }

        $provider = $this->getProvider($user['person_id']);

        if(!$provider){
            return false;
        }

        return [
            'provider_id'    => $provider->id,
            'category_id'    => $provider->category_id,
            'subcategory_id' => $provider->subcategory_id,
            'category'       => $provider->category->name,
            'subcategory'    => $provider->subcategory->name,
            'name'           => $provider->person->name,
            'nick'           => $provider->nick,
            'cpf'            => $provider->person->cpf,
            'email'          => $provider->person->email,
            'number_contact' => $provider->person->number_contact,
            'cep'            => $provider->person->cep,
            'image'          => $provider->image,
            'created'        => $provider->created
        ];

    }
    
     /**
     * verifica se cliente está dentro das regras
     */
    private function checkUserClient($user){
        if(!$user){
            return false;
        }

        if(!$user['active']){
            return false;
        }

        /*
        if($user['users_types_id'] != 5){
            return false;
        }
        */

        $client = $this->getClient($user['person_id']);

        if(!$client){
            return false;
        }

        $radius = $user['plan_id'] ? $this->Plans->get($user['plan_id'])->radius : null;

        return [
            'client_id'         => $client->id,
            'name'              => $client->person->name,
            'cpf'               => $client->person->cpf,
            'email'             => $client->person->email,
            'number_contact'    => $client->person->number_contact,
            'cep'               => $client->person->cep,
            'image'             => $client->image,
            'created'           => $client->created,
            'user_type'         => $user['users_types_id'],
            'latitude'          => $client->person->latitude,
            'longitude'         => $client->person->longitude,
            'nickname'          => $user['nickname'],
            'radius'            => $radius
        ];

    }

    /**
     * Busca prestador pelo id da pessoa
     */
    private function getProvider($person_id)
    {
        $this->loadModel('Providers');
        $p = $this->Providers->find()->where(
            [
                'person_id' => $person_id,
                'People.active' => true,
                'Providers.active' => true
            ])
            ->contain(['People', 'Categories', 'Subcategories'])
            ->first();

        return $p;
    }
    
     /**
     * Busca cliente pelo id da pessoa
     */
    private function getClient($person_id)
    {
        $this->loadModel('Clients');
        $p = $this->Clients->find()->where(
            [
                'person_id' => $person_id,
                'People.active' => true,
                'Clients.active' => true
            ])
            ->contain(['People'])
            ->first();

        return $p;
    }

    /**
     * Recupera senha do prestador
     */
     public function getNewPasswordProvider(){
        $this->loadComponent('Emails');
        $tableUsers       = TableRegistry::getTableLocator()->get('Users');
        
        $email  = $this->request->data('email');
        $cpf    = $this->removeCaracter($this->request->data('cpf'));

        $user = $tableUsers->find()
                ->contain([
                    'People'
                ])
                ->where([
                    'Users.email' => $email,
                    'Users.users_types_id' => 4,
                    'People.cpf' => $cpf,
                    'Users.active' => true
                ])
                ->first();

        if (!$user) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Prestador não encontrado'
            ];
            return;
        }

        $pas = $this->gerarSenha(8, true, true, true, false); 

        $user->password = $pas;

        if(!$tableUsers->save($user)){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Erro ao gerar nova senha'
            ];
            return; 
        }

        $this->Emails->sendEmailNewPassword([
            'email'    => $user->email,
            'name'     => $user->person->name,
            'password' => $pas
        ]);

        $this->responseStatus = true;
     }
   
     /**
     * Recupera senha do cliente
     */
     public function getNewPasswordClient(){
        $this->loadComponent('Emails');
        $tableUsers       = TableRegistry::getTableLocator()->get('Users');
        
        $email  = $this->request->data('email');
        $cpf    = $this->removeCaracter($this->request->data('cpf'));

        $user = $tableUsers->find()
                ->contain([
                    'People'
                ])
                ->where([
                    'Users.email' => $email,
                    'People.cpf' => $cpf,
                    'Users.active' => true
                ])
                ->first();

        if (!$user) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Cliente não encontrado'
            ];
            return;
        }

        $pas = $this->gerarSenha(8, true, true, true, false); 

        $user->password = $pas;

        if(!$tableUsers->save($user)){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Erro ao gerar nova senha'
            ];
            return; 
        }

        $response = $this->Emails->sendEmailRecoverPassword([
            'email'    => $user->email,
            'name'     => $user->person->name,
            'password' => $pas
        ]);

        $this->responseStatus = true;
        $this->apiResponse['email_result'] = $response;
     }

    /**
     * Remove carcateres de mascara dos dados para salvar em banco
     */
    private function removeCaracter($string)
    {
        $remove = [
            ",", "/", ".", "-", "(", ")", " "
        ];

        $str = str_replace($remove, "", $string);

        return $str;
    }

    private function gerarSenha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos)
    {
        $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
        $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
        $nu = "0123456789"; // $nu contem os números
        $si = "!@#$%¨&*()_+="; // $si contem os símbolos
        $senha = '';
       
        if ($maiusculas){
              // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
              $senha .= str_shuffle($ma);
        }
       
          if ($minusculas){
              // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
              $senha .= str_shuffle($mi);
          }
       
          if ($numeros){
              // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
              $senha .= str_shuffle($nu);
          }
       
          if ($simbolos){
              // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
              $senha .= str_shuffle($si);
          }
       
          // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
          return substr(str_shuffle($senha),0,$tamanho);
      }

    public function admUserActive(){
        // $text = '%' . $this->request->data('n') . '%';

        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);
        
        if($this->request->is('post')){
            $s = $this->request->data('s');
            $filter = $this->Users->find()->where([
                'users_types_id' => $s,
            ])->toArray();
            
            $this->apiResponse['filter'] = $filter;
            return;
        }
    }
    public function admUserSearch(){
        
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);
        
        if($this->request->is('post')){
            $s = $this->request->data('s');
            $n = '%'.$this->request->data('n').'%';

            $filter = $this->Users->find()->where([
                'users_types_id' => $s,
                'name LIKE' => $n,
            ])->toArray();

            $this->apiResponse['filter'] = $filter;
            return;
        }
    }

    /**
     * Ativar/Desativar cadastro do usuário
     */

    public function updateAccount(){
        if($this->request->is('post')) {
            $id_client = $this->request->data('id');
            $active_client = $this->request->data('active');

            $table = TableRegistry::get('Users');
            $query = $table->find()->where([
                'id' => $id_client,
            ])->first();

            if(!$query||$query == ''){
                $this->responseStatus = false;
                $this->apiResponse = [
                    'save' => false,
                    'erro' => 'Serviço não encontrado'
                ];
                return;
            };

            if($active_client === "true"){
                $query->active = '1';
            }
            else{
                $query->active = '0';
            }

            if($table->save($query)){
                $this->apiResponse = [
                    'save' => true,
                    'msg' => 'Você ativou/desativou o usuário com sucesso.',
                ];
                return;
            }

            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg' => 'Ativação/Desativação do usuário falhou.',
            ];
            return;
        }
    }

    /**
     * Verificar o plano ativo do usuário
     */

    public function getPlans() {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('get')) {
            $plan = $this->Users->find()->where([
                'person_id' => $person->id,
            ])->first();
        }

        $this->apiResponse['client'] = $plan;
        return;
    }

    /**
     * Trocar o plano ativo do usuário
     */

    public function changePlans() {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        $plan = $this->request->data('plans');

        $table = TableRegistry::get('Users');

        $userPlan = $table->find()->where([
            'person_id' => $person->id,
        ])->first();

        $userPlan->plan_id = $plan;

        if ($table->save($userPlan) ) {
            $this->apiResponse['plano'] = 'Operação feita com sucesso';
            return;
        }
        
        $this->apiResponse['err'] = 'Erro na hora de salvar o plano';
        return;
    }

    /**
     * Carregar informações do logradouro do perfil
     */
    public function carregar(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        $table = TableRegistry::get('People');

        $info = $table->find()->where([
            'id' => $person->id,
        ])->first();

        $this->apiResponse['user'] = $info;
        return;
    }

    /**
     * Update das informações da conta do usuário
     */

    public function updatePerfil(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('post')){

            $nome = $this->request->data('nome');
            $email = $this->request->data('email');
            $tel = $this->request->data('telefone');
            $apelido = $this->request->data('apelido');
            $cep = $this->request->data('cep');
            $endereco = $this->request->data('endereco');
            $numero = $this->request->data('numero');
            $complemento = $this->request->data('complemento');
            $bairro = $this->request->data('bairro');
            $cidade = $this->request->data('cidade');
            $estado = $this->request->data('estado');
            $long = $this->request->data('longitude');
            $lati = $this->request->data('latitude');

            $tablePeople = TableRegistry::get('People');
            $tableUsers = TableRegistry::get('Users');
            
            $user = $tableUsers->find()->where([
                'person_id' => $person->id,
            ])->first();

            $pessoa = $tablePeople->find()->where([
                'id' => $person->id,
            ])->first();

            $user->name = $nome;
            $user->email = $email;
            $user->nickname = $apelido;
            
            if($tableUsers->save($user))
            {
                $pessoa->name = $nome;
                $pessoa->email = $email;
                $pessoa->number_contact = $tel;
                $pessoa->address = $endereco;
                $pessoa->number = $numero;
                $pessoa->complement = $complemento;
                $pessoa->district = $bairro;
                $pessoa->city = $cidade;
                $pessoa->state = $estado;
                $pessoa->cep = $cep;
                $pessoa->latitude = $lati;
                $pessoa->longitude = $long;

                if($tablePeople->save($pessoa)){
                    $this->apiResponse['resposta'] = 'Salvo com sucesso';
                }
                else{ $this->apiResponse['resposta'] = 'Deu errado salvar na tabela People'; }
            }
            else{ $this->apiResponse['resposta'] = 'Deu errado salvar na tabela Users'; }
        }
        return;
    }

    public function myPlan(){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('get')){
            $table = TableRegistry::get('Users');

            $query = $table->find()->where([
                'id' => $client->id
            ])->first();
            $this->apiResponse['plan'] = $query->plan_id;
        }

        if($this->request->is('post')){
            $plan = $this->request->data('plan');

            $table = TableRegistry::get('Users');
            $query = $table->find()->where([
                'id' => $client->id
            ])->first();

            $query->plan_id = $plan;

            if(!$table->save($query)){
                $this->apiResponse['ERRO: '] = 'FALHA AO DAR UPDATE NO PLANO.';
                return;
            }
            $this->apiResponse['NOVO PLANO: '] = $plan;
            return;
        }
    }
}
