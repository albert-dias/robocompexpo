<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PerfilController extends AppController
{   

    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('People');
        $this->loadModel('UserRelationships');
        $this->loadModel('UsersCategories');
        $this->loadModel('Clients');
        $this->loadComponent('S3Tools');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
   


    public function index(){
        $id_user = $this->request->session()->read('Auth.User.id');
        return $this->redirect(['action' => 'view',$id_user]);
    }

    public function newPassword(){
        if($this->request->is(['patch', 'post', 'put'])){
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
                $this->Flash->error(__('CPF/E-mail incorreto'));
                return $this->redirect(['action' => 'login']);
            }

            $pas = $this->gerarSenha(8, true, true, true, false); 

            $user->password = $pas;

            if(!$tableUsers->save($user)){
                $this->Flash->error(__('Error ao salva. por favor tente novamente mas tarde'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Emails->sendEmailNewPassword([
                'email'    => $user->email,
                'name'     => $user->person->name,
                'password' => $pas
            ]);

            return $this->redirect(['action' => 'login']);
        }
    }

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
    

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $users = $this->request->session()->read('Auth.User');
        if(!($users["id"] == $id)){
            return $this->redirect(['controller'=>'pages','action' => 'index']);
        }
        // $this->d($users['id'] == $id);
        if($users['users_types_id'] != 5){
            // $this->d("aqui");
            $company_id = $this->current_Company();
           $user = $this->Users->get($id, [
                'contain' => ['People']
            ]);
                
                $this->set('user', $user);
        }elseif($users['id'] == $id){
            $user = $this->Users->get($id, [
                'contain' => ['People']
            ]);
            $this->set('user', $user);
        }else{
            return $this->redirect(['controller'=>'pages','action' => 'index']);
        }
        
        
        
    }

    



    

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $users = $this->request->session()->read('Auth.User');
        if(!($users["id"] == $id)){
            return $this->redirect(['controller'=>'pages','action' => 'index']);
        }
        if($users['users_types_id'] != 5){
            $company_id = $this->current_Company();
            $user_relationships = TableRegistry::get('user_relationships');
            
            $user = $this->Users->get($id, [
                'contain' => []
            ]);
            
            $People = $this->People->get($user->person_id, [
                'contain' => ['Users']
            ]);
            $person = $this->request->session()->read('Auth.User');
            $client =$this->searchClient($user->person_id);
            $this->addClient($People);
            

            $UsersCategories = $this->UsersCategories
            ->find('all')
            ->where(['user_id'=>$id])->toArray();
        }elseif($users['id'] == $id){
            $user = $this->Users->get($id, [
                'contain' => []
            ]);
            
            $People = $this->People->get($user->person_id, [
                'contain' => ['Users']
            ]);
            $person = $this->request->session()->read('Auth.User');
            $client =$this->searchClient($user->person_id);
            $this->addClient($People);
        }else{
            return $this->redirect(['controller'=>'pages','action' => 'index']);
        }

        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            // $this->d($data);
            if($data['cpf'] == 14){
                if(!($this->validaCPF($data['cpf']))){
                    $this->Flash->error(__('CPF não é valido'));
                    return $this->redirect(['action' => 'index']);
                }
            }else{
                if(!($this->validaCNPJ($data['cpf']))){
                    $this->Flash->error(__('CNPJ não é valido'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            
            $data['cpf'] = str_replace(".", "", str_replace("-", "", $data['cpf']));
            if(isset($data['rg'])){
                $data['rg'] = str_replace(".", "", str_replace("-", "", $data['rg']));
            }
            $data['cep'] = str_replace(".", "", str_replace("-", "", $data['cep']));
            $data['number_contact'] = str_replace("(", "", str_replace(")", "", str_replace(" ", "",  str_replace("-", "", $data['number_contact']))));
            $arracoordenadas = $this->Coord(str_replace(" ","+",$data['number'])."+".str_replace(" ","+",$data['address'])
            .",+".str_replace(" ","+",$data['district']).",+".str_replace(" ","+",$data['city']));
            if(strlen($data['cpf']) == 11){
                $datainicial = new \DateTime($data['date_of_birth']);
                $datafinal = new \DateTime(date('Y-m-d'));
                $invertal = $datainicial->diff($datafinal);
                if($invertal->format( '%Y' ) < 18){
                    $this->Flash->error(__('Colaborado precisa ter maior de 18 anos.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            $People = $this->People->patchEntity($People, $data);
            $People->latitude = $arracoordenadas['lat'];
            $People->longitude = $arracoordenadas['lng'];
            $People->active = true;
            $People = $this->People->save($People);
            if ($People) {
                if(!empty($data["senha"])){
                    $data["password"] = $data["senha"];
                }
                $user = $this->Users->patchEntity($user, $data);
                $user->cpf = $data['cpf'];
                $user_id = $this->Users->save($user);
                if($user_id){
                    if($person['users_types_id'] != 5){
                        // foreach ($UsersCategories as $value) {
                        //     $id_UsersCategories = $value->id;
                        //     $id_categorie =  $value->categorie_id;
                        //     if(!in_array($id_categorie,$data['categories'])){
                        //         $aux = $this->UsersCategories->get($id_UsersCategories, [
                        //             'contain' => []
                        //             ]);
                        //         $this->UsersCategories->delete($aux);
                        //     }
                        // }
                        $user_id = $user_id->id;
                        // $this->d();
                        $this->UsersCategories->deleteAll([
                            'user_id'=>$user_id,
                            'categorie_id NOT IN'=> $data['categories']
                        ]);
                        
                        foreach ($data['categories'] as  $value) {
                            $users_categories =  $this->UsersCategories->newEntity();
                            $users_categories->user_id = $user_id;
                            $users_categories->categorie_id = $value;
                            if(!in_array($value,array_column($UsersCategories,"categorie_id"))){
                                if(!$this->UsersCategories->save($users_categories)){
                                    $this->Flash->error(__('Usuário não pode ser salvo. Por favor, tente novamente.'));
                                }
                            }
                            
                        }
                        
                    }   
                        //salvar foto do perfil
                        

                        
                    
                    $this->uploadProfile($client);
                    $this->Flash->success(__('Usuário salvo com sucesso.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Usuário não pode ser salvo. Por favor, tente novamente.'));
                return $this->redirect(['action' => 'index']);
            }
            
        }
        $this->set(compact('People','avatar','user'));
        if($person['users_types_id'] == 5){     
            $this->render('edit_gerador');
            return null;
        }
        $person = $this->request->session()->read('Auth.User');
            // UsersCategories
            $option_select_query = $this->query("SELECT * FROM users_categories as uc INNER JOIN categories as c ON c.id = uc.categorie_id WHERE uc.user_id =".$id);
            $option_mult_query = $this->query("SELECT id, `name` FROM `categories`");

            $option_mult = [];
            $option_select = [];
            foreach ($option_select_query as $key => $value) {
                $option_select[$key] = $value->id;
            }
            foreach ($option_mult_query as  $value) {
                $option_mult[$value->id] = $value->name;
            }
            


            $this->set(compact('option_mult','option_select'));
           if($person['plan_id'] == 5 || $person['plan_id'] == 4){
            $this->render('edit_associacao_reciclador');
           }else{
            $this->render('edit_plans_basic');
           }
        
    }

    

    private function Coord($endereco){
        // ini_set('allow_url_fopen', true);
        // ini_set('allow_url_include', true);
        // # https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y
        // $json_file = file_get_contents($this->myUrlEncode("https://maps.googleapis.com/maps/api/geocode/json?address=".$endereco."&key=AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y"));
        // var_dump(ini_get('allow_url_fopen'));
        // var_dump(ini_get('allow_url_include'));
        // var_dump($this->myUrlEncode("https://maps.googleapis.com/maps/api/geocode/json?address=".$endereco."&key=AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y"));
        // var_dump($json_file);
        // exit();
        // $json_str = json_decode($json_file, true);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->myUrlEncode("https://maps.googleapis.com/maps/api/geocode/json?address=".$endereco."&key=AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $json_str = json_decode( $response, true );
        $itens = $json_str['results'][0]['geometry']['location'];
        return $itens;
    }

    
    private function searchClient($person_id){

        $client = $this->Clients->find()->where([
            'person_id'=> $person_id
        ])->first();

        return $client;
    }


    private function addClient($person)
    {
        $c = $this->searchClient($person->id);


        if($c){
            return null;
        }
        $data = $this->request->getData();
        $client = $this->Clients->newEntity();
        $data_client['companies_id'] = $person->company_id;
        $data_client['person_id'] = $person->id;
        $data_client['acting_region'] = 'RN';
        $data_client['active'] = true;
        $data_client['plan_id'] = isset($data['plan_id']) ? $data['plan_id'] : null;
        $client = $this->Clients->patchEntity($client, $data_client);
        $this->Clients->save($client);
        
    }
    
    /**
     * Organiza o upload.
     * @access public
     * @param Array $imagem
     * @param String $data
     */
    private function upload($id)
    {

        $user = $this->Users->get($id,
            [
            'conditions' => [
                'Users.company_id' => $this->request->session()->read('Auth.User.company_id')
            ]
        ]);

        $this->request->session()->write('Upload',
            [
            'table'         => 'Users',
            'column'        => 'image',
            'dir'           => 'users',
            'max_files'     => 1,
            'max_file_size' => 1000000,
            'download'      => true,
            'types_file'    => ['jpe?g', 'png'],
            'id'            => $id
        ]);

        $this->set('user', $user);
    }
  
    private function uploadProfile($client)
    {
        $client = $this->Clients->get($client->id);

        if (!$client) {
            $this->Flash->error(__('Erro imagem não foi salva!'));
            return $this->redirect(['action' => 'add']);
        }
        if($_FILES['perfil']["tmp_name"] == ''){
            return;
        }
     

        $data['file'] = $_FILES['perfil']["tmp_name"];
        $data['info'] = pathinfo($_FILES['perfil']["name"]);
        $data['ext']  = $data['info']['extension'];
        
        $path =  "clients/" . $client->id . "/perfil." . $data['ext'];

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
            $client->image = $path;

            if ($this->Clients->save($client)) {
                if($client->person_id == $this->request->session()->read('Auth.User.person.id')){
                    $this->request->session()->write('Auth.User.image',$this->S3Tools->getUrlTemp($client->image,120));
                }
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

    private function uploadlocation($client){
        $data['file'] = $_FILES['perfil']["tmp_name"];
        $arquivo_tmp = $_FILES['perfil']['tmp_name'];
        $data['info'] = pathinfo($_FILES['perfil']["name"]);

        $data['ext']  = $data['info']['extension'];
        $path =  "clients/" . $client->id . "/perfil." . $data['ext'];
        

    }

    


}
