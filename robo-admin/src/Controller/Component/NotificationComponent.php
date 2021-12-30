<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * Notification component
 */
class NotificationComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    

    public function sendNotification($de,$para,$title = null,$post = null,$link = null,$img = null){
        $notificationTable = TableRegistry::get('notification');
        $notification = $notificationTable->newEntity();
        $notification->de = $de;
        $notification->para = $para;
        $notification->title = $title;
        $notification->post = $post;
        $notification->img = $img;
        $notification->link = $link;
        if(!$notificationTable->save($notification)){
            $this->Flash->error('Error ao salvar notication');  
        }


    }

}
