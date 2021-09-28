<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use RestApi\Controller\ApiController;

/**
 * MyServicesImages Controller
 * 
 * @property \App\Model\Table\MyServicesImagesTable $MyServicesTable
 * @method \App\Model\Entity\MyServicesImages[]|\Cake\Datasource\ResultInterfacepaginate($object = null, array $settings = [])
 */

 class MyServicesImagesController extends ApiController
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
        return parent::initialize();
    }
     /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

    public function addServicesImage()
    {
        $d = $this->jwtPayload;
        $client = $this->Clients->get($d->id);
        $person = $this->People->get($client->person_id);

        if(!$client) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Cliente não encontrado'
            ];
            return;
        }

        $serviceImage = $this->MyServicesImages->newEntity();

        $serviceImage->my_services_id = $this->request->data('my_service_id');
        $serviceImage->created = date('Y-m-d H:i:s');

        if(!$this->MyServicesImages->save($serviceImage)) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => $this->ErrorList->errorInString($serviceImage->errors())
            ];
            return;
        }
        $this->apiResponse['id'] = $serviceImage->id;

        foreach($_FILES['file']['name'] as $key => $value){
            $name = $_FILES['file']['name'][$key];
            $tmp_name = $_FILES['file']['tmp_name'][$key];
            $key = bin2hex(openssl_random_pseudo_bytes(10));
            $a = $this->upImagemService($name, $tmp_name, $serviceImage->id, $key);

            $this->apiResponse['-->TESTE'] = 'NOME: '. $name . 'TMP: ' . $tmp_name . 'KEY: ' . $key . 'A: ' . $a;
            if(!$a['save']) {
                $this->responseStatus = false;
                $this->apiResponse = [
                    'save' => false,
                    'msg_erro' => $a['msg_erro']
                ];
                return;
            }
        }
        $this->apiResponse['message'] = 'salvo com sucesso';
        return;
    }

    private function upImagemService($file, $tmp_file, $se_id, $key) {
        $data['file'] = $tmp_file;
        $data['info'] = pathinfo($file);
        $data['ext'] = $data['info']['extension'];
         $this->apiResponse['DATA'] = $data;
         return;
        $path = 'services' . "/" . $se_id . "/" . $key . "." . $data['ext'];

        if ($data['ext'] != 'jpg' && $data['ext'] != 'jpeg' && $data['ext'] != 'png') {
            return [
                'save' => false,
                'path' => null,
                'msg_erro' => 'Extensão da imagem deve ser PNG ou JPG/JPEG'
            ];
        }

        $result = $this->S3Tools->upImage($path, $data['file']);
        $this->apiResponse['MENS'] = $result;
return;
        if($result['@metadata']['statusCode'] == 200) {
            if($this->saveBaseImgService($se_id, $path)) {
                return[
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

    private function saveBaseImgService($se_id, $path) {
        $table = TableRegistry::getTableLocator()->get('MyServicesImages');
        $r = $table->newEntity();
        $r->my_services_id = $se_id;
        $r->path = $path;
        $r->created = date('Y-m-d H:i:s');

        return $table->save($r);
    }

    /**
     * Modifica as imagens daquele serviço na base de dados
     * Editar Imagens
     */

    /**
     * Localizar todas as imagens relacionadas aquele serviço
     */

    public function loadServiceImages()
    {
        if($this->request->is('post')) {
            $idS = $this->request->data('id');

            $result = $this->MyServicesImages->find()->where([
                'my_services_id' => $idS
            ])->toArray();
            
            $this->apiResponse['array'] = $result;
            return;
        }
    }
}