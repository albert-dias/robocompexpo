<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Validation\Validation;
use RestApi\Controller\ApiController;


/**
 * Providers Controller
 *
 * @property \App\Model\Table\ProvidersTable $Providers
 *
 * @method \App\Model\Entity\Provider[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProvidersController extends ApiController
{

    public function initialize() {
        $this->loadComponent('Rating');
        $this->loadComponent('S3Tools');
        $this->loadComponent('ErrorList');
        parent::initialize();
    }

    /**
     * Devolve valor de avaliação do prestador
     */
    public function rating (){
        $d = $this->jwtPayload;
        
        $provider = $this->Providers->get($d->id);

        $r = $this->Rating->ratingProvider($provider->id);
        if($r == 0 ){
            $this->apiResponse = "sem_avaliacoes";
            return;
        }

        $this->apiResponse = $r;
    }

    /**
     * Cadastra um novo passwaord para o prestador
     */
    public function newPassword(){
        $d = $this->jwtPayload;
        $provider = $this->Providers->get($d->id); 

        $key = $this->request->data('new_password');

        if(!$provider){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Prestador não encontrado'
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
       
        if(strlen($key) < 8){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Password deve ter pelo menos 8 caracteres'
            ]; 
            return;
        }
      

        $tb_users = TableRegistry::get('Users');
        $user = $tb_users->find()
                ->where([
                    'person_id'      => $provider->person_id,
                    'users_types_id' => 4,
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
     * Cadastra um novo login para o prestador
     */
    public function newLogin(){
        $d = $this->jwtPayload;
        $provider = $this->Providers->get($d->id); 

        $key = $this->request->data('new_login');

        $check_email = Validation::email($key);

        if(!$provider){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Prestador não encontrado'
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
                    'person_id'      => $provider->person_id,
                    'users_types_id' => 4,
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
        $person = $tb_person->get($provider->person_id);
        
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
     * Retorna a imagem de perfil cadastrada para o prestador 
     */
    public function getImageProfile(){
       $d = $this->jwtPayload;
       $provider = $this->Providers->get($d->id); 

       if(!$provider){
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Prestador não encontrado'
            ]; 

            return;
        }

       $a = $this->S3Tools->getImage($provider->image);
       header("Content-Type: {$a['ContentType']}");
       echo $a['Body'];
    }

    /**
     * Faz o upload da imagen do perfil do prestador
     */
    public function uploadProfile()
    {
        $d = $this->jwtPayload;
        $provider = $this->Providers->get($d->id);

        if (!$provider) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Prestador não encontrado'
            ];

            return;
        }
     

        $data['file'] = $_FILES['perfil']["tmp_name"];
        $data['info'] = pathinfo($_FILES['perfil']["name"]);
        $data['ext']  = $data['info']['extension'];
        
        $path =  "providers/" . $provider->id . "/perfil." . $data['ext'];

        if ($data['ext'] != 'jpg' && $data['ext'] != 'png' && $data['ext'] != 'jpeg') {
            $this->responseStatus = false;
            $this->apiResponse =  [
                'save' => false,
                'path' => null,
                'msg_erro' => 'Extensão da imagem deve ser PNG ou JPG'
            ];
            return;
        }
       
        $result = $this->S3Tools->upImage($path, $data['file']);

        if ($result['@metadata']['statusCode'] == 200) {
            $provider->image = $path;

            if ($this->Providers->save($provider)) {
                $a = $this->S3Tools->getImage($provider->image);
                header("Content-Type: {$a['ContentType']}");
                echo $a['Body'];
                return;
            }

            $this->responseStatus = false;
            $this->apiResponse =   [
                'save' => false,
                'path' => null,
                'msg_erro' => 'Erro ao salvar a imagem no banco'
            ];
        }

        $this->responseStatus = false;
        $this->apiResponse =   [
            'save' => false,
            'path' => null,
            'msg_erro' => 'Falha ao fazer upload de ' . $path
        ];
    }
    
    /**
     * Cadastrar avaliação do cliente para o prestador
     */
    public function insertRating(){
        $d = $this->jwtPayload;
        
        $os_id = $this->request->data('os_id');
        $stars = $this->request->data('stars');

        $tableRatings       = TableRegistry::getTableLocator()->get('Ratings');
        $tableServiceOrders = TableRegistry::getTableLocator()->get('ServiceOrders');
        
        $os = $tableServiceOrders->get($os_id);

        if($os->clients_id != $d->id){
            $this->responseStatus = false;
            $this->apiResponse = [
                'msg_erro' => 'Cliente não pode avaliar essa OS'
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
        $r->type              = 'provider';

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
}
