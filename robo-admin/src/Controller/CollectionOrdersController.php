<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Controller\AppController;
use App\Controller\Router;
use Cake\ORM\TableRegistry;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */

class CollectionOrdersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('S3Tools');
        $this->loadModel('CollectionOrdersImages');
        $this->loadModel('CollectionOrders');
        $this->loadModel('Users');
        $this->loadModel('People');
        $this->loadModel('CollectionOrdersResponses');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Notification');
        
    }


    public function index(){
        $person_session = $this->request->session()->read('Auth.User');
        $personQuery = $this->Person($person_session['person_id']);
        

        $person = array(
            "latitude"=> $personQuery->latitude,
            "longitude"=> $personQuery->longitude
        );

        $this->set(compact('person'));
    }

    public function lists($list, $last_id = null){
        $person_session = $this->request->session()->read('Auth.User');
        if($person_session['plans']['id'] == 4){
            $this->listSaleDonationsStateCPFCNPJ($list, $last_id);
        }
        if($person_session['plans']['id'] == 5){
            $this->listDonationsStateCPF($list, $last_id);
        }
        if($person_session['plans']['id'] == 3){
            $this->listSaleDonationsRadiusCPFCNPJ($list, $last_id);
        }
        if($person_session['plans']['id'] == 2){
            $this->listSaleDonationsRadiusCPF($list, $last_id);
        }
    }

    
    public function listSaleDonationsStateCPFCNPJ($list, $last_id = null){
        $person = $this->request->session()->read('Auth.User');
        
        $personQuery = $this->Person($person['person_id']);
        $id_user = $this->current_Company();
        $plan_id = $person['plan_id'];
        //query para buscar categorias do usuario
        $users_categories_query = $this->query("SELECT * FROM `users_categories` WHERE user_id =".$id_user);
        $users_categories = array();
        foreach ($users_categories_query as $value) {
            array_push($users_categories,$value->categorie_id);
        }
        if(empty($users_categories)){
            $users_categories[0] = 0;
        }
        //delay de ordens de coletas do coletor
        $priority_time = $this->query("SELECT `priority_time` FROM `plans` WHERE id =".$plan_id)[0];
        list($hours, $minutes, $seconds) = explode(':', $priority_time->priority_time); 
        $date_query = date("Y-m-d H:i:s"); 
        $date_query = new \DateTime($date_query);
        $date_query->sub(new \DateInterval('PT'.$hours.'H'.$minutes.'M'.$seconds.'S'));
        $list_collection = null;
        $collection_orders = null;
        if($list === "pendente"){

            if($last_id){
                $collection_orders =  $collection_orders = $this->query('SELECT
                co.id as id,
                co.status as status_ordes  ,
                co.period as period  ,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                ci.path as image_dir,
                co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                            co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude,
                            cr.company_id as users_id_resposta
                            FROM collection_orders as co
                            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                            INNER JOIN collection_orders_images as ci ON ci.collection_orders_id = co.id
                            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                            WHERE co.status = "'.$list.'" AND co.id > '.$last_id.' AND cc.categorie_id IN('.implode(",", $users_categories).')
                            AND co.state = "'.$person['person']['state'].'" AND co.created < "'.$date_query->format("Y-m-d H:i:s").'"
                            AND co.id NOT IN (SELECT co.id FROM collection_orders co INNER JOIN collection_orders_responses cr ON cr.collection_order_id = co.id WHERE cr.company_id = '.$id_user.'  GROUP BY co.id)
                            GROUP BY co.id
                            ORDER BY co.created ASC');
            }else{
                $collection_orders = $this->query('SELECT co.users_id as users_id,
                co.id as id,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                co.period as period  ,
                co.quantity_garbage_bags as quantity_garbage_bags,
                co.comments as comments,
                co.created as data_soliction,
                co.date_service_ordes,
                co.latitude as latitude,
                co.longitude as longitude,
                cr.company_id as users_id_resposta
                FROM collection_orders as co
                INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                WHERE co.status = "'.$list.'" AND cc.categorie_id IN('.implode(",", $users_categories).')
                AND co.state = "'.$person['person']['state'].'"  AND co.created < "'.$date_query->format("Y-m-d H:i:s").'"
                AND co.id NOT IN (SELECT co.id FROM collection_orders co INNER JOIN collection_orders_responses cr ON cr.collection_order_id = co.id WHERE cr.company_id = '.$id_user.'  GROUP BY co.id)
                GROUP BY co.id
                ORDER BY co.created ASC');
            }
        
        }
        if($list == "finalizada" || $list == "agendada"){
            $list_status;
            if($list == "finalizada"){
                $list_status = "recebido";
            }else{
                $list_status = "aceita";
            }
            $collection_orders = $this->query('SELECT co.users_id as users_id,
            co.period as period  ,
            co.id as id,
            GROUP_CONCAT(cc.categorie_id) as `categories`,
            co.quantity_garbage_bags as quantity_garbage_bags,
            co.comments as comments,
            co.created as data_soliction,
                co.date_service_ordes,
            co.latitude as latitude,
            co.longitude as longitude,
            cr.company_id as users_id_resposta
            FROM collection_orders as co
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
            WHERE cr.company_id = "'.$id_user.'" AND cr.status = "'.$list_status.'"
            GROUP BY co.id
            ORDER BY co.created ASC');
            
            if($last_id){
                
                $collection_orders = $this->query('SELECT
                co.id as id,
                co.period as period  ,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude,
                            cr.company_id as users_id_resposta
                            FROM collection_orders as co
                            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                            WHERE  co.users_id = "'.$id_user.'" AND co.id > '.$last_id.' AND cr.status = "'.$list_status.'"
                            GROUP BY co.id
                            ORDER BY co.created ASC');
            }
        }
        if($list === "negada" || $list === "pendente-order" || $list === "negada-user"){
            $where_pendente_order = null;
            if($list === "pendente-order"){
                $list = substr($list,0,8);
                $where_pendente_order = ' AND co.status = "pendente"';
            }
            $id_user = $id_user;
            $where = null;
            if($list === "negada"){
                $check_negacao = $this->query("SELECT cd.collection_order_id FROM `collection_orders_denied`as cd WHERE cd.user_id = ".$id_user);
                $id_negados = array();
                foreach ($check_negacao as $value) {
                    array_push($id_negados,$value->collection_order_id);
                }
                if(empty($id_negados)){
                    $id_negados[0] = 0;
                }
                $where = "AND co.id NOT IN (".implode(",",$id_negados).")";
            }
 
           
            
            $collection_orders = $this->query('SELECT 
            cr.id as id_resp,
            co.id as id,
            GROUP_CONCAT(cc.categorie_id) as `categories`,
            co.period as period  ,
            co.users_id as users_id,
                        co.id as id,
                        co.quantity_garbage_bags as quantity_garbage_bags,
                        co.comments as comments,
                        co.created as data_soliction,
                co.date_service_ordes,
                        co.latitude as latitude,
                        co.longitude as longitude,
                        cr.company_id as users_id_resposta
            FROM collection_orders_responses as cr
            INNER JOIN collection_orders as co ON co.id = cr.collection_order_id 
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
            WHERE cr.company_id = '.$id_user.' AND cr.status = "'.$list.'" '.$where.' '.$where_pendente_order.' GROUP BY co.id  ORDER BY co.created ASC');
            
            if($last_id){
                $collection_orders = $this->query('SELECT co.id as id,
                co.period as period  ,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude,
                            cr.company_id as users_id_resposta
            FROM collection_orders_responses as cr
            INNER JOIN collection_orders as co ON co.id = cr.collection_order_id
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
            WHERE cr.company_id = '.$id_user.' AND cr.status = "'.$list.'" AND co.id >'.$last_id.' '.$where.' '.$where_pendente_order.'  GROUP BY co.id ORDER BY co.created ASC');
            }
        }
        if($list == "negada-order"){
            $id_user =$id_user;
            $collection_orders = $this->query("SELECT  co.id as id,
                        co.period as period  ,
                        GROUP_CONCAT(cc.categorie_id) as `categories`,
                        co.users_id as users_id,
                        co.id as id,
                        co.quantity_garbage_bags as quantity_garbage_bags,
                        co.comments as comments,
                        co.created as data_soliction,
                co.date_service_ordes,
                        co.latitude as latitude,
                        co.longitude as longitude
                        FROM  collection_orders as co 
                        INNER JOIN collection_orders_denied as cd ON co.id = cd.collection_order_id
                        INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                        WHERE cd.user_id = $id_user GROUP BY co.id ORDER BY co.created ASC");
            if($last_id){
                $collection_orders = $this->query("SELECT  co.id as id,
                            co.period as period  ,
                            GROUP_CONCAT(cc.categorie_id) as `categories`,
                            co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude
                            FROM  collection_orders as co 
                            INNER JOIN collection_orders_denied as cd ON co.id = cd.collection_order_id
                            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                            WHERE cd.user_id > $id_user GROUP BY co.id ORDER BY co.created ASC");
            }
        }
        
        foreach ($collection_orders as $collection_order) {
           $collection_orders_images = $this->CollectionOrdersImages
            ->find()
            ->where(['CollectionOrdersImages.collection_orders_id'=>$collection_order->id]);
           foreach ($collection_orders_images as $collection_orders_image) {
               if($collection_orders_image->path){
                    $collection_orders_image->url = $this->S3Tools->getUrlTemp($collection_orders_image->path, 120);

                }   
           }
           
           $CollectionOrdersResponses = $this->CollectionOrdersResponses
                ->find()
                ->where(['CollectionOrdersResponses.collection_order_id'=>$collection_order->id]);
           foreach ($CollectionOrdersResponses as $responses) {
                if($CollectionOrdersResponses){
                    $CollectionOrdersResponses->OrdersResponses = $responses;
                }
            }
           
            if($list == "finalizada" || $list == "agendada"){    
                $user = $this->Users
                    ->find()
                    ->select(['name'])
                    ->where(['Users.id'=>$collection_order->users_id])
                    ->first();
                $collection_order->user = $user;
            }else{
                $collection_order->user['name'] = '<i class="fas fa-lock"></i>';
            }
           $infoCategories = TableRegistry::get('categories');
           $infoCategories = $infoCategories
                                ->find()
                                ->where(['categories.id IN'=>explode(',',$collection_order->categories)]);
           $collection_order->images =  $collection_orders_images;
           
           $collection_order->OrdersResponses = $CollectionOrdersResponses;
           $collection_order->categories_info = $infoCategories;

        }
        $this->set('collection_orders', $collection_orders);
        $this->set('_serialize', array('collection_orders'));
        $this->response->statusCode(200);

        
    }

    public function listDonationsStateCPF($list, $last_id = null){
        $person = $this->request->session()->read('Auth.User');
        
        $personQuery = $this->Person($person['person_id']);
        $id_user = $this->current_Company(); // vai precisar alterar
        $plan_id = $person['plan_id'];
        //query para buscar categorias do usuario
        $users_categories_query = $this->query("SELECT * FROM `users_categories` WHERE user_id =".$id_user);
        $users_categories = array();
        foreach ($users_categories_query as $value) {
            array_push($users_categories,$value->categorie_id);
        }
        if(empty($users_categories)){
            $users_categories[0] = 0;
        }
        //delay de ordens de coletas do coletor
        $priority_time = $this->query("SELECT `priority_time` FROM `plans` WHERE id =".$plan_id)[0];
        list($hours, $minutes, $seconds) = explode(':', $priority_time->priority_time); 
        $date_query = date("Y-m-d H:i:s"); 
        $date_query = new \DateTime($date_query);
        $date_query->sub(new \DateInterval('PT'.$hours.'H'.$minutes.'M'.$seconds.'S'));
        $list_collection = null;
        $collection_orders = null;
        if($list === "pendente"){

            if($last_id){
                $collection_orders =  $collection_orders = $this->query('SELECT
                co.id as id,
                co.status as status_ordes  ,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                ci.path as image_dir,
                co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude,
                            cr.company_id as users_id_resposta
                            FROM collection_orders as co
                            INNER JOIN users as u ON  u.id = co.users_id
                            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                            INNER JOIN collection_orders_images as ci ON ci.collection_orders_id = co.id
                            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                            WHERE co.status = "'.$list.'" AND cr.company_id IS NULL AND co.id > '.$last_id.' AND cc.categorie_id IN('.implode(",", $users_categories).')
                            AND co.state = "'.$person['person']['state'].'" AND co.created < "'.$date_query->format("Y-m-d H:i:s").'" AND LENGTH(u.cpf) = 11
                            AND co.type = 0 AND co.id NOT IN (SELECT co.id FROM collection_orders co INNER JOIN collection_orders_responses cr ON cr.collection_order_id = co.id WHERE cr.company_id = '.$id_user.' GROUP BY co.id)
                            GROUP BY co.id
                            ORDER BY co.created ASC');
            }else{
                $collection_orders = $this->query('SELECT co.users_id as users_id,
                co.id as id,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                co.period as period  ,
                co.quantity_garbage_bags as quantity_garbage_bags,
                co.comments as comments,
                co.created as data_soliction,
                co.date_service_ordes,
                co.latitude as latitude,
                co.longitude as longitude,
                cr.company_id as users_id_resposta
                FROM collection_orders as co
                INNER JOIN users as u ON  u.id = co.users_id
                LEFT JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                WHERE co.status = "'.$list.'" AND cr.company_id IS NULL AND cc.categorie_id IN('.implode(",", $users_categories).')
                AND co.state = "'.$person['person']['state'].'"  AND co.created < "'.$date_query->format("Y-m-d H:i:s").'" AND LENGTH(u.cpf) = 11
                AND co.type = 0 AND co.id NOT IN (SELECT co.id FROM collection_orders co INNER JOIN collection_orders_responses cr ON cr.collection_order_id = co.id WHERE cr.company_id = '.$id_user.' GROUP BY co.id)
                GROUP BY co.id
                ORDER BY co.created ASC');
            }
        
        }
        if($list == "finalizada" || $list == "agendada"){
            $list_status;
            if($list == "finalizada"){
                $list_status = "recebido";
            }else{
                $list_status = "aceita";
            }
            $collection_orders = $this->query('SELECT co.users_id as users_id,
            co.period as period  ,
            co.id as id,
            GROUP_CONCAT(cc.categorie_id) as `categories`,
            co.quantity_garbage_bags as quantity_garbage_bags,
            co.comments as comments,
            co.created as data_soliction,
                co.date_service_ordes,
            co.latitude as latitude,
            co.longitude as longitude,
            cr.company_id as users_id_resposta
            FROM collection_orders as co
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
            WHERE cr.company_id = "'.$id_user.'" AND cr.status = "'.$list_status.'"
            GROUP BY co.id
            ORDER BY co.created ASC');
            
            if($last_id){
                
                $collection_orders = $this->query('SELECT
                co.id as id,
                co.period as period  ,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude,
                            cr.company_id as users_id_resposta
                            FROM collection_orders as co
                            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                            WHERE  co.users_id = "'.$id_user.'" AND co.id > '.$last_id.' AND cr.status = "'.$list_status.'"
                            GROUP BY co.id
                            ORDER BY co.created ASC');
            }
        }
        if($list === "negada" || $list === "pendente-order" || $list === "negada-user"){
            $where_pendente_order = null;
            if($list === "pendente-order"){
                $list = substr($list,0,8);
                $where_pendente_order = ' AND co.status = "pendente"';
            }
            $id_user = $id_user;
            $where = null;
            if($list === "negada"){
                $check_negacao = $this->query("SELECT cd.collection_order_id FROM `collection_orders_denied`as cd WHERE cd.user_id = ".$id_user);
                $id_negados = array();
                foreach ($check_negacao as $value) {
                    array_push($id_negados,$value->collection_order_id);
                }
                if(empty($id_negados)){
                    $id_negados[0] = 0;
                }
                $where = "AND co.id NOT IN (".implode(",",$id_negados).")";
            }
 
           
            $collection_orders = $this->query('SELECT 
            cr.id as id_resp,
            co.id as id,
            GROUP_CONCAT(cc.categorie_id) as `categories`,
            co.period as period  ,
            co.users_id as users_id,
                        co.id as id,
                        co.quantity_garbage_bags as quantity_garbage_bags,
                        co.comments as comments,
                        co.created as data_soliction,
                co.date_service_ordes,
                        co.latitude as latitude,
                        co.longitude as longitude,
                        cr.company_id as users_id_resposta
            FROM collection_orders_responses as cr
            INNER JOIN collection_orders as co ON co.id = cr.collection_order_id 
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
            WHERE cr.company_id = '.$id_user.' AND cr.status = "'.$list.'" '.$where.' '.$where_pendente_order.' GROUP BY co.id  ORDER BY co.created ASC');
            
            if($last_id){
                $collection_orders = $this->query('SELECT co.id as id,
                co.period as period  ,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude,
                            cr.company_id as users_id_resposta
            FROM collection_orders_responses as cr
            INNER JOIN collection_orders as co ON co.id = cr.collection_order_id
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
            WHERE cr.company_id = '.$id_user.' AND cr.status = "'.$list.'" AND co.id >'.$last_id.' '.$where.' '.$where_pendente_order.'  GROUP BY co.id ORDER BY co.created ASC');
            }
        }
        if($list == "negada-order"){
            $id_user =$id_user;
            $collection_orders = $this->query("SELECT  co.id as id,
                        co.period as period  ,
                        GROUP_CONCAT(cc.categorie_id) as `categories`,
                        co.users_id as users_id,
                        co.id as id,
                        co.quantity_garbage_bags as quantity_garbage_bags,
                        co.comments as comments,
                        co.created as data_soliction,
                co.date_service_ordes,
                        co.latitude as latitude,
                        co.longitude as longitude
                        FROM  collection_orders as co 
                        INNER JOIN collection_orders_denied as cd ON co.id = cd.collection_order_id
                        INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                        WHERE cd.user_id = $id_user GROUP BY co.id ORDER BY co.created ASC");
            if($last_id){
                $collection_orders = $this->query("SELECT  co.id as id,
                            co.period as period  ,
                            GROUP_CONCAT(cc.categorie_id) as `categories`,
                            co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude
                            FROM  collection_orders as co 
                            INNER JOIN collection_orders_denied as cd ON co.id = cd.collection_order_id
                            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                            WHERE cd.user_id > $id_user GROUP BY co.id ORDER BY co.created ASC");
            }
        }
        
        foreach ($collection_orders as $collection_order) {
           $collection_orders_images = $this->CollectionOrdersImages
            ->find()
            ->where(['CollectionOrdersImages.collection_orders_id'=>$collection_order->id]);
           foreach ($collection_orders_images as $collection_orders_image) {
               if($collection_orders_image->path){
                    $collection_orders_image->url = $this->S3Tools->getUrlTemp($collection_orders_image->path, 120);

                }   
           }
           
           $CollectionOrdersResponses = $this->CollectionOrdersResponses
                ->find()
                ->where(['CollectionOrdersResponses.collection_order_id'=>$collection_order->id]);
           foreach ($CollectionOrdersResponses as $responses) {
                if($CollectionOrdersResponses){
                    $CollectionOrdersResponses->OrdersResponses = $responses;
                }
            }

            if($list == "finalizada" || $list == "agendada"){    
                $user = $this->Users
                    ->find()
                    ->select(['name'])
                    ->where(['Users.id'=>$collection_order->users_id])
                    ->first();
                $collection_order->user = $user;
            }else{
                $collection_order->user['name'] = '<i class="fas fa-lock"></i>';
            }
           $infoCategories = TableRegistry::get('categories');
           $infoCategories = $infoCategories
                                ->find()
                                ->where(['categories.id IN'=>explode(',',$collection_order->categories)]);
           $collection_order->images =  $collection_orders_images;
           $collection_order->OrdersResponses = $CollectionOrdersResponses;
           $collection_order->categories_info = $infoCategories;

        }
        $this->set('collection_orders', $collection_orders);
        $this->set('_serialize', array('collection_orders'));
        $this->response->statusCode(200);
    }

    public function listSaleDonationsRadiusCPFCNPJ($list, $last_id = null){
        $person = $this->request->session()->read('Auth.User');
        
        $personQuery = $this->Person($person['person_id']);
        $latitude = $personQuery->latitude;
        $longitude = $personQuery->longitude;
        $id_user = $this->current_Company();
        $plan_id = $person['plan_id'];
        //query para buscar categorias do usuario
        $users_categories_query = $this->query("SELECT * FROM `users_categories` WHERE user_id =".$id_user);
        $users_categories = array();
        foreach ($users_categories_query as $value) {
            array_push($users_categories,$value->categorie_id);
        }
        if(empty($users_categories)){
            $users_categories[0] = 0;
        }
        //delay de ordens de coletas do coletor
        $priority_time = $this->query("SELECT `priority_time` FROM `plans` WHERE id =".$plan_id)[0];
        list($hours, $minutes, $seconds) = explode(':', $priority_time->priority_time); 
        $date_query = date("Y-m-d H:i:s"); 
        $date_query = new \DateTime($date_query);
        $date_query->sub(new \DateInterval('PT'.$hours.'H'.$minutes.'M'.$seconds.'S'));
        $list_collection = null;
        $collection_orders = null;
        if($list === "pendente"){

            if($last_id){
                $collection_orders =  $collection_orders = $this->query('SELECT
                co.id as id,
                co.status as status_ordes  ,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                ci.path as image_dir,
                co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude,
                            cr.company_id as users_id_resposta
                            FROM collection_orders as co
                            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                            INNER JOIN collection_orders_images as ci ON ci.collection_orders_id = co.id
                            INNER JOIN plans ON get_distance(latitude, longitude, "'.$latitude.'","'.$longitude.'") <= plans.radius
                            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                            WHERE co.status = "'.$list.'" AND co.id > '.$last_id.' AND cc.categorie_id IN('.implode(",", $users_categories).')
                            AND co.created < "'.$date_query->format("Y-m-d H:i:s").'"
                            AND co.id NOT IN (SELECT co.id FROM collection_orders co INNER JOIN collection_orders_responses cr ON cr.collection_order_id = co.id WHERE cr.company_id = '.$id_user.' GROUP BY co.id)
                            AND plans.id = 3
                            GROUP BY co.id
                            ORDER BY co.created ASC');
            }else{
                $collection_orders = $this->query('SELECT co.users_id as users_id,
                co.id as id,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                co.period as period  ,
                co.quantity_garbage_bags as quantity_garbage_bags,
                co.comments as comments,
                co.created as data_soliction,
                co.date_service_ordes,
                co.latitude as latitude,
                co.longitude as longitude,
                cr.company_id as users_id_resposta
                FROM collection_orders as co
                INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                INNER JOIN plans ON get_distance(latitude, longitude, "'.$latitude.'","'.$longitude.'") <= plans.radius
                WHERE co.status = "'.$list.'" AND cc.categorie_id IN('.implode(",", $users_categories).')
                AND co.created < "'.$date_query->format("Y-m-d H:i:s").'"
                AND co.id NOT IN (SELECT co.id FROM collection_orders co INNER JOIN collection_orders_responses cr ON cr.collection_order_id = co.id WHERE cr.company_id = '.$id_user.' GROUP BY co.id)
                AND plans.id = 3
                GROUP BY co.id
                ORDER BY co.created ASC');
            }
        
        }
        if($list == "finalizada" || $list == "agendada"){
            $list_status;
            if($list == "finalizada"){
                $list_status = "recebido";
            }else{
                $list_status = "aceita";
            }
            $collection_orders = $this->query('SELECT co.users_id as users_id,
            co.period as period  ,
            co.id as id,
            GROUP_CONCAT(cc.categorie_id) as `categories`,
            co.quantity_garbage_bags as quantity_garbage_bags,
            co.comments as comments,
            co.created as data_soliction,
                co.date_service_ordes,
            co.latitude as latitude,
            co.longitude as longitude,
            cr.company_id as users_id_resposta
            FROM collection_orders as co
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
            WHERE cr.company_id = "'.$id_user.'" AND cr.status = "'.$list_status.'"
            GROUP BY co.id
            ORDER BY co.created ASC');
            
            if($last_id){
                
                $collection_orders = $this->query('SELECT
                co.id as id,
                co.period as period  ,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude,
                            cr.company_id as users_id_resposta
                            FROM collection_orders as co
                            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                            WHERE  co.users_id = "'.$id_user.'" AND co.id > '.$last_id.' AND cr.status = "'.$list_status.'"
                            GROUP BY co.id
                            ORDER BY co.created ASC');
            }
        }
        if($list === "negada" || $list === "pendente-order" || $list === "negada-user"){
            $where_pendente_order = null;
            if($list === "pendente-order"){
                $list = substr($list,0,8);
                $where_pendente_order = ' AND co.status = "pendente"';
            }
            $id_user = $id_user;
            $where = null;
            if($list === "negada"){
                $check_negacao = $this->query("SELECT cd.collection_order_id FROM `collection_orders_denied`as cd WHERE cd.user_id = ".$id_user);
                $id_negados = array();
                foreach ($check_negacao as $value) {
                    array_push($id_negados,$value->collection_order_id);
                }
                if(empty($id_negados)){
                    $id_negados[0] = 0;
                }
                $where = "AND co.id NOT IN (".implode(",",$id_negados).")";
            }
 
           
            
            $collection_orders = $this->query('SELECT 
            cr.id as id_resp,
            co.id as id,
            GROUP_CONCAT(cc.categorie_id) as `categories`,
            co.period as period  ,
            co.users_id as users_id,
                        co.id as id,
                        co.quantity_garbage_bags as quantity_garbage_bags,
                        co.comments as comments,
                        co.created as data_soliction,
                co.date_service_ordes,
                        co.latitude as latitude,
                        co.longitude as longitude,
                        cr.company_id as users_id_resposta
            FROM collection_orders_responses as cr
            INNER JOIN collection_orders as co ON co.id = cr.collection_order_id 
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
            WHERE cr.company_id = '.$id_user.' AND cr.status = "'.$list.'" '.$where.' '.$where_pendente_order.' GROUP BY co.id  ORDER BY co.created ASC');
            
            if($last_id){
                $collection_orders = $this->query('SELECT co.id as id,
                co.period as period  ,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude,
                            cr.company_id as users_id_resposta
            FROM collection_orders_responses as cr
            INNER JOIN collection_orders as co ON co.id = cr.collection_order_id
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
            WHERE cr.company_id = '.$id_user.' AND cr.status = "'.$list.'" AND co.id >'.$last_id.' '.$where.' '.$where_pendente_order.'  GROUP BY co.id ORDER BY co.created ASC');
            }
        }
        if($list == "negada-order"){
            $id_user =$id_user;
            $collection_orders = $this->query("SELECT  co.id as id,
                        co.period as period  ,
                        GROUP_CONCAT(cc.categorie_id) as `categories`,
                        co.users_id as users_id,
                        co.id as id,
                        co.quantity_garbage_bags as quantity_garbage_bags,
                        co.comments as comments,
                        co.created as data_soliction,
                co.date_service_ordes,
                        co.latitude as latitude,
                        co.longitude as longitude
                        FROM  collection_orders as co 
                        INNER JOIN collection_orders_denied as cd ON co.id = cd.collection_order_id
                        INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                        WHERE cd.user_id = $id_user GROUP BY co.id ORDER BY co.created ASC");
            if($last_id){
                $collection_orders = $this->query("SELECT  co.id as id,
                            co.period as period  ,
                            GROUP_CONCAT(cc.categorie_id) as `categories`,
                            co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude
                            FROM  collection_orders as co 
                            INNER JOIN collection_orders_denied as cd ON co.id = cd.collection_order_id
                            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                            WHERE cd.user_id > $id_user GROUP BY co.id ORDER BY co.created ASC");
            }
        }
        
        foreach ($collection_orders as $collection_order) {
           $collection_orders_images = $this->CollectionOrdersImages
            ->find()
            ->where(['CollectionOrdersImages.collection_orders_id'=>$collection_order->id]);
           foreach ($collection_orders_images as $collection_orders_image) {
               if($collection_orders_image->path){
                    $collection_orders_image->url = $this->S3Tools->getUrlTemp($collection_orders_image->path, 120);

                }   
           }
           
           $CollectionOrdersResponses = $this->CollectionOrdersResponses
                ->find()
                ->where(['CollectionOrdersResponses.collection_order_id'=>$collection_order->id]);
           foreach ($CollectionOrdersResponses as $responses) {
                if($CollectionOrdersResponses){
                    $CollectionOrdersResponses->OrdersResponses = $responses;
                }
            }
           
                
            if($list == "finalizada" || $list == "agendada"){    
                $user = $this->Users
                    ->find()
                    ->select(['name'])
                    ->where(['Users.id'=>$collection_order->users_id])
                    ->first();
                $collection_order->user = $user;
            }else{
                $collection_order->user['name'] = '<i class="fas fa-lock"></i>';
            }
           $infoCategories = TableRegistry::get('categories');
           $infoCategories = $infoCategories
                                ->find()
                                ->where(['categories.id IN'=>explode(',',$collection_order->categories)]);
           $collection_order->images =  $collection_orders_images;
           $collection_order->OrdersResponses = $CollectionOrdersResponses;
           $collection_order->categories_info = $infoCategories;

        }
        $this->set('collection_orders', $collection_orders);
        $this->set('_serialize', array('collection_orders'));
        $this->response->statusCode(200);

        
    }

    public function listSaleDonationsRadiusCPF($list, $last_id = null){
        $person = $this->request->session()->read('Auth.User');
        
        $personQuery = $this->Person($person['person_id']);
        $latitude = $personQuery->latitude;
        $longitude = $personQuery->longitude;
        $id_user = $this->current_Company();
        $plan_id = $person['plan_id'];
        //query para buscar categorias do usuario
        $users_categories_query = $this->query("SELECT * FROM `users_categories` WHERE user_id =".$id_user);
        $users_categories = array();
        foreach ($users_categories_query as $value) {
            array_push($users_categories,$value->categorie_id);
        }
        if(empty($users_categories)){
            $users_categories[0] = 0;
        }
        //delay de ordens de coletas do coletor
        $priority_time = $this->query("SELECT `priority_time` FROM `plans` WHERE id =".$plan_id)[0];
        list($hours, $minutes, $seconds) = explode(':', $priority_time->priority_time); 
        $date_query = date("Y-m-d H:i:s"); 
        $date_query = new \DateTime($date_query);
        $date_query->sub(new \DateInterval('PT'.$hours.'H'.$minutes.'M'.$seconds.'S'));
        $list_collection = null;
        $collection_orders = null;
        if($list === "pendente"){

            if($last_id){
                $collection_orders =  $collection_orders = $this->query('SELECT
                co.id as id,
                co.status as status_ordes  ,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                ci.path as image_dir,
                co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude,
                            cr.company_id as users_id_resposta
                            FROM collection_orders as co
                            INNER JOIN users as u ON  u.id = co.users_id
                            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                            INNER JOIN plans ON get_distance(latitude, longitude, "'.$latitude.'","'.$longitude.'") <= plans.radius
                            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                            INNER JOIN collection_orders_images as ci ON ci.collection_orders_id = co.id
                            WHERE co.status = "'.$list.'" AND co.id > '.$last_id.' AND cc.categorie_id IN('.implode(",", $users_categories).')
                            AND co.created < "'.$date_query->format("Y-m-d H:i:s").'" AND LENGTH(u.cpf) = 11
                            AND co.id NOT IN (SELECT co.id FROM collection_orders co INNER JOIN collection_orders_responses cr ON cr.collection_order_id = co.id WHERE cr.company_id = '.$id_user.' GROUP BY co.id)
                            AND plans.id = 2
                            GROUP BY co.id
                            ORDER BY co.created ASC');
            }else{
                $collection_orders = $this->query('SELECT co.users_id as users_id,
                co.id as id,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                co.period as period  ,
                co.quantity_garbage_bags as quantity_garbage_bags,
                co.comments as comments,
                co.created as data_soliction,
                co.date_service_ordes,
                co.latitude as latitude,
                co.longitude as longitude,
                cr.company_id as users_id_resposta
                FROM collection_orders as co
                INNER JOIN users as u ON  u.id = co.users_id
                INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                INNER JOIN collection_orders_images as ci ON ci.collection_orders_id = co.id
                INNER JOIN plans ON get_distance(latitude, longitude, "'.$latitude.'","'.$longitude.'") <= plans.radius
                WHERE co.status = "'.$list.'" AND cc.categorie_id IN('.implode(",", $users_categories).')
                AND co.created < "'.$date_query->format("Y-m-d H:i:s").'" AND LENGTH(u.cpf) = 11
                AND co.id NOT IN (SELECT co.id FROM collection_orders co INNER JOIN collection_orders_responses cr ON cr.collection_order_id = co.id WHERE cr.company_id = '.$id_user.' GROUP BY co.id)
                AND plans.id = 2
                GROUP BY co.id
                ORDER BY co.created ASC');
            }
        
        }
        if($list == "finalizada" || $list == "agendada"){
            $list_status;
            if($list == "finalizada"){
                $list_status = "recebido";
            }else{
                $list_status = "aceita";
            }
            $collection_orders = $this->query('SELECT co.users_id as users_id,
            co.period as period  ,
            co.id as id,
            GROUP_CONCAT(cc.categorie_id) as `categories`,
            co.quantity_garbage_bags as quantity_garbage_bags,
            co.comments as comments,
            co.created as data_soliction,
                co.date_service_ordes,
            co.latitude as latitude,
            co.longitude as longitude,
            cr.company_id as users_id_resposta
            FROM collection_orders as co
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
            WHERE cr.company_id = "'.$id_user.'" AND cr.status = "'.$list_status.'"
            GROUP BY co.id
            ORDER BY co.created ASC');
            
            if($last_id){
                
                $collection_orders = $this->query('SELECT
                co.id as id,
                co.period as period  ,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude,
                            cr.company_id as users_id_resposta
                            FROM collection_orders as co
                            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                            WHERE  co.users_id = "'.$id_user.'" AND co.id > '.$last_id.' AND cr.status = "'.$list_status.'"
                            GROUP BY co.id
                            ORDER BY co.created ASC');
            }
        }
        if($list === "negada" || $list === "pendente-order" || $list === "negada-user"){
            $where_pendente_order = null;
            if($list === "pendente-order"){
                $list = substr($list,0,8);
                $where_pendente_order = ' AND co.status = "pendente"';
            }
            $id_user = $id_user;
            $where = null;
            if($list === "negada"){
                $check_negacao = $this->query("SELECT cd.collection_order_id FROM `collection_orders_denied`as cd WHERE cd.user_id = ".$id_user);
                $id_negados = array();
                foreach ($check_negacao as $value) {
                    array_push($id_negados,$value->categorie_id);
                }
                if(empty($id_negados)){
                    $id_negados[0] = 0;
                }
                $where = "AND co.id NOT IN (".implode(",",$id_negados).")";
            }
 
           
            
            $collection_orders = $this->query('SELECT 
            cr.id as id_resp,
            co.id as id,
            GROUP_CONCAT(cc.categorie_id) as `categories`,
            co.period as period  ,
            co.users_id as users_id,
                        co.id as id,
                        co.quantity_garbage_bags as quantity_garbage_bags,
                        co.comments as comments,
                        co.created as data_soliction,
                co.date_service_ordes,
                        co.latitude as latitude,
                        co.longitude as longitude,
                        cr.company_id as users_id_resposta
            FROM collection_orders_responses as cr
            INNER JOIN collection_orders as co ON co.id = cr.collection_order_id 
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
            WHERE cr.company_id = '.$id_user.' AND cr.status = "'.$list.'" '.$where.' '.$where_pendente_order.' GROUP BY co.id  ORDER BY co.created ASC');
            
            if($last_id){
                $collection_orders = $this->query('SELECT co.id as id,
                co.period as period  ,
                GROUP_CONCAT(cc.categorie_id) as `categories`,
                co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude,
                            cr.company_id as users_id_resposta
            FROM collection_orders_responses as cr
            INNER JOIN collection_orders as co ON co.id = cr.collection_order_id
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
            WHERE cr.company_id = '.$id_user.' AND cr.status = "'.$list.'" AND co.id >'.$last_id.' '.$where.' '.$where_pendente_order.'  GROUP BY co.id ORDER BY co.created ASC');
            }
        }
        if($list == "negada-order"){
            $id_user =$id_user;
            $collection_orders = $this->query("SELECT  co.id as id,
                        co.period as period  ,
                        GROUP_CONCAT(cc.categorie_id) as `categories`,
                        co.users_id as users_id,
                        co.id as id,
                        co.quantity_garbage_bags as quantity_garbage_bags,
                        co.comments as comments,
                        co.created as data_soliction,
                co.date_service_ordes,
                        co.latitude as latitude,
                        co.longitude as longitude
                        FROM  collection_orders as co 
                        INNER JOIN collection_orders_denied as cd ON co.id = cd.collection_order_id
                        INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                        WHERE cd.user_id = $id_user GROUP BY co.id ORDER BY co.created ASC");
            if($last_id){
                $collection_orders = $this->query("SELECT  co.id as id,
                            co.period as period  ,
                            GROUP_CONCAT(cc.categorie_id) as `categories`,
                            co.users_id as users_id,
                            co.id as id,
                            co.quantity_garbage_bags as quantity_garbage_bags,
                            co.comments as comments,
                            co.created as data_soliction,
                co.date_service_ordes,
                            co.latitude as latitude,
                            co.longitude as longitude
                            FROM  collection_orders as co 
                            INNER JOIN collection_orders_denied as cd ON co.id = cd.collection_order_id
                            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
                            WHERE cd.user_id > $id_user GROUP BY co.id ORDER BY co.created ASC");
            }
        }
        
        foreach ($collection_orders as $collection_order) {
           $collection_orders_images = $this->CollectionOrdersImages
            ->find()
            ->where(['CollectionOrdersImages.collection_orders_id'=>$collection_order->id]);
           foreach ($collection_orders_images as $collection_orders_image) {
               if($collection_orders_image->path){
                    $collection_orders_image->url = $this->S3Tools->getUrlTemp($collection_orders_image->path, 120);

                }   
           }
           
           $CollectionOrdersResponses = $this->CollectionOrdersResponses
                ->find()
                ->where(['CollectionOrdersResponses.collection_order_id'=>$collection_order->id]);
           foreach ($CollectionOrdersResponses as $responses) {
                if($CollectionOrdersResponses){
                    $CollectionOrdersResponses->OrdersResponses = $responses;
                }
            }
           
                
            if($list == "finalizada" || $list == "agendada"){    
                $user = $this->Users
                    ->find()
                    ->select(['name'])
                    ->where(['Users.id'=>$collection_order->users_id])
                    ->first();
                $collection_order->user = $user;
            }else{
                $collection_order->user['name'] = '<i class="fas fa-lock"></i>';
            }
           $infoCategories = TableRegistry::get('categories');
           $infoCategories = $infoCategories
                                ->find()
                                ->where(['categories.id IN'=>explode(',',$collection_order->categories)]);
           $collection_order->images =  $collection_orders_images;
           $collection_order->OrdersResponses = $CollectionOrdersResponses;
           $collection_order->categories_info = $infoCategories;

        }
        $this->set('collection_orders', $collection_orders);
        $this->set('_serialize', array('collection_orders'));
        $this->response->statusCode(200);

        
    }


    public function aceita(){
        $person = $this->request->session()->read('Auth.User');
        $data = $this->request->getData();
        $data['id_resp'] = intval($data['id_resp']);
        $id_user = $this->current_Company();
        $check_aceita = $this->query('SELECT cr.status as `status`,
        cr.id as id
        FROM collection_orders_responses as cr 
        WHERE cr.collection_order_id = '.$data['id_collection'].' AND cr.company_id = '.$id_user);
        $CollectionResponses = null;
        $check_status = $this->query('SELECT co.status as `status`,co.users_id 
        FROM collection_orders as co WHERE co.id = '.$data['id_collection'])[0];
        $id_user_resposta = $check_status->users_id;
        if($check_status->status != "pendente"){
            $this->set('mensagem', "Essa coletar já foi ".$check_status->status);
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
            return null;
        }
        if(!empty($check_aceita)){
            $data['id_resp'] = $check_aceita[0]->id;
        }
        if($data['id_resp']){
            $CollectionResponses = $this->CollectionOrdersResponses->get($data['id_resp'],[
                'contain' => []
            ]);
            $CollectionOrdersResponses = TableRegistry::get('collection_orders_responses');
            $CollectionResponses = $CollectionOrdersResponses->patchEntity($CollectionResponses, $data);
        }else{
            $CollectionResponses = $this->CollectionOrdersResponses->newEntity();
            
        }
        $CollectionResponses->collection_order_id = $data['id_collection'];
        $CollectionResponses->users_id = $id_user;
        $CollectionResponses->company_id = $id_user;
        $CollectionResponses->status = "pendente";

        if ($this->CollectionOrdersResponses->save($CollectionResponses)) {
            $this->loadComponent('Emails');
            $collection = $this->CollectionOrders->get($data['id_collection']);
            $gerador = $this->Users->get($collection->users_id); 
            $respotas = $this->query("SELECT p.name,p.number_contact FROM collection_orders_responses as cr 
            INNER JOIN users as u ON cr.users_id = u.id 
            INNER JOIN people as p ON p.id = u.person_id 
            WHERE collection_order_id = ".$data['id_collection']);
            $count_respotas = count($respotas);
            $this->Emails->sendEmailNotificationGerador(array("name"=>$gerador->name,"email"=>$gerador->email,"count_respontas"=>$count_respotas,"nome_coletor"=>$person['name'],"coletor"=>json_decode(json_encode($respotas), JSON_OBJECT_AS_ARRAY)));
            $this->Notification->sendNotification($person['id'],$id_user_resposta,"Um coletor aceitou sua solicitação ".$data['id_collection'],"fale com ele via Whatsapp para marca um a coleta","collection/view/".$data['id_collection']);
            $this->set('mensagem', "Solicitação de coletar encaminhada!");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(200);
            return null;
        }else{
            $this->set('mensagem', "Aconteceu algum erro, por favor tente mais tarde!");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
            return null;
        }

    }

    public function negado(){
        $person = $this->request->session()->read('Auth.User');
        $data = $this->request->getData();
        $data['id_resp'] = intval($data['id_resp']);
        $id_user = $this->current_Company();
        $check_status = $this->query('SELECT co.status as `status` 
        FROM collection_orders as co WHERE co.id = '.$data['id_collection'])[0];
        $check_negacao = $this->query('SELECT cr.status as `status`,
        cr.id as id
        FROM collection_orders_responses as cr 
        WHERE cr.collection_order_id = '.$data['id_collection'].' AND cr.company_id = '.$id_user);

        if($check_status->status != "pendente"){
            $this->set('mensagem', "Essa coletar já foi ".$check_status->status);
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
            return null;
        }
        if(!empty($check_negacao)){
            $data['id_resp'] = $check_negacao[0]->id;
        }
        $CollectionResponses = null;
        if($data['id_resp']){
            $CollectionResponses = $this->CollectionOrdersResponses->get($data['id_resp'],[
                'contain' => []
            ]);
            $CollectionOrdersResponses = TableRegistry::get('collection_orders_responses');
            $CollectionResponses = $CollectionOrdersResponses->patchEntity($CollectionResponses, $data);
        }else{
            $CollectionResponses = $this->CollectionOrdersResponses->newEntity();
            
        }
        $CollectionResponses->collection_order_id = $data['id_collection'];
        $CollectionResponses->users_id = $id_user;
        $CollectionResponses->company_id = $id_user;
        $CollectionResponses->status = "negada";

        if ($this->CollectionOrdersResponses->save($CollectionResponses)) {
            $this->set('mensagem', "Solicitação de coletar negada com sucesso!");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(200);
            return null;
        }else{
            $this->set('mensagem', "Aconteceu algum erro, por favor tente mais tarde!");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
            return null;
        }
    }

    public function view($id){

        $person = $this->request->session()->read('Auth.User');
        //query para buscar categorias do usuario
        $users_categories_query = $this->query("SELECT * FROM `users_categories` WHERE user_id =".$person['id']);
        $users_all_categories_query = $this->query("SELECT * FROM `categories`");
        $users_categories = array();
        foreach ($users_categories_query as $value) {
            array_push($users_categories,$value->categorie_id);
        }
        if(empty($users_categories)){
            $users_categories[0] = 0;
        }
        $collection_orders = $this->query("SELECT *,co.status as `status_coleta`, cc.categorie_id as categories,GROUP_CONCAT(c.name SEPARATOR ', ') as `materiais`, cr.status as `status_respo`,co.users_id as `user_gerador` FROM `collection_orders` as co 
        INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id
        LEFT JOIN  categories as c ON c.id = cc.categorie_id
        LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
        WHERE co.id = $id AND cr.company_id = ".$person['id']." AND cc.categorie_id IN(".implode(",", $users_categories).") GROUP BY co.id");
       
        if($person['users_types_id'] == 1 || $person['users_types_id'] == 2){        
            $collection_orders = $this->query("SELECT *,co.status as `status_coleta`, cc.categorie_id as categories,GROUP_CONCAT(c.name SEPARATOR ', ')as `materiais`, cr.status as `status_respo`,co.users_id as `user_gerador` 
            FROM `collection_orders` as co 
            INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id 
            LEFT JOIN  categories as c ON c.id = cc.categorie_id
            LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
            WHERE co.id = $id GROUP BY co.id");
        }else{
            
            if($collection_orders == null){
                $collection_orders = $this->query("SELECT *,co.status as `status_coleta`, cc.categorie_id as categories,GROUP_CONCAT(c.name SEPARATOR ', ')as `materiais`, cr.status as `status_respo`,co.users_id as `user_gerador` 
                FROM `collection_orders` as co 
                INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id 
                LEFT JOIN  categories as c ON c.id = cc.categorie_id
                LEFT JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id
                WHERE co.id = $id  AND cc.categorie_id IN(".implode(",", $users_categories).") GROUP BY co.id");
            }
        }
        $collection_orders = $collection_orders[0];
        $gerador = $this->query("SELECT p.id as id,
        p.name as nome, 
        p.number_contact as contato
        FROM people as p
       	INNER JOIN users as u ON u.person_id = p.id 
        WHERE u.id = $collection_orders->user_gerador")[0];
        if($collection_orders->status_respo == "recebido"){
            $collection_stock_table = TableRegistry::get("collection_orders_stock");
            $collection_orders->stock = $collection_stock_table
                                        ->find('all')
                                        ->where(['collection_orders_id'=>$id])->toArray();
        }

            $collection_orders_images = $this->CollectionOrdersImages
             ->find()
             ->where(['CollectionOrdersImages.collection_orders_id'=>$collection_orders->collection_orders_id]);
            foreach ($collection_orders_images as $collection_orders_image) {
                
                if($collection_orders_image->path){
                    $img = $this->S3Tools->getUrlTemp($collection_orders_image->path, 120);
  
                    $xml = false;
                    if(!$xml){
                     $collection_orders_image->url = $img;
                    }else{
                        $collection_orders_image->url = $this->request->getAttribute("webroot")."webroot/assets/images/sem-fotos.png"; ;
                    }
                     
                 }   
            }

            if($collection_orders->status_respo != "aceita"){
                $collection_orders->latitude += floatVal('0.00'.rand(5465467,453653));
                $collection_orders->longitude+= floatVal('0.00'.rand(6743535,4566678653));
            }
            // $this->d($collection_orders->status_respo);
            // $this->d($collection_orders->latitude . " ". $collection_orders->longitude);
             $user = $this->Users
                 ->find()
                 ->select(['name'])
                 ->where(['Users.id'=>$collection_orders->user_gerador])
                 ->first();
                 $infoCategories = TableRegistry::get('categories');
                 $infoCategories = $infoCategories
                                      ->find('all')
                                      ->where(['categories.id'=>$collection_orders->categories])->toArray();
                                    //   $this->d($collection_orders);
            $collection_orders->images =  $collection_orders_images;
            $collection_orders->user = $user;
            $collection_orders->categories_info = $infoCategories[0];
            $this->set(compact('collection_orders','gerador','users_all_categories_query'));
        
    }

    public function addStock($id){
        $this->loadModel("UsersCategories");
        $this->loadModel("Categories");
    
        $person = $this->request->session()->read('Auth.User');
        $data = $this->request->getData();
        $collection_stock_table = TableRegistry::get("collection_orders_stock");
        $collection_stock_atual = $collection_stock_table->find("all")->where(['collection_orders_id'=>$id])->toArray();
        $stock_atual = [];
        $resumo_order = [];
        if($collection_stock_atual != null){
            foreach ($collection_stock_atual as $value) {
                $stock_atual[$value->categorie_id] = $value->stock;
                $collection_stock_table->delete($value);
            }
        }
        foreach ($data['categorie'] as $key => $value) {
            $collection_stock = $collection_stock_table->newEntity();
            $collection_stock->collection_orders_id = $id;
            $collection_stock->categorie_id = $value;
            $collection_stock->stock = $data['stock'][$key];
            $price = $this->query("SELECT Price FROM `users_categories` WHERE user_id = ".$person['id']." AND categorie_id = ".$value)[0];
            $collection_stock->amount = (float) $price->Price * $data['stock'][$key];
            $collection_stock->user_id = $person['id'];
            $categories = $this->Categories->get($value)->toArray();
            array_push($resumo_order,array("kg"=>number_format($data['stock'][$key],2,',','.'),"name"=>$categories['name'],"sub"=>number_format($collection_stock->amount,2,',','.'),"rs"=>number_format($price->Price,2,',','.')));
            if(!$collection_stock_table->save($collection_stock)){
                $this->set('mensagem',"error ao atualizar preços!");
                $this->set('_serialize',array('mensagem'));
                $this->response->statusCode(500);
                return;   
            }
                
            
        }
        $this->loadComponent('Emails');
        $dados_envio = $this->query("SELECT co.type as `type`, u.name as `name`,u.email as `email` FROM collection_orders as co INNER JOIN users as u ON u.id = co.users_id  WHERE co.id = $id")[0];
        $data = $this->request->getData();
        if(isset($data['email'])){
            if($dados_envio->type){
                $data = array(
                    "email"=>$dados_envio->email,
                    "name"=>$dados_envio->name,
                    "residuos"=>$resumo_order,
                    "id_coleta"=>$id,
                    "nome_coletor"=>$person['name'],
                    "total"=> number_format((float) array_sum(array_column($resumo_order,"sub")),2,',','.')
                );
                $this->Emails->sendEmailResumoVenda($data);
            }else{
                $data = array(
                    "email"=>$dados_envio->email,
                    "name"=>$dados_envio->name,
                    "residuos"=>$resumo_order,
                    "nome_coletor"=>$person['name'],
                    "id_coleta"=>$id
                );
                $this->Emails->sendEmailResumoDoacao($data);
            }
        }
        $this->set('mensagem',"Salvo com sucesso!");
        $this->set('_serialize',array('mensagem'));
        $this->response->statusCode(200);
    }

    public function finalizar()
    {
        $person = $this->request->session()->read('Auth.User');
        $data = $this->request->getData();
        $check_finalizar = $this->query('SELECT co.id,co.status FROM collection_orders as co 
        INNER JOIN collection_orders_responses as cr ON cr.collection_order_id = co.id 
        WHERE cr.company_id = '.$person['id'].' AND (co.status = "agendada" OR co.status = "coletada" OR co.status = "finalizada") AND cr.status = "aceita" AND co.id = '.$data['id_collection'])[0];

        if($check_finalizar){
            $collection_order_responses = $this->CollectionOrdersResponses->find("all")->where(["collection_order_id "=>$data['id_collection'],"company_id"=>$person['id']])->first();
            $collection_order_responses->status = "recebido";
            if($this->CollectionOrdersResponses->save($collection_order_responses)){
                $this->set('mensagem', "Coletar Finalizada!");
                $this->set('_serialize', array('mensagem'));
                $this->response->statusCode(200);
                return null;
            }else{
                $this->set('mensagem', "Error ao salvar!");
                $this->set('_serialize', array('mensagem'));
                $this->response->statusCode(500);
                return null;
            }
        }else{
            $this->set('mensagem', "Aconteceu algum erro, por favor tente mais tarde!");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
            return null;
        }
    }
   
}
