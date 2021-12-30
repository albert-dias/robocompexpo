<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Auth\DefaultPasswordHasher;
use RestApi\Utility\JwtToken;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('People');
        $this->loadModel('Plans');
        $this->loadModel('UserRelationships');
        $this->loadModel('UsersCategories');
        $this->loadModel('Clients');
        $this->loadComponent('S3Tools');
        $this->loadComponent('Emails');
        $this->loadComponent('RequestHandler');
        $usertype = $this->request->session()->read('Auth.User.users_types_id');
        $this->set(compact('usertype'));
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $name          = isset($this->request->data['name']) ? $this->request->data['name'] : NULL;
        $email         = isset($this->request->data['email']) ? $this->request->data['email'] : NULL;
        $cpf         = isset($this->request->data['cpf']) ? $this->request->data['cpf'] : NULL;
        $users_types_id = isset($this->request->data['users_types_id']) ? $this->request->data['users_types_id'] : NULL;
        $plan_id = isset($this->request->data['plan_id']) ? $this->request->data['plan_id'] : NULL;

        $conditions['Users.company_id'] = $this->request->session()->read('Auth.User.company_id');
        $conditions['UsersTypes.public']  = true;
        $conditions['Users.users_types_id'] = 6;
        // $conditions['Users.plan_id IS NOT'] = null;

        if ($email) {
            $conditions['Users.email'] = $email;
        }
        if ($cpf) {
            $conditions['Users.cpf'] = $cpf;
        }

        if ($name) {
            $conditions['Users.name LIKE '] = "%$name%";
        }

        if ($plan_id) {
            $conditions['Users.plan_id'] = $plan_id;
        }

        $this->paginate = [
            'contain'       => ['Companies', 'UsersTypes','People','Plans'],
            'conditions' => $conditions,
            'sortWhitelist' => [
                'UsersTypes.type' => 'type',
                'Users.email'     => 'email',
                'Users.name'      => 'name',
                'Users.id'        => 'id'
            ]
        ];
        $users = $this->paginate($this->Users, ['limit' => 10, 'order' => array( // sets a default order to sort by
            'id' => 'desc'
        )]);
        $plans = $this->Users->Plans->find('list')->all();
        $cliente = null;
        foreach ($users as $user){
            if($user->id != 1){

                $cliente = $this->Clients->find('all')->where(["person_id"=>$user->person_id])->first();

                if($cliente != null){
                    if($cliente['image'] != null){
                        $user->photo =$this->S3Tools->getUrlTemp($cliente['image'], 120);
                    }
                }
            }

        }

        $this->set(compact('users', 'plans'));
    }
    public function cliente()
    {

        $name          = isset($this->request->data['name']) ? $this->request->data['name'] : NULL;
        $email         = isset($this->request->data['email']) ? $this->request->data['email'] : NULL;
        $cpf         = isset($this->request->data['cpf']) ? $this->request->data['cpf'] : NULL;
        $plan_id = isset($this->request->data['plan_id']) ? $this->request->data['plan_id'] : NULL;

        $conditions['Users.company_id'] = $this->request->session()->read('Auth.User.company_id');
        $conditions['UsersTypes.public']  = true;
        $conditions['Users.users_types_id'] = 5;
        // $conditions['Users.plan_id IS NOT'] = null;

        if ($email) {
            $conditions['Users.email'] = $email;
        }
        if ($cpf) {
            $conditions['Users.cpf'] = $cpf;
        }

        if ($name) {
            $conditions['Users.name LIKE '] = "%$name%";
        }

        if ($plan_id) {
            $conditions['Users.plan_id'] = $plan_id;
        }

        $this->paginate = [
            'contain'       => ['Companies', 'UsersTypes','People','Plans'],
            'conditions' => $conditions,
            'sortWhitelist' => [
                'UsersTypes.type' => 'type',
                'Users.email'     => 'email',
                'Users.name'      => 'name',
                'Users.id'        => 'id'
            ]
        ];
        $users = $this->paginate($this->Users, ['limit' => 10, 'order' => array( // sets a default order to sort by
            'id' => 'desc'
        )]);

        $plans = $this->Users->Plans->find('list')->all();
        $cliente = null;
        foreach ($users as $user){
            if($user->id != 1){

                $cliente = $this->Clients->find('all')->where(["person_id"=>$user->person_id])->first();

                if($cliente != null){
                    if($cliente['image'] != null){
                        $user->photo =$this->S3Tools->getUrlTemp($cliente['image'], 120);
                    }
                }
            }

        }


        $this->set(compact('users', 'plans'));
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
        $user = $this->Users->get($id, [
            'contain' => ['Companies', 'UsersTypes','People']
        ]);

        $this->Can->check($user->company_id);
        if($user->plan_id){
            $user->plan = $this->query("SELECT p.title FROM plans as p WHERE p.id = $user->plan_id")[0];
        }
        $UsersCategories = $this->query("SELECT * from users_categories as uc left join categories as c on c.id = uc.categorie_id where uc.user_id = $id");
        $this->set(compact('user','UsersCategories'));
    }

    // public function lists($tipo){
    public function lists(){
        $users = $this->query("SELECT * FROM Users WHERE users_types_id = 5 OR users_types_id = 6 AND active = 1");
        $usersTypes = $this->query("SELECT type FROM users_types WHERE 1");
        $plans = $this->query("SELECT title FROM plans WHERE 1");

        $this->set(compact(
            'users',
            'usersTypes',
            'plans'
        ));
        // $this->d($users);
    }
    // Retorna as empresas com cadastro já ativado
    public function activetecnic(){
        $users = $this->query("SELECT * FROM users WHERE users_types_id = 6 AND active = 1");
        $usersTypes = $this->query("SELECT type FROM users_types WHERE id = 6");
        $plans = $this->query("SELECT title FROM plans WHERE 1");

        $this->set(compact(
            'users',
            'usersTypes',
            'plans'
        ));
    }
    // Retorna os usuários com cadastro já ativado
    public function activeclient(){
        $users = $this->query("SELECT * FROM users WHERE users_types_id = 5 AND active = 1");
        $usersTypes = $this->query("SELECT type FROM users_types WHERE id = 5");
        $plans = $this->query("SELECT title FROM plans WHERE 1");

        $this->set(compact(
            'users',
            'usersTypes',
            'plans'
        ));
    }
    public function total(){
        $users = $this->query("SELECT * FROM users WHERE (users_types_id = 5 OR users_types_id = 6) AND active = 1");
        $usersTypes = $this->query("SELECT type FROM users_types WHERE id = 5");
        $plans = $this->query("SELECT title FROM plans WHERE 1");

        $this->set(compact(
            'users',
            'usersTypes',
            'plans'
        ));
    }
    // Retorna as empresas com cadastro inativado
    public function inactivetecnic(){
        $users = $this->query("SELECT * FROM users WHERE users_types_id = 6 AND active = 0");
        $usersTypes = $this->query("SELECT type FROM users_types WHERE id = 6");
        $plans = $this->query("SELECT title FROM plans WHERE 1");

        $this->set(compact(
            'users',
            'usersTypes',
            'plans'
        ));
    }
    // Retorna os usuários com cadastro inativado
    public function inactiveclient(){
        $users = $this->query("SELECT * FROM users WHERE users_types_id = 5 AND active = 0");
        $usersTypes = $this->query("SELECT type FROM users_types WHERE id = 5");
        $plans = $this->query("SELECT title FROM plans WHERE 1");

        $this->set(compact(
            'users',
            'usersTypes',
            'plans'
        ));
    }

    public function listJson($tipo){
                $data = $this->request->getData();
                $where = null;
                if($tipo == 'active'){
                    $where = "WHERE u.active = true";
                }elseif ($tipo == 'inactive') {
                    $where = "WHERE u.active = false";
                }
                if(isset($data['users_types_id']) && isset($data['plan_id'])){
                    if($data['users_types_id'] != '' && $data['plan_id'] != ''){
                        $where .= " AND p.id = '".$data['plan_id']."' AND ut.id = '".$data['users_types_id']."'";
                    }elseif ($data['users_types_id'] != '') {
                        $where .= " AND ut.id = '".$data['users_types_id']."'";
                    }elseif ($data['plan_id'] != '') {
                        $where .= " AND p.id = '".$data['plan_id']."'";
                    }
                }

                $users = $this->query("SELECT u.name,ut.type,p.id,c.image,u.id, p.title  FROM users as u
                INNER JOIN people as person ON person.id = u.person_id
                INNER JOIN clients as c ON c.person_id = person.id
                INNER JOIN users_types as ut ON u.users_types_id = ut.id
                INNER JOIN plans as p ON p.id = u.plan_id $where");

                foreach ($users as $value) {
                    if($value->image){
                        $value->image = $this->S3Tools->getUrlTemp($value->image, 120);
                    }else{
                        $value->image = $this->request->getAttribute("webroot")."webroot/assets/images/sem-fotos.png";
                    }
                    $value->option = null;
                }

                $json = $this->datatableQueryjsontojson($users,$data);
                $this->set('json',$json);
                $this->set('_serialize',array('json'));
                $this->response->statusCode(200);
    }

    public function newuser(){

    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($is_externo = null)
    {
        $user = $this->Users->newEntity();
        $People = $this->People->newEntity();
        if ($this->request->is('post')) {
            if($is_externo){
                $this->request->data['plan_id'] = 1;
            }
            $data = $this->request->getData();

            $data['cpf'] = str_replace(".", "", str_replace("-", "", str_replace("/", "", $data['cpf'])));
            if(strlen($data['cpf']) != 14){
                $this->Flash->error(__('Por enquanto apenas cadastro por CNPJ podem ser feitos'));
                return $this->redirect(['action' => 'login']);
            }
            if(isset($data['rg'])){
                $data['rg'] = str_replace(".", "", str_replace("-", "", $data['rg']));
            }
            $data['cep'] = str_replace(".", "", str_replace("-", "", $data['cep']));
            $data['number_contact'] = str_replace("(", "", str_replace(")", "", str_replace(" ", "",  str_replace("-", "", $data['number_contact']))));
            if(!isset( $data['date_of_birth'])){
                $data['date_of_birth'] = date('Y-m-d');
            }

            $People = TableRegistry::get('people');
            $users = TableRegistry::get('users');
            //checar se usuario já existe
            $check = $this->query("SELECT COUNT(*) as `check`, id FROM `users` WHERE cpf =".$data['cpf'])[0];
            if($check->check != 0){

                $user_relationships = TableRegistry::get('user_relationships');
                $user = $user_relationships
                        ->find('all')
                        ->where(['user_id'=>$check->id])
                        ->order(['user_id' => 'DESC'])
                        ->toArray();

                if(empty($user)){
                    if ($user['active']) {
                        $this->Flash->info(__('CPF cadastrado em outra empresa.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    $user_id = $check->id;
                    $company_id = $check->id;
                    $this->user_relationships($user_id,$company_id,$data['plan_id']);
                    return $this->redirect(['action' => 'index']);
                }else{
                    $user_id = $check->id;
                    $company_id = $check->id;
                    $this->user_relationships($user_id,$company_id,$data['plan_id']);
                    return $this->redirect(['action' => 'index']);
                }

            }
            // cadastra dados para tabela people

            $People = $this->People->newEntity();
            $People->name = $data['name'];
            $People->cpf = $data['cpf'];
            $People->rg = isset($data['rg']) ? $data['rg'] : NULL;
            $People->city = $data['city'];
            $People->email = $data['email'];
            $People->institution_rg = isset($data['institution_rg']) ? $data['institution_rg'] : NULL;
            $People->date_of_birth = isset($data['date_of_birth']) ? $data['date_of_birth'] : NULL;
            $People->number_contact = $data['number_contact'];
            $People->cep = $data['cep'];
            $People->address = $data['address'];
            $People->number = $data['number'];
            $People->complement = $data['complement'];
            $People->district = $data['district'];
            $People->state = $data['state'];
            $People->gender = isset($data['gender']) ? $data['gender'] : NULL;
            // $arracoordenadas = $this->Coord(str_replace(" ","+",$data['number']).str_replace(" ","+",$data['address'])
            // .",+".str_replace(" ","+",$data['district']).",+".str_replace(" ","+",$data['city']));
            $People->latitude = $data['lat'];
            $People->longitude = $data['lng'];
            $people_id = $this->People->save($People);
            if ($people_id) {
                $this->addClient($people_id);
                $users = $this->Users->newEntity();
                $users->company_id = 1;
                $users->person_id = $people_id->id;

                $users->name = $data['name'];
                $users->email = $data['email'];
                $users->nickname = isset($data['nickname']) ? $data['nickname'] : NULL;
                $users->users_types_id = 6;
                if($is_externo){
                    $users->plan_id = 0;
                    $users->active = false;
                    $this->request->data['plan_id'] = 0;
                }else{
                    $users->plan_id = $data['plan_id'];
                    $users->active = true;
                }
                $users->cpf = $data['cpf'];
                $users->num_rating = 0;
                $users->tot_rating = 0;
                $users->password = $data['password'];
                $user_id = $this->Users->save($users);
                if ($user_id) {
                    //salvar foto do perfil
                    $client =$this->searchClient($people_id->id);
                    $this->uploadProfile($client);
                    $user_id = $user_id->id;
                    $data_categories = [];
                    foreach ($data['categories'] as  $value) {
                            $UsersCategories =  $this->UsersCategories->newEntity();
                            $UsersCategories->user_id = $user_id;
                            $UsersCategories->categorie_id = $value;
                            $this->UsersCategories->save($UsersCategories);

                    }
                    $this->Emails->sendEmailBemVindo([
                        'email'    => $data['email'],
                        'name'     => $data['name']
                    ]);
                    if(!$is_externo){
                        return $this->redirect(['action' => 'index']);
                    }else{
                        return;
                    }
                }
                $this->Flash->error(__('Error ao salva'));
                return $this->redirect(['action' => 'index']);

            }
        }
        $option_mult_query = $this->query("SELECT id, `name` FROM `categories`");
            $option_mult = [];

            foreach ($option_mult_query as  $value) {
                $option_mult[$value->id] = $value->name;
            }
        $companies = $this->Users->Companies->find('list', ['limit' => 200]);
        $usersTypes = $this->Users->UsersTypes->find('list', ['limit' => 200])->where(['public' => true]);
        $plans = $this->Users->Plans->find('list', ['limit' => 200]);
        $estadoUF = array(
            'AC'=>'Acre',
            'AL'=>'Alagoas',
            'AP'=>'Amapá',
            'AM'=>'Amazonas',
            'BA'=>'Bahia',
            'CE'=>'Ceará',
            'DF'=>'Distrito Federal',
            'ES'=>'Espírito Santo',
            'GO'=>'Goiás',
            'MA'=>'Maranhão',
            'MT'=>'Mato Grosso',
            'MS'=>'Mato Grosso do Sul',
            'MG'=>'Minas Gerais',
            'PA'=>'Pará',
            'PB'=>'Paraíba',
            'PR'=>'Paraná',
            'PE'=>'Pernambuco',
            'PI'=>'Piauí',
            'RJ'=>'Rio de Janeiro',
            'RN'=>'Rio Grande do Norte',
            'RS'=>'Rio Grande do Sul',
            'RO'=>'Rondônia',
            'RR'=>'Roraima',
            'SC'=>'Santa Catarina',
            'SP'=>'São Paulo',
            'SE'=>'Sergipe',
            'TO'=>'Tocantins'
            );
        $this->set(compact(
            'user',
            'companies',
            'usersTypes',
            'plans',
            'People',
            'option_mult',
            'estadoUF',
            'is_externo'
        ));
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

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['cpf'] = str_replace(".", "", str_replace("-", "",str_replace("/","",$data['cpf'])));
            $data['rg'] = str_replace(".", "", str_replace("-", "", $data['rg']));
            $data['cep'] = str_replace(".", "", str_replace("-", "", $data['cep']));
            $data['number_contact'] = str_replace("(", "", str_replace(")", "", str_replace(" ", "",  str_replace("-", "", $data['number_contact']))));

            $arracoordenadas = $this->Coord(str_replace(" ","+",$data['number']).str_replace(" ","+",$data['address'])
            .",+".str_replace(" ","+",$data['district']).",+".str_replace(" ","+",$data['city']));
            $People = $this->People->patchEntity($People, $data);
            $People->latitude = $arracoordenadas['lat'];
            $People->longitude = $arracoordenadas['lng'];
            $person = $this->People->save($People);
            if ($person) {
                $is_active_old = $user->active;
                $user = $this->Users->patchEntity($user, $this->request->getData());
                $user->active =  $data['active'];
                $user->plan_id = $data['plan_id'];
                $user_id = $this->Users->save($user);
                if($user_id){
                    foreach ($UsersCategories as $value) {
                        $id_categorie = $value->id;
                        $aux = $this->UsersCategories->get($id_categorie, [
                            'contain' => []
                        ]);
                        $this->UsersCategories->delete($aux);
                    }
                    $user_id = $user_id->id;
                    foreach ($data['categories'] as  $value) {
                        $UsersCategories =  $this->UsersCategories->newEntity();
                        $UsersCategories->user_id = $user_id;
                        $UsersCategories->categorie_id = $value;
                        if(!$this->UsersCategories->save($UsersCategories)){
                                $this->Flash->error(__('Usuário não pode ser salvo. Por favor, tente novamente. (cod C01)'));
                        }
                    }
                    //salvar foto do perfil
                    $this->uploadProfile($client);
                    if($is_active_old == false && $data['active'] == true){
                        $this->Emails->sendEmailUserLiberado(array("name"=>$People->name,"email"=>$People->email));
                    }
                    $this->Flash->success(__('Usuário salvo com sucesso.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Usuário não pode ser salvo. Por favor, tente novamente. (cod U01)'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Usuário não pode ser salvo. Por favor, tente novamente. (cod P01)'));
        }
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
        $estadoUF = array(
            'AC'=>'Acre',
            'AL'=>'Alagoas',
            'AP'=>'Amapá',
            'AM'=>'Amazonas',
            'BA'=>'Bahia',
            'CE'=>'Ceará',
            'DF'=>'Distrito Federal',
            'ES'=>'Espírito Santo',
            'GO'=>'Goiás',
            'MA'=>'Maranhão',
            'MT'=>'Mato Grosso',
            'MS'=>'Mato Grosso do Sul',
            'MG'=>'Minas Gerais',
            'PA'=>'Pará',
            'PB'=>'Paraíba',
            'PR'=>'Paraná',
            'PE'=>'Pernambuco',
            'PI'=>'Piauí',
            'RJ'=>'Rio de Janeiro',
            'RN'=>'Rio Grande do Norte',
            'RS'=>'Rio Grande do Sul',
            'RO'=>'Rondônia',
            'RR'=>'Roraima',
            'SC'=>'Santa Catarina',
            'SP'=>'São Paulo',
            'SE'=>'Sergipe',
            'TO'=>'Tocantins'
            );


        $companies = $this->Users->Companies->find('list', ['limit' => 200]);
        $usersTypes = $this->Users->UsersTypes->find('list', ['limit' => 200])->where(['public' => true]);
        $plans = $this->Users->Plans->find('list', ['limit' => 200]);
        $id_plans = $user->plan_id;
        $this->set(compact('user', 'companies', 'usersTypes','People','option_mult','option_select','plans','id_plans','estadoUF'));
    }

    public function addtecnico(){
        $is_externo = true;
        if($this->request->is(['post'])){

            $this->add($is_externo);
            $this->Flash->success(__('Seu cadastro foi realizado com sucesso! Dentro de minutos você irá receber um e-mail com mais informações'));

            return $this->redirect(['action' => 'login']);
        }
        $this->add($is_externo);
        $this->render('add');
    }

    public function addcliente()
    {
        $user = $this->Users->newEntity();
        $People = $this->People->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if(!$data['termopriv']){
                $this->set('msg',"Você precisa aceita os termos de uso e política de privacidade !");
                $this->set('_serialize',array('msg'));
                $this->response->statusCode(500);
                return null;
            }
            $data['cpf'] = str_replace(".", "", str_replace("-", "", str_replace("/", "", $data['cpf'])));
            if(!isset( $data['date_of_birth'])){
                $data['date_of_birth'] = date('Y-m-d');
            }
            $data['cep'] = str_replace(".", "", str_replace("-", "", $data['cep']));
            $data['number_contact'] = str_replace("(", "", str_replace(")", "", str_replace(" ", "",  str_replace("-", "", $data['number_contact']))));
            $People = TableRegistry::get('people');
            $users = TableRegistry::get('users');
            //checar se usuario já existe
            $check = $this->query("SELECT COUNT(*) as `check`, id FROM `users` WHERE cpf =".$data['cpf'])[0];
            if($check->check != 0){
                $this->set('msg','CPF/CNPJ já cadastrado!');
                $this->set('_serialize',array('msg'));
                $this->response->statusCode(500);
                return null;
            }
            // cadastra dados para tabela people

            $People = $this->People->newEntity();
            if(isset($data['gender']) && isset($data['rg']) && isset($data['institution_rg'])){
                $data['rg'] = str_replace(".", "", str_replace("-", "", $data['rg']));
                $People->gender = $data['gender'];
                $People->rg = $data['rg'];
                $People->institution_rg = $data['institution_rg'];
            }else{
                $this->request->data['plan_id'] = 1;
                $data['plan_id'] = 1;
            }
            $People->name = $data['name'];
            $People->cpf = $data['cpf'];
            $People->city = $data['city'];
            $People->email = $data['email'];
            $People->date_of_birth = $data['date_of_birth'];
            $People->number_contact = $data['number_contact'];
            $People->cep = $data['cep'];
            $People->address = $data['address'];
            $People->number = $data['number'];
            $People->complement = $data['complement'];
            $People->district = $data['district'];
            $People->state = $data['state'];
            $People->gender = "N";
            // $arracoordenadas = $this->Coord(str_replace(" ","+",$data['number']).str_replace(" ","+",$data['address'])
            // .",+".str_replace(" ","+",$data['district']).",+".str_replace(" ","+",$data['city']));
            $People->latitude = $data['lat'];
            $People->longitude = $data['lng'];

            $people_id = $this->People->save($People);
            if ($people_id) {
                $this->addClient($people_id);
                $users = $this->Users->newEntity();
                $users->company_id = 1;
                $users->person_id = $people_id->id;
                $users->active = true;
                $users->name = $data['name'];
                $users->email = $data['email'];
                $users->nickname = isset($data['nickname']) ? $data['nickname'] : NULL;
                $users->users_types_id = 5;
                $users->plan_id = $data['plan_id'];
                $users->cpf = $data['cpf'];
                $users->password = $data['password'];
                $user_id = $this->Users->save($users);
                if ($user_id) {
                    //salvar foto do perfil
                    $client =$this->searchClient($people_id->id);
                    $this->uploadProfile($client);
                    $this->Flash->success(__('Seu cadastro foi realizado com sucesso! Dentro de minutos você irá receber um e-mail com mais informações'));
                    $this->Emails->sendEmailBemVindo([
                        'email'    =>  $data['email'],
                        'name'     => $data['name']
                    ]);
                    $this->set('msg','Cadastro salvo com sucesso!');
                    $this->set('_serialize',array('msg'));
                    $this->response->statusCode(200);
                    return null;
                }
                $this->set('msg','Usuário não pode ser cadastrado');
                $this->set('_serialize',array('msg'));
                $this->response->statusCode(500);
                return null;

            }else{
                $this->set('msg','Pessoa não pode ser cadastrado');
                $this->set('_serialize',array('msg'));
                $this->response->statusCode(500);
                return null;
            }
        }

        $companies = $this->Users->Companies->find('list', ['limit' => 200]);
        $usersTypes = $this->Users->UsersTypes->find('list', ['limit' => 200])->where(['public' => true]);
        $plans = $this->Users->Plans->find('list', ['limit' => 200]);
        $estadoUF = array(
            'AC'=>'Acre',
            'AL'=>'Alagoas',
            'AP'=>'Amapá',
            'AM'=>'Amazonas',
            'BA'=>'Bahia',
            'CE'=>'Ceará',
            'DF'=>'Distrito Federal',
            'ES'=>'Espírito Santo',
            'GO'=>'Goiás',
            'MA'=>'Maranhão',
            'MT'=>'Mato Grosso',
            'MS'=>'Mato Grosso do Sul',
            'MG'=>'Minas Gerais',
            'PA'=>'Pará',
            'PB'=>'Paraíba',
            'PR'=>'Paraná',
            'PE'=>'Pernambuco',
            'PI'=>'Piauí',
            'RJ'=>'Rio de Janeiro',
            'RN'=>'Rio Grande do Norte',
            'RS'=>'Rio Grande do Sul',
            'RO'=>'Rondônia',
            'RR'=>'Roraima',
            'SC'=>'Santa Catarina',
            'SP'=>'São Paulo',
            'SE'=>'Sergipe',
            'TO'=>'Tocantins'
            );
        $this->set(compact('user', 'companies', 'usersTypes','plans','People','estadoUF'));
    }
    public function editcliente($id)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $People = $this->People->get($user->person_id, [
            'contain' => ['Users']
        ]);
        $person = $this->request->session()->read('Auth.User');
        $client =$this->searchClient($user->person_id);
        $this->addClient($People);
        if ($this->request->is('put','post')) {
            $data = $this->request->getData();
            $data['cpf'] = str_replace(".", "", str_replace("-", "", str_replace("/", "", $data['cpf'])));
            $data['cep'] = str_replace(".", "", str_replace("-", "", $data['cep']));
            $data['number_contact'] = str_replace("(", "", str_replace(")", "", str_replace(" ", "",  str_replace("-", "", $data['number_contact']))));
            $People = $this->People->patchEntity($People, $data);

            // cadastra dados para tabela people
            if(isset($data['gender']) && isset($data['rg']) && isset($data['institution_rg'])){
                $data['rg'] = str_replace(".", "", str_replace("-", "", $data['rg']));
                $People->gender = $data['gender'];
                $People->rg = $data['rg'];
                $People->institution_rg = $data['institution_rg'];
            }else{
                $this->request->data['plan_id'] = 1;
                $data['plan_id'] = 1;
            }
            $People->name = $data['name'];
            $People->cpf = $data['cpf'];
            $People->city = $data['city'];
            $People->email = $data['email'];
            $People->date_of_birth = $data['date_of_birth'];
            $People->number_contact = $data['number_contact'];
            $People->cep = $data['cep'];
            $People->address = $data['address'];
            $People->number = $data['number'];
            $People->complement = $data['complement'];
            $People->district = $data['district'];
            $People->state = $data['state'];
            $People->gender = "N";
            $arracoordenadas = $this->Coord(str_replace(" ","+",$data['number']).str_replace(" ","+",$data['address'])
            .",+".str_replace(" ","+",$data['district']).",+".str_replace(" ","+",$data['city']));
            $People->latitude = $arracoordenadas['lat'];
            $People->longitude = $arracoordenadas['lng'];

            $people_id = $this->People->save($People);
            if ($people_id) {
                $this->addClient($people_id);
                $users = $this->Users->patchEntity($user, $this->request->getData());
                $users->company_id = 1;
                $users->person_id = $people_id->id;
                $users->active = $data['active'];
                $users->name = $data['name'];
                $users->email = $data['email'];
                $users->nickname = isset($data['nickname']) ? $data['nickname'] : NULL;
                $users->users_types_id = 5;
                $users->plan_id = $data['plan_id'];
                $users->cpf = $data['cpf'];
                $user_id = $this->Users->save($users);
                if ($user_id) {
                    $this->Flash->success(__('Seu cadastro foi atualizado com sucesso!'));
                    return $this->redirect(['action' => 'cliente']);
                }
                $this->Flash->error(__('Error ao cadastrar'));
                return $this->redirect(['action' => 'cliente']);

            }
        }

        $companies = $this->Users->Companies->find('list', ['limit' => 200]);
        $usersTypes = $this->Users->UsersTypes->find('list', ['limit' => 200])->where(['public' => true]);
        $plans = $this->Users->Plans->find('list', ['limit' => 200]);
        $estadoUF = array(
            'AC'=>'Acre',
            'AL'=>'Alagoas',
            'AP'=>'Amapá',
            'AM'=>'Amazonas',
            'BA'=>'Bahia',
            'CE'=>'Ceará',
            'DF'=>'Distrito Federal',
            'ES'=>'Espírito Santo',
            'GO'=>'Goiás',
            'MA'=>'Maranhão',
            'MT'=>'Mato Grosso',
            'MS'=>'Mato Grosso do Sul',
            'MG'=>'Minas Gerais',
            'PA'=>'Pará',
            'PB'=>'Paraíba',
            'PR'=>'Paraná',
            'PE'=>'Pernambuco',
            'PI'=>'Piauí',
            'RJ'=>'Rio de Janeiro',
            'RN'=>'Rio Grande do Norte',
            'RS'=>'Rio Grande do Sul',
            'RO'=>'Rondônia',
            'RR'=>'Roraima',
            'SC'=>'Santa Catarina',
            'SP'=>'São Paulo',
            'SE'=>'Sergipe',
            'TO'=>'Tocantins'
            );
        $this->set(compact('user', 'companies', 'usersTypes','plans','People','estadoUF'));
    }

    public function termopriv(){

    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        $this->Can->check($user->company_id);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Usuário removido com sucesso.'));
        } else {
            $this->Flash->error(__('Usuário não pode ser removido. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        // $a = $this->RequestHandler->isMobile();

        // if ($a) {
        //     $this->Flash->error(__('Acesso não permitido por dispositvo móvel'));
        // } else {

            $cpf = $this->request->data('cpf');
            $senha = $this->request->data('password');

            if ($this->request->is('post')) {

                // $this->d($filter);

                $usuario = $this->Auth->identify();
                // $this->d($usuario);
                if ($usuario) {
                    $usuario['image'] = Router::url('/' . $usuario['image'], true);
                    $usuario['company']['image'] = Router::url('/' . $usuario['company']['image'], true);
                    $usuario['type_user'] = $this->getTypesUser($usuario['users_types_id']);
                    if($usuario['users_types_id'] == 1
                        || $usuario['users_types_id'] == 5
                        || $usuario['users_types_id'] == 6){
                        $this->Auth->setUser($usuario);
                        return $this->redirect($this->Auth->redirectUrl());
                    }
                    if($usuario['plans']['is_admin']){
                        $this->Auth->setUser($usuario);
                        return $this->redirect($this->Auth->redirectUrl());
                    }
                    $this->Flash->error(__('Você não tem autorização'));
                }
                $this->Flash->error(__('CPF~CNPJ e/ou senha inválidos.'));
            }
        // }
        $this->viewBuilder()->layout('login');
    }

    private function getTypesUser($primaryKey) {
        $p = TableRegistry::get('UsersTypes');
        $type = $p->get($primaryKey);
        return $type->type;
    }

    public function logout()
    {
        $this->request->session()->write('Config', null);
        $this->request->session()->write('Auth', null);
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Organiza o upload.
     * @access public
     * @param Array $imagem
     * @param String $data
     */
    public function upload($id)
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

    /**
     * Retorna os modulos tipo de usuarios de acordo com a empresa
     */
    private function generationModulesTypeUser($user = null)
    {
        $q = TableRegistry::get('ModulesHasCompanies');
        $modules = $q
            ->find()
            ->select(['id', 'modules_id'])
            ->hydrate(false)
            ->where([
                'company_id' => $user->company_id
            ])
            ->toArray();

        $id_modules = [];
        $has = [];

        foreach ($modules as $value) {
            $id_modules[] = $value['modules_id'];
            $has[$value['modules_id']] = $value['id'];
        }

        $qq = TableRegistry::get('UsersTypesHasModules');
        $uthm = $qq
            ->find()
            ->select(['modules_id'])
            ->hydrate(false)
            ->where([
            'users_types_id' => $user->users_types_id,
            'modules_id IN'  => $id_modules,
        ]);

        $users_has_modules_has_companies = [];

        foreach ($uthm as $value) {
            $users_has_modules_has_companies[] = [
                'modules_has_company_id' => $has[$value['modules_id']],
                'users_id'                 => $user->id
            ];
        }


        $uhmhc = TableRegistry::get('UsersHasModulesHasCompanies');
        $entities = $uhmhc->newEntities($users_has_modules_has_companies);

        return $uhmhc->saveMany($entities);
    }

    private function Coord($endereco){
        # https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y
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
        $data_client['plan_id'] = $data['plan_id'];
        $client = $this->Clients->patchEntity($client, $data_client);
        $this->Clients->save($client);

    }

    private function uploadProfile($client)
    {
        $client = $this->Clients->get($client->id);

        if (!$client) {
            $this->Flash->error(__('Erro imagem não foi salva!'));
            return $this->redirect(['action' => 'add']);
        }
        if(!isset($_FILES['perfil'])){
            return null;
        }else if($_FILES['perfil']["tmp_name"] == ''){
            return null;
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



    public function newpassword(){
        if ($this->request->is('post')) {

            // $this->loadComponent('Emails');
            $tableUsers       = TableRegistry::getTableLocator()->get('Users');

            $email  = $this->request->data('email');
            $cpf    = str_replace(".", "", str_replace("-", "",str_replace("/","",$this->request->data('cpf'))));;

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
                $this->Flash->error('Usuário não encontrado!');
                return $this->redirect(['action' => 'login']);
            }

            $pas = $this->gerarSenha(8, true, true, true, false);

            $user->password = $pas;

            if(!$tableUsers->save($user)){
                $this->Flash->error('Erro ao cadastra nova senha');
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->success('Nova senha foi enviado para seu e-mail!');
            $this->Emails->sendEmailNewPassword([
                'email'    => $user->email,
                'name'     => $user->person->name,
                'password' => $pas
            ]);
            return $this->redirect(['action' => 'login']);
        }
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

    public function d($value,$message = null){
		debug($value);
		if(isset($message)){
			throw new Exception($message);
		}
		exit();
	}
}
