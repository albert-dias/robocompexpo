<?php

namespace App\Controller;

use App\Controller\AppController;
use RestApi\Controller\ApiController;
use Cake\ORM\TableRegistry;

/**
 * People Controller
 *
 * @property \App\Model\Table\PeopleTable $People
 *
 * @method \App\Model\Entity\Person[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PeopleController extends ApiController
{

    public function initialize()
    {
        $this->loadComponent('ErrorList');
        $this->loadComponent('S3Tools');
        $this->loadModel('Providers');
        $this->loadModel('Clients');
        $this->loadModel('Users');
        return parent::initialize();
    }
    /**
     * Realiza o cadastro de um prestador
     */
    public function insertProvider()
    {
        $email = $this->request->data('email');

        $user = $this->searchUser($email);
        
        if($user){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Email já cadastrado';
            return;
        }

        $ps = $this->addPerson();

        if (!$ps['save']) {
            $this->responseStatus = false;
            $this->apiResponse['message'] = $ps['msg_erro'];
            return;
        }

        $prs = $this->addProvider($ps['person']);

        if (!$prs['save']) {
            $this->responseStatus = false;
            $this->apiResponse['message'] = $prs['msg_erro'];
            return;
        }

        $provider = $prs['provider'];

        $images  = $this->saveImages($provider->id);

        if (!$images['save']) {
            $this->People->delete($ps['person']);
            $this->responseStatus = false;
            $this->apiResponse['message'] = "Falha ao salvar imagen(s): " . $images['msg_erro'];
            return;
        }

        $this->apiResponse['message'] = 'salvo com sucesso';

        return;
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
     * Buscar usuário que já esteja cadastrada com email
     */
    private function searchUser($email){

        $user= $this->Users->find()->where([
            'email'=> $email,
            'users_types_id' => 4
        ])->first();

        return $user;
    }

    /**
     * Salva as imagens padrões do prestador
     */
    private function saveImages($id)
    {
        $type = 'providers';

        $return = [
            'save' => true,
            'msg_erro' => ''
        ];

        $ups = [
            'rg'          => ['path' => null, 'save' => false, 'msg_erro' => ''],
            'rg_verso'    => ['path' => null, 'save' => false, 'msg_erro' => ''],
            'cpf'         => ['path' => null, 'save' => false, 'msg_erro' => ''],
            'certificado' => ['path' => null, 'save' => false, 'msg_erro' => ''],
            'self'        => ['path' => null, 'save' => false, 'msg_erro' => '']
        ];

        foreach ($ups as $key => $value) {
            $up = $this->upImagem($key, $id, $type);
            if (!$up['save']) {
                $return['msg_erro'] .= "[$key]-[" . $up['msg_erro'] . "]";
                $return['save'] = false;
            }
        }
        return $return;
    }

    /**
     * Realiza upload de imagem para AWS
     */
    private function upImagem($key, $id, $type)
    {
        $data['file'] = $_FILES[$key]["tmp_name"];
        $data['info'] = pathinfo($_FILES[$key]["name"]);
        $data['ext']  = $data['info']['extension'];

        $path = $type . "/" . $id . "/" . $key . "." . $data['ext'];

        if ($data['ext'] != 'jpg' && $data['ext'] != 'png') {
            return [
                'save' => false,
                'path' => null,
                'msg_erro' => 'Extensão da imagem deve ser PNG ou JPG'
            ];
        }

        $result = $this->S3Tools->upImage($path, $data['file']);

        if ($result['@metadata']['statusCode'] == 200) {
            if ($this->saveBaseImg($key, $type, $id, $path)) {
                return [
                    'save' => true,
                    'path' => $path,
                    'msg_erro' => ''
                ];
            }
            return [
                'save' => false,
                'path' => null,
                'msg_erro' => 'Erro ao salvar a imagem no banco'
            ];
        }

        return [
            'save' => false,
            'path' => null,
            'msg_erro' => 'Falha ao fazer upload de ' . $path
        ];
    }

    /**
     * Salva URL da imagem no banco de dados
     */
    private function saveBaseImg($type, $table, $id, $path)
    {

        if ($table == 'providers') {
            $table = TableRegistry::getTableLocator()->get('ProvidersImages');
            $r = $table->newEntity();
            $r->providers_id = $id;
        } else if ($table == 'clients') {
            $table = TableRegistry::getTableLocator()->get('ClientsImages');
            $r = $table->newEntity();
            $r->clients_id = $id;
        }

        $r->image = $path;
        $r->type = $type;

        return $table->save($r);
    }

    /**
     * Salva prestador em banco de dados
     */
    private function addProvider($person)
    {
        $p = $this->searchProvider($person->id);


        if($p){
            return [
                'save' => false,
                'person' => false,
                'msg_erro' => "prestador já cadastrado"
            ];
        }


        $provider = $this->Providers->newEntity();
        $provider->companies_id = $person->company_id;
        $provider->person_id = $person->id;
        $provider->category_id = $this->request->data('category_id');
        $provider->subcategory_id = $this->request->data('subcategory_id');
        $provider->nick = $this->request->data('nick');
        $provider->acting_region = 'RN';
        $provider->active = false;

        if ($this->Providers->save($provider)) {
            return [
                'save' => true,
                'provider' => $provider,
                'msg_erro' => ''
            ];
        }

        $msg_erro = $this->ErrorList->errorInString($provider->errors());

        return [
            'save' => false,
            'provider' => false,
            'msg_erro' => $msg_erro
        ];
    }
    
       /**
     * Buscar clientes que já esteja cadastrada para essa pessoa
     */
    private function searchProvider($person_id){

        $provider = $this->Providers->find()->where([
            'person_id'=> $person_id
        ])->first();

        return $provider;
    }

    /**
     * Remove carcateres de mascara dos dados para salvar em banco
     */
    private function removeCarcter($string)
    {
        $remove = [
            ",", "/", ".", "-", "(", ")", " "
        ];

        $str = str_replace($remove, "", $string);

        return $str;
    }

    /**
     * Salva pessoa ligada a prestador no banco de dados
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

        $person = $this->People->newEntity();

        $person->company_id     = 1;
        $person->image          = null;
        $person->name           = $this->request->data('name');
        $person->cpf            = $this->removeCarcter($this->request->data('numero_cpf'));
        $person->rg             = $this->removeCarcter($this->request->data('numero_rg'));
        $person->institution_rg = $this->request->data('institution_rg');
        $person->date_of_birth  = $this->request->data('date_of_birth');
        $person->email          = $this->request->data('email');
        $person->number_contact = $this->removeCarcter($this->request->data('number_contact'));
        $person->address        = $this->request->data('address');
        $person->number         = $this->request->data('number');
        $person->district       = $this->request->data('district');
        $person->complement     = $this->request->data('complement');
        $person->city           = $this->request->data('city');
        $person->state          = $this->request->data('state');
        $person->bank_code      = $this->request->data('bank_code');
        $person->bank_account   = $this->request->data('bank_account');
        $person->bank_agency    = $this->request->data('bank_agency');
        $person->active         = true;
        $person->cep            = $this->request->data('cep');

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
            'msg_erro' => $msg_erro
        ];
    }

    /**
     * Atualiza do perfil do prestador
     */
    public function updateProviders()
    {

        $token = $this->jwtPayload;
        $provider = $this->Providers->get($token->id);

        if (!$provider) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'person' => false,
                'msg_erro' => 'Prestador não encontrado'
            ];
            return;
        }

        $person = $this->People->get($provider->person_id);

        if (!$person) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'person' => false,
                'msg_erro' => 'Prestador não encontrado'
            ];

            return;
        }


        $updates_providers = [
            'category_id'    => false,
            'subcategory_id' => false,
            'nick'        => false
        ];

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

        foreach ($updates_providers as $key => $value) {
            if (!$this->request->data($key)) {
                continue;
            }

            $new_value_provider = $value ? $this->removeCarcter($this->request->data($key)) : $this->request->data($key);

            if ($new_value_provider == '') {
                continue;
            }

            $provider->$key = $new_value_provider;
        }

        if (!$this->Providers->save($provider)) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'person' => false,
                'msg_erro' => $this->ErrorList->errorInString($provider->errors())
            ];
            return;
        }


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

        $provider = $this->Providers->get($token->id, [
            'contain' => [
                'Categories',
                'Subcategories'
            ]
        ]);

        $new_data = [
            'name' => $person->name,
            'nick' => $provider->nick,
            'telefone' => $person->number_contact,
            'email' => $person->email,
            'category' => $provider->category->name,
            'subcategory' => $provider->subcategory->name,
        ];

        $this->apiResponse = [
            'save' => true,
            'person' => $new_data,
            'msg_erro' => ''
        ];
    }

    /**
     * Retorna dados de perfil do prestador
     */
    public function getPerfilProvider()
    {
        $token = $this->jwtPayload;

        $provider = $this->Providers->get($token->id, [
            'contain' => ['People', 'Categories', 'Subcategories']
        ]);

        $result = [
            'name'           => $provider->person->name,
            'nick'           => $provider->nick,
            'cpf'            => $provider->person->cpf,
            'phone'          => $provider->person->number_contact,
            'email'          => $provider->person->email,
            'cep'            => $provider->person->cep,
            'address'        => $provider->person->address,
            'number'         => $provider->person->number,
            'district'       => $provider->person->district,
            'complement'     => $provider->person->complement,
            'city'           => $provider->person->city,
            'state'          => $provider->person->state,
            'category'       => $provider->category->name,
            'category_id'    => $provider->category->id,
            'subcategory'    => $provider->subcategory->name,
            'subcategory_id' => $provider->subcategory->id,
        ];

        $this->apiResponse = $result;
    }

    /**
     * Retorna dados de perfil do prestador
     */
    public function getPerfilClient()
    {
        $token = $this->jwtPayload;

        $client = $this->Clients->get($token->id, [
            'contain' => ['People']
        ]);

        $result = [
            'name'           => $client->person->name,
            //'nick'           => $provider->nick,
            'cpf'            => $client->person->cpf,
            'phone'          => $client->person->number_contact,
            'email'          => $client->person->email,
            'cep'            => $client->person->cep,
            'address'        => $client->person->address,
            'number'         => $client->person->number,
            'district'       => $client->person->district,
            'complement'     => $client->person->complement,
            'city'           => $client->person->city,
            'state'          => $client->person->state,
            //'category'       => $provider->category->name,
            //'category_id'    => $provider->category->id,
            //'subcategory'    => $provider->subcategory->name,
            //'subcategory_id' => $provider->subcategory->id,
        ];

        $this->apiResponse = $result;
    }
}
