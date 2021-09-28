<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validation;
use RestApi\Controller\ApiController;
use RestApi\Utility\JwtToken;

/**
 * Clients Controller
 *
 * @property \App\Model\Table\ClientsTable $Clients
 *
 * @method \App\Model\Entity\Client[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientsController extends ApiController
{
    /**
     * Inicialização de componentes necessários
     * 
     */
    public function initialize()
    {
        $this->loadComponent('ErrorList');
        $this->loadComponent('S3Tools');
        $this->loadModel('People');
        $this->loadModel('Clients');
        $this->loadModel('Users');
        $this->loadModel('UsersCategories');
        $this->loadModel('UnregisteredUsers');
        $this->loadModel('Leads');
        return parent::initialize();
    }

    /**
     * Inserir cliente na base de dados
     * Salva pessoa
     * Adciona o cliente
     */
    /* public function insert($lead_id)
    {
        $email = $this->request->data('email');
        

        $user = $this->searchUser($email);
        
        if($user){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Email já cadastrado';
            $this->apiResponse['token']              = false;
            $this->apiResponse['authorized']         = false;
            $this->apiResponse['user']               = false;
            return;
        }
        
        $ps = $this->addPerson();
      
        if (!$ps['save']) {
            $this->responseStatus = false;
            $this->apiResponse['message'] = $ps['msg_erro'];
            $this->apiResponse['token']              = false;
            $this->apiResponse['authorized']         = false;
            $this->apiResponse['user']               = false;
            return;
        }

        $prs = $this->addClient($ps['person']);
       
        if (!$prs['save']) {
            //$this->People->delete($ps['person']);
            $this->responseStatus = false;
            $this->apiResponse['message'] = $prs['msg_erro'];
            $this->apiResponse['token']              = false;
            $this->apiResponse['authorized']         = false;
            $this->apiResponse['user']               = false;
            return;
        }

        $user = $this->addUser($ps['person']);
        
        if (!$user['save']) {
            //$this->People->delete($ps['person']);
            $this->responseStatus = false;
            $this->apiResponse['message'] = $user['msg_erro'];
            $this->apiResponse['token']              = false;
            $this->apiResponse['authorized']         = false;
            $this->apiResponse['user']               = false;
            return;
        }

        $categorie_ids = $this->request->data('categorie_ids');
        if(!is_null($categorie_ids)) {
          $categorie_ids = json_decode($categorie_ids);
          foreach($categorie_ids as $categorie_id) {
              $users_categories = $this->UsersCategories->newEntity();
              $users_categories->user_id = $user['person']->id;
              $users_categories->categorie_id = intval($categorie_id);
              $this->UsersCategories->save($users_categories);
          }
        }

        $lead = $this->Leads->get($lead_id);
        $lead->status_lead = 'Cadastrado';
        $this->Leads->save($lead);

        $this->apiResponse['message'] = 'salvo com sucesso';
        
        $client = [
            'client_id' => $prs['provider']->id,
            'name' => $ps['person']->name,
            'cpf' => $ps['person']->cpf,
            'email' => $ps['person']->email,
            'number_contact' => $ps['person']->number_contact,
            'cep' => $ps['person']->cep,
            'image' => $prs['provider']->image,
            'created' => $prs['provider']->created,
            'user_type' => $user['person']->users_types_id,
            'latitude' => $ps['person']->latitude,
            'longitude' => $ps['person']->longitude
        ];

        $payload = ['email' => $client['email'], 'id' => $client['client_id'], 'date'=>date('Y-m-d h:i:s')]; 

        $this->apiResponse['token'] = JwtToken::generateToken($payload);
        $this->apiResponse['authorized'] = true;
        $this->apiResponse['user'] = $client;

        return;
    } */

    public function insert() {
        
        if($this->request->is('post')) {
            $email = $this->request->data('email');
            $validEmail = $this->searchUser($email);

            //Saber se email já está cadastrado
            if($validEmail) {
                $this->responseStatus = false;
                $this->apiResponse['message'] = 'Email já cadastrado';
                $this->apiResponse['token']              = false;
                $this->apiResponse['authorized']         = false;
                $this->apiResponse['user']               = false;
                return;
            }

            //Adicionar informações na table People
            $ps = $this->addPerson();
            
            //Saber se foi salvo o novo cadastro em People
            if(!$ps['save']) {
                $this->responseStatus = false;
                $this->apiResponse['message']  = $ps['msg_erro'];
                $this->apiResponse['token']              = false;
                $this->apiResponse['authorized']         = false;
                $this->apiResponse['user']               = false;
                return;
            }

            //Adicionar informações na table Clients
            $prs = $this->addClient($ps['person']);

            //Saber se foi salvo o novo cadastro em Clients
            if(!$prs['save']) {
                $this->responseStatus = false;
                $this->apiResponse['message'] = $prs['msg_erro'];
                $this->apiResponse['token']              = false;
                $this->apiResponse['authorized']         = false;
                $this->apiResponse['user']               = false;
                return;
            }
            
            //Adicionar informações na table Users
            $user = $this->addUser($ps['person']);

            //Saber se foi salvo o novo cadastro em Users
            if(!$user['save']) {
                $this->responseStatus = false;
                $this->apiResponse['message'] = $user['msg_erro'];
                $this->apiResponse['token']              = false;
                $this->apiResponse['authorized']         = false;
                $this->apiResponse['user']               = false;
                return;
            }

            $categorie_ids = $this->request->data('categorie_ids');

            if(!is_null($categorie_ids)) {
                $categorie_ids = json_decode($categorie_ids);
                foreach($categorie_ids as $categorie_id) {
                    $users_categories = $this->UsersCategories->newEntity();
                    $users_categories->user_id = $user['person']->id;
                    $users_categories->categorie_id = intval($categorie_id) + 1;
                    $this->UsersCategories->save($users_categories);
                }
            }

            $client = [
                'client_id' => $prs['provider']->id,
                'name' => $ps['person']->name,
                'cpf' => $ps['person']->cpf,
                'email' => $ps['person']->email,
                'number_contact' => $ps['person']->number_contact,
                'cep' => $ps['person']->cep,
                'image' => $prs['provider']->image,
                'created' => $prs['provider']->created,
                'user_type' => $user['person']->users_types_id,
                'latitude' => $ps['person']->latitude,
                'longitude' => $ps['person']->longitude
            ];
    
            $payload = ['email' => $client['email'], 'id' => $client['client_id'], 'date'=>date('Y-m-d h:i:s')]; 
    
            $this->apiResponse['token'] = JwtToken::generateToken($payload);
            $this->apiResponse['authorized'] = true;
            $this->apiResponse['user'] = $client;

            $this->apiResponse['SALVO'] = 'Salvo com sucesso';

            return;
        }
    }

    /**
     * Cria pessoa com dados de cliente
     */
    private function addPerson()
    {
        $cpf = $this->removeCarcter($this->request->data('numero_cpf'));
        $person = $this->searchPerson($cpf);

        if($person){
            return [
                'save' => true,
                'person' => $person,
                'msg_erro' => ''
            ];
        }

        $person                 = $this->People->newEntity();
        $person->company_id     = 1;
        $person->image          = null;
        $person->name           = $this->request->data('name');
        $person->cpf            = $cpf;
        //$person->rg             = $this->removeCarcter($this->request->data('numero_rg'));
        //$person->institution_rg = $this->request->data('institution_rg');
        $person->date_of_birth  = $this->request->data('date_of_birth');
        $person->email          = $this->request->data('email');
        $person->number_contact = $this->removeCarcter($this->request->data('number_contact'));
        $person->address        = $this->request->data('address');
        $person->number         = $this->request->data('number');
        $person->gender         = $this->request->data('gender');
        $person->complement     = $this->request->data('complement');
        $person->district       = $this->request->data('district');
        $person->city           = $this->request->data('city');
        $person->state          = $this->request->data('state');
        $person->latitude       = $this->request->data('latitude');
        $person->longitude      = $this->request->data('longitude');

        /*
        $number = $this->request->data('card_number');
        $month  = $this->request->data('card_expiration_month');
        $year   = $this->request->data('card_expiration_year');
        $code   = $this->request->data('card_code');

        $token = $this->tokenCard($person->name, $month, $year, $code, $number);

        if(!$token){
            return [
                'save' => false,
                'person' => false,
                'msg_erro' => "falha ao salvar cartao"
            ];
        }

        $person->billabong             = $token;
        $person->cep                   = $this->request->data('cep');
        $person->active                = true;
        */
        
        if ($this->People->save($person)) {
            return [
                'save' => true,
                'person' => $person,
                'msg_erro' => ''
            ];
        }

        $msg_erro = $this->ErrorList->errorInString($person->errors());

        return [
            'save' => false,
            'person' => false,
            'msg_erro' => $msg_erro.' - 1001'
        ];
    }

    /**
     * Gera token do cartão junto ao gatway de pagamento
     * Todos os dados de cartão devem ficar com o gatway
     */
    private function tokenCard($name, $month, $year, $security, $number)
    {
        $c = Configure::read('GTW');
        $http = new Client($c);

        $obj = [
            "holder_name"      => $name,
            "expiration_month" => $month,
            "expiration_year"  => $year,
            "security_code"    => $security,
            "card_number"      => $number
        ];

        $response = $http->post('/cards/tokens', $obj);
        
        $obj = json_decode($response->body);

        if (isset($obj->id) && $obj->id) {
            return $obj->id;
        }

        return false;
    }

    /**
     * Buscar pessoas que já esteja cadastrada com cpf
     */
    private function searchPerson($cpf){

        $person = $this->People->find()->where([
            'cpf'=> $cpf
        ])->first();

        return $person;
    }
   
    /**
     * Buscar clientes que já esteja cadastrada para essa pessoa
     */
    private function searchClient($person_id){

        $client = $this->Clients->find()->where([
            'person_id'=> $person_id
        ])->first();

        return $client;
    }

    /**
     * Limpeza de strings com mascaras 
     */
    private function removeCarcter($string)
    {
        $remove = [
            ",", "/", ".", "-", "(", ")"," "
        ];

        $str = str_replace($remove, "", $string);

        return $str;
    }

    /**
     * Salva cliente em base de dados
     */
    private function addClient($person)
    {
        $c = $this->searchClient($person->id);


        if($c){
            return [
                'save' => false,
                'person' => false,
                'msg_erro' => "cliente já cadastrado"
            ];
        }

        $client = $this->Clients->newEntity();
        $client->companies_id = $person->company_id;
        $client->person_id = $person->id;
        $client->acting_region = 'RN';
        $client->active = true;

        if ($this->Clients->save($client)) {
            return [
                'save' => true,
                'provider' => $client,
                'msg_erro' => ''
            ];
        }

        $msg_erro = $this->ErrorList->errorInString($client->errors());

        return [
            'save' => false,
            'provider' => false,
            'msg_erro' => $msg_erro
        ];
    }

    /**
     * Cria usuário para o cliente
     */
     private function addUser($person){
        
        $user = $this->searchUser($person->email);

        if ($user) {
            //update
            $user->password = $this->request->data('password');
        } else {
            $user = $this->Users->newEntity();
            $user->company_id = 1;
            $user->users_types_id = intval($this->request->data('user_type'));//5;
            $user->person_id = $person->id;
            if($user->users_types_id == '5')
            { $user->active = true; }
            else if($user->users_types_id == '6')
            { $user->active = false ; }
            $user->name = $person->name;
            $user->email = $person->email;
            $user->password = $this->request->data('password');
            $user->nickname = $this->request->data('nickname');
            $user->cpf = $person->cpf;
        }

        if ($this->Users->save($user)) {
            return [
                'save' => true,
                'person' => $user,
                'msg_erro' => ''
            ];
        }

        $msg_erro = $this->ErrorList->errorInString($user->errors());

        return [
            'save' => false,
            'person' => false,
            'msg_erro' => $msg_erro
        ];

     }

     /**
     * Buscar usuário que já esteja cadastrada com email
     */
    private function searchUser($email){

        $user= $this->Users->find()->where([
            'email'=> $email,
            'users_types_id' => 5
        ])->first();

        return $user;
    }

    /**
     * Checar se já existe cadastro com o CNPJ digitado
     */
    public function checkCPF() {
        $cpf        = $this->removeCarcter($this->request->data('cpf'));
        $tableUsers = TableRegistry::getTableLocator()->get('Users');

        $check = '';
        $check = $tableUsers->find()->where([
            "Users.cpf" => $cpf,
        ])->first();
        $this->apiResponse['cpf'] = $check;
        return;
    }

    /**
     * Cadastrar avaliação do prestador para o cliente
     */
    public function insertRating(){
        $d = $this->jwtPayload;

        $os_id = $this->request->data('os_id');
        $stars = $this->request->data('stars');

        $tableRatings       = TableRegistry::getTableLocator()->get('Ratings');
        $tableServiceOrders = TableRegistry::getTableLocator()->get('ServiceOrders');
        
        $os = $tableServiceOrders->get($os_id);

        if($os->providers_id != $d->id){
            $this->responseStatus = false;
            $this->apiResponse = [
                'msg_erro' => 'Prestador não pode avaliar essa OS'
            ]; 
            return;
        }
        
        if(!$stars){
            $this->responseStatus = false;
            $this->apiResponse = [
                'msg_erro' => 'Pontuação não reconhecida'
            ]; 
            return;
        }

        $r                    = $tableRatings->newEntity();
        $r->companies_id      = 1;
        $r->service_orders_id = $os->id;
        $r->clients_id        = $os->clients_id;
        $r->providers_id      = $os->providers_id;
        $r->stars             = $stars;
        $r->type              = 'client';

        if($tableRatings->save($r)){
            $this->apiResponse = [
                'save' => true
            ];
            return;
        }

        $msg_erro = $this->ErrorList->errorInString($r->errors());

        $this->responseStatus = false;
        $this->apiResponse = [
                'msg_erro' => $msg_erro
            ]; 
            return;

    }

    /**
     * Atualiza do perfil do cliente
     */
    public function updateClient()
    {

        $token = $this->jwtPayload;
       
        $client = $this->Clients->get($token->id);

        if (!$client) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'person' => false,
                'msg_erro' => 'Cliente não encontrado'
            ];
            return;
        }

        $person = $this->People->get($client->person_id);

        if (!$person) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'person' => false,
                'msg_erro' => 'Cliente não encontrado'
            ];

            return;
        }

        $updates_person = [
            'name'           => false,
            'date_of_birth'  => false,
            'number_contact' => false,
            'address'        => false,
            'number'         => false,
            'district'       => false,
            'complement'     => false,
            'city'           => false,
            'state'          => false,
            'cep'            => true
        ];

        foreach ($updates_person as $key => $value) {
            if (!$this->request->data($key)) {
                continue;
            }

            $new_value_person = $value ? $this->removeCarcter($this->request->data($key)) : $this->request->data($key);

            if ($new_value_person == '') {
                continue;
            }

            $person->$key = $new_value_person;
        }


        if (!$this->People->save($person)) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'person' => false,
                'msg_erro' => $this->ErrorList->errorInString($person->errors())
            ];
            return;
        }

        $new_data = [
            'name'           => $person->name,
            'number_contact' => $person->number_contact,
            'address'        => $person->address,
            'number'         => $person->number,
            'district'       => $person->district,
            'complement'     => $person->complement,
            'city'           => $person->city,
            'state'          => $person->number_contact,
            'cep'            => $person->cep,
        ];

        $this->apiResponse = [
            'save' => true,
            'person' => $new_data,
            'msg_erro' => ''
        ];
    }

    /**
     * Cadastra um novo password para o cliente
     */
    public function newPassword(){
        $d = $this->jwtPayload;
        $client = $this->Clients->get($d->id);

        $key = $this->request->data('new_password');

        if(!$client){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Cliente não encontrado'
            ]; 
            return;
        }
       
        if(!$key || $key == ""){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Password não informado.'
            ]; 
            return;
        }
       
        if(strlen($key) < 6){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Password deve ter pelo menos 6 caracteres'
            ]; 
            return;
        }
      

        $tb_users = TableRegistry::get('Users');
        $user = $tb_users->find()
                ->where([
                    'person_id'      => $client->person_id,
                    'users_types_id' => 5,
                    'active'         => true
                ])
                ->first();
        
         if(!$user){
            $user = $tb_users->find()
            ->where([
                'person_id'      => $client->person_id,
                'users_types_id' => 6,
                'active'         => true
            ])
            ->first();
            
            if(!$user){
                $this->apiResponse = [
                    'save' => false,
                    'msg_erro' => 'Usuário não encontrado'
                ]; 
                return;
            }
        }

        $user->password = $key;
        
        if($tb_users->save($user)){
            
            $this->apiResponse = [
                'save' => true
            ];

            return;
        }

        $this->responseStatus = false;
        $this->apiResponse = [
            'save' => false,
            'msg_erro' => 'falha ao salvar usuário'
        ]; 
        return;
    }
  
    /**
     * Cadastra um novo login para o cliente
     */
    public function newLogin(){
        $d = $this->jwtPayload;
        $client = $this->Clients->get($d->id); 

        $key = $this->request->data('new_login');

        $check_email = Validation::email($key);

        if(!$client){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Cliente não encontrado'
            ]; 
            return;
        }
       
        if(!$key || $key == "" || $check_email == false){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'login informado não é um email válido.'
            ]; 
            return;
        }
       
        $tb_users = TableRegistry::get('Users');
        $user = $tb_users->find()
                ->where([
                    'person_id'      => $client->person_id,
                    'users_types_id' => 5,
                    'active'         => true
                ])
                ->first();
        
         if(!$user){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Usuário não encontrado'
            ]; 
            return;
        }
       
        $tb_person = TableRegistry::get('People');
        $person = $tb_person->get($client->person_id);
        
         if(!$person){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Pessoa não encontrada'
            ]; 
            return;
        }

        $user->email = $key;
        $person->email = $key;
        
        if($tb_users->save($user) && $tb_person->save($person)){
            
            $this->apiResponse = [
                'save' => true
            ];

            return;
        }
        
        $this->responseStatus = false;
        $this->apiResponse = [
            'save' => false,
            'msg_erro' => $this->ErrorList->errorInString($user->errors()).' - '.$this->ErrorList->errorInString($person->errors())
        ]; 
        return;
    }

    /**
     * Faz o upload da imagem do perfil do cliente
     */
    public function uploadProfile()
    {
        $d = $this->jwtPayload;
        $client = $this->Clients->get($d->$id);

        $this->apiResponse['TESTE'] = $d;
        return;
    }

    /**
     * Retorna a imagem de perfil cadastrada para o cliente 
     */
    public function getImageProfile(){
        $d = $this->jwtPayload;
        $client = $this->Clients->get($d->id); 
 
        if(!$client){
             $this->responseStatus = false;
             $this->apiResponse = [
                 'save' => false,
                 'msg_erro' => 'Cliente não encontrado'
             ]; 
 
             return;
         }
 
        $a = $this->S3Tools->getImage($client->image);
        header("Content-Type: {$a['ContentType']}");
        echo $a['Body'];
     }
}
