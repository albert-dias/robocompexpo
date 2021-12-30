<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * Margin Controller
 *
 *
 * @method \App\Model\Entity\Margin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationController extends AppController{

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        
    }
    public function getNotification(){
        $data = $this->request->getData();
        $person = $this->request->session()->read('Auth.User');
        $id_user = $person['id'];
        if($data["last_id"] == null){
            $data["last_id"] = 0;
        }
        $notification = $this->Notification->find('all')->where(['para'=>$id_user,"id > "=> $data["last_id"]])->toArray();
        // $notificationUser_type = $this->Notification->find('all')->where(['user_type'=>$person['plans']['id']])->toArray();
        
        // $this->d($teste);

        // if(count($notificationUser_type) > 0){
        //     $aux = $this->Notification->newEntity();
        //     $aux->id = 0;
        //     $aux->title = "Chegaram ".count($notificationUser_type)." Novas coletas";
        //     $aux->post = "Não perca tempo!";
        //     array_push($notification,"teste");
        // }
        $this->set('notification', $notification);
        $this->set('_serialize', array('notification'));
        $this->response->statusCode(200);
    }
    public function getNotificationAll(){
        $person = $this->request->session()->read('Auth.User');
        $id_user = $person['id'];
        
        $notification = $this->Notification->find('all')->where(['para'=>$id_user])->toArray();
        $this->set('notification', $notification);
        $this->set('_serialize', array('notification'));
        $this->response->statusCode(200);
    }

    public function setReadNotification(){
        $data = $this->request->getData();
        $notification = $this->Notification->get($data['id']);
        $notification->is_read = true;
        if($this->Notification->save($notification)){
            $this->set('notification', $notification);
            $this->set('_serialize', array('notification'));
            $this->response->statusCode(200);
        }else{
            $this->set('notification', "error");
            $this->set('_serialize', array('notification'));
            $this->response->statusCode(500);
        }
    }
   
}
