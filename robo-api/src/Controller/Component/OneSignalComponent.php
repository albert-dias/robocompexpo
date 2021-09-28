<?php

namespace App\Controller\Component;

use  Cake\Controller\Component;
use Cake\Controller\COmponentRegistry;
use Cake\ORM\TableRegistry;

/** 
 * Componente de notificação
 */

 class OnesignalComponent extends Component {

    public function sendNotification($msg, $title, $lat, $long, $uf, $categories){
        date_default_timezone_set('America/Sao_Paulo');
        $plansTable = TableRegistry::get("plans");
        $plans = $plansTable->find("all")->order(['raio'=>"ASC"]);

        foreach($plans as $value){
            $response = explode(':', (string)$value->priority_time->i18nFormat("HH:mm:ss"));
            $timer = intval($response[0]) + intval($response[1]);
            $date_send = date('Y-m-d H:i:s ', strtotime('+'.$timer.' minutes'))."GMT-0300";
            $this->sendOneSignalCollection($msg, $title, $value->id, $date_send, $lat, $long, $uf, 6,$value->raio, $categories);
        }
    }

    public function sendNotificationUser($message, $title, $userId){
        $this->sendOneSignalUser($message, $title, $userId);
    }

    private function sendOneSignalCollection($message, $title, $segments, $lat, $long, $uf, $userType, $radius, $categories){ 
        $content = array(
            "en" => $message
        );
        $headings = array(
            "en" => $title
        );

        $filters = array(
            array("field" => "tag", "key" => "plain", "relation" => "=", "value" => "$segments"),
            array("operator" => "AND"),
            array("field" => "tag", "key" => "uf", "relation" => "=", "value" => "$uf"),
            array("operator" => "AND"),
            array("field" => "tag", "key" => "userType", "relation" => "=", "value" => "$userType")
        );
        
        foreach($categories as $category) {
            array_push($filters,array("operator" => "OR"));
            array_push($filters,array("field" => "tag", "key" => "$category", "relation" => "=", "value" => "sim"));
        }

        if($segments == '1') { //tratativa para estado ou distância segundo o plain_id
            $fields = array(
                'app_id' => "02dd9779-dbd3-4263-9391-b554c07b29b3",// id do appn
                'filters' => $filters,
                'data' => array("foo" => "bar"),
                'large_icon' =>"ic_launcher_round.png",
                'contents' => $content,
                'headings' => $headings,
                // 'send_after' => $time      
            );
        } else {
            $fields = array(
                'app_id' => "02dd9779-dbd3-4263-9391-b554c07b29b3",
                'filters' => $filters,
                'data' => array("foo" => "bar"),
                'large_icon' =>"ic_launcher_round.png",
                'contents' => $content,
                'headings' => $headings,
                // 'send_after' => $time      
            );            
        }

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic YzFhNDI5ZWMtYjZlMy00NDM2LTljZjctNzAxMTZkYjIzMGNj'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

        $response = curl_exec($ch);
        curl_close($ch);
        $notificationTable = TableRegistry::get('log_notification');
        $notification = $notificationTable->newEntity();
        $notification->resposta = $response;
        $notification->request = $fields;
        $notificationTable->save($notification);
        return $response;
    }

    private function sendOneSignalUser($message, $title, $userId){
    
        $content = array(
            "en" => $message
        );
        $headings = array(
            "en" => $title
        );

        $fields = array(
            'app_id' => "02dd9779-dbd3-4263-9391-b554c07b29b3",// id do app no OneSignal
            // 'include_external_user_ids' => array(strval($userId)),
            // 'channel_for_external_user_id' => 'push',
            'filters' => array(
                array("field" => "tag", "key" => "id", "relation" => "=", "value" => strval($userId))),
            'data' => array("foo" => "bar"),
            'large_icon' =>"ic_launcher_round.png",
            'small_icon' =>"ic_launcher_round.png",
            'contents' => $content,
            'headings' => $headings,
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, 
        array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic YzFhNDI5ZWMtYjZlMy00NDM2LTljZjctNzAxMTZkYjIzMGNj}'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
    
        $response = curl_exec($ch);
        curl_close($ch);
        $notificationTable = TableRegistry::get('log_notification');
        $notification = $notificationTable->newEntity();
        $notification->resposta = $response;
        $notification->request = $fields;
        $notificationTable->save($notification);
        return $response;
    }
 }