<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use \stdClass;
use \DateTime;
use \Exception;
use Cake\Core\Configure;



/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $_company;
    public $_menu;
    public $_permission;
    public $helpers = [
        'Paginator' => ['templates' => 'paginator-templates']
    ];

    //Talvez seja necessário para o AJAX
    //public $components = array('RequestHandler');

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Security');
        $this->loadComponent('Can');
        $this->loadComponent('Menu');

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Basic' => [
                    'userModel' => 'Users',
                    'fields' => [
                        'username' => 'cpf',
                        'password' => 'password',
                    ],
                ],

                'Form' => [
                    'userModel' => 'Users',
                    'contain'   => ['Companies', 'UsersTypes', 'People', 'Plans'],
                    'fields' => [
                        'username' => 'cpf',
                        'password' => 'password',
                    ],
                ]
            ],
            'authError' => 'Ops! acesso não permitido.',
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => null
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => null
            ],
            'loginRedirect' => [
                'controller' => 'Pages',
                'action' => 'redirecttype',
                'plugin' => null,
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
        ]);
           $this->Auth->allow(['getNotification','home','newpassword','newuser','termopriv','addtecnico','addcliente','consultacpfcnpjBB']);


        //    $this->d($this->request->session()->read('Auth.User'));
        if ($this->request->session()->read('Auth.User')) {
            $this->set('session', $this->request->session()->read('Auth.User'));

            if(!$this->Security->Permissions()){
                $this->Flash->error('Você não tem acesso a essa área.');
                return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            }

            if (!in_array($this->request->params['controller'], $this->request->session()->read('Config.permissions'))
                && !in_array($this->request->params['action'], ['login', 'logout','getNotification',"getNotificationAll","setReadNotification"])
                && $this->request->session()->read('Auth.User.users_types_id') != 1) {
                $this->Flash->error('Você não tem acesso a essa área(2)');
                return $this->redirect($this->referer());
            }
        } else {
            if ($this->request->params['controller'] != 'Users' && $this->request->params['action'] != 'login') {
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
        }
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event) {
        if (!array_key_exists('_serialize', $this->viewVars) &&
                in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    public function query($sql){
		$connection = ConnectionManager::get('default');
        $query = $connection->execute($sql)->fetchall('assoc');
		return $this->arrayToArrayObj($query);
	}

    public function arrayToArrayObj($arr){
		$arr2 = [];
		foreach ($arr as $key => $value){
			$value2 = $this->arrayToObj($value);
			array_push($arr2,$value2);
		}
		return $arr2;
    }



    public function arrayToObj($arr){
		$object = new stdClass();
		foreach ($arr as $key => $value)
		{
			if(is_float($value) && strlen($value) <= 8) { $value = (float)$value;}

			if(is_int($value) && strlen($value) <= 8) { $value = (int)$value;}
			$object->$key = $value;
		}
		return $object;
    }


    public function d($value,$message = null){
		debug($value);
		if(isset($message)){
			throw new Exception($message);
		}
		exit();
    }


    public function Nomemes($mes){
        $meses = array(
            1 => 'Janeiro',
            'Fevereiro',
            'Março',
            'Abril',
            'Maio',
            'Junho',
            'Julho',
            'Agosto',
            'Setembro',
            'Outubro',
            'Novembro',
            'Dezembro'
        );

        return $meses[$mes];
    }



    public function datatableQueryjsontojson($Objects,$data){

		if($Objects == null){
			return null;
		}
		$recordsTotal = count($Objects);
		$recordsFiltered = count($Objects);

		$arr = array($Objects);
		$resultarr = array();
			if($data['search']['value'] != null){
				$input = $data['search']['value'];
				$count_colunas = count($data['columns']);
				$count_linhas = count($arr[0]);
				$colunas = [];
				for ($i=0; $i < $count_colunas; $i++) {
					$colunas[$i] =  $data['columns'][$i]['data'];
				}

				for ($i=0; $i < $count_linhas; $i++) {
					for ($j=0; $j < $count_colunas; $j++) {
						if(strpos($arr[0][$i]->{$colunas[$j]},$input) !== false){
							$resultarr[$i] = $arr[0][$i];
						}
					}


				}

                $Objects = $resultarr;
				$recordsFiltered = count($Objects);
            }

			if(isset($data['order'][0]['column'])){
				$coluna = $data['columns'][$data['order'][0]['column']]['data'];
				$arr = array();
				foreach($Objects as $Object){
					foreach($Object as $key => $value){
						if(!isset($arr[$key])){
							$arr[$key] = array();
						}
						$arr[$key][] = $value;
					}
				}

				if($data['order'][0]['dir'] == 'asc'){
					$dir = SORT_ASC;
				}else{
					$dir = SORT_DESC;
				}
				// if(is_array($arr[$coluna])){
				// 	foreach ($arr as $key => $value) {
				// 		$arr[$coluna] = $value;
				// 	}
				// }
				// $this->d($arr);
				if(is_array($arr[$coluna])){
                    array_multisort($arr[$coluna],$dir,$Objects);
                }

			}
		$Object = $Objects;
		$Object = array_slice($Object,$data['start'],$data['length']);

		$datatablejson = array(
			'draw'=> intval($data["draw"])
			,'recordsTotal'=>intval($recordsTotal)
			,'recordsFiltered'=>intval($recordsFiltered)
			,'data'=> $Object
		);

		return json_encode($datatablejson);


    }

    public function datatableQuerytojson(TableRegistry $Objects,$data){

		foreach($Objects as $Object){
			array_push($Objects,array([$Object]));
		}
		$this->$Objects->find('all',[
			'order'=>$data['order'][0]['column']." ". $data['order'][0]['dir']
			,'limit'=> $data['start'].', '.$data['length']
	    ]);

		$datatablejson = array(
			'draw'=>intval($data["draw"])
			,'recordsTotal'=>count($Object)
			,'recordsFiltered'=>count($Object)
			,'data'=> (array) [$Object]
		);

		return json_encode($datatablejson);


	}

    public function Person($id){
        $person =$this->query("SELECT * FROM people as p WHERE p.id = $id")[0];
        return $person;
    }

    public function linkList(){
       $user = $this->request->session()->read('Auth.User');
       $link = "/collection-orders/";
       if($user['plans']['radius'] === 0.00){
        $link .= "liststate/";
       }else{
        $link .= "listradius/";
       }
       return $link;
        // $this->d();
    }

    public function current_Company(){
        $user = $this->request->session()->read('Auth.User');
        $company = $this->query("SELECT company_id FROM user_relationships WHERE user_id = ".$user['id']." AND active = 1");
        // $this->d(empty($company));
        if(empty($company)){
           return  $user['id'];
        }
        return $company[0]->company_id;
    }

    public function consultacpfcnpjBB(){
        $data = $this->request->getData();
        if ($this->request->is('post')) {
            $people = $this->query("SELECT COUNT(*) as conta, id FROM people WHERE cpf = ".$data['cpf'])[0];
            if($people->conta == 1){
                $user = $this->query("SELECT COUNT(*) as conta, id FROM users WHERE person_id = ".$people->id)[0];
                if($user->conta == 1){
                    $user_relationships = $this->query("SELECT COUNT(*)as conta FROM user_relationships WHERE user_id =".$user->id." AND active = 1")[0];
                    if($user_relationships->conta == 1){
                        $this->set('mensagem', "CPF ".$data['cpf']."  já cadastrado em outra empresa");
                        $this->set('_serialize', array('mensagem'));
                        $this->response->statusCode(201);
                    }
                }else{
                    $this->set('mensagem', "Usuário está com problemas de cadastro por favor contate o suporte");
                    $this->set('_serialize', array('mensagem'));
                    $this->response->statusCode(500);
                }
            }
            $this->set('mensagem', "ok");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(200);


        }



    }

    public function getUltimoDiaMes($mes=null){
		if($mes == null){
			$date = new DateTime('now');
			$date->modify('last day of this month');
			return $date->format('d');
		}else{
			$year = date('Y');
			$date = new DateTime("$year-$mes-01");
			$date->modify('last day of this month');
			return $date->format('d');
		}
    }

    public function getPeriodo($getvalue){
		$arr = [];

		if(isset($_REQUEST[$getvalue])){
			if ($_REQUEST[$getvalue] == null || trim($_REQUEST[$getvalue]) == "" || strtoupper($_REQUEST[$getvalue]) == "NULL"){
				return null;
			}

			$datainicio = explode(' - ',$_REQUEST[$getvalue])[0];
			$datafim    = explode(' - ',$_REQUEST[$getvalue])[1];

			$arrdate = explode('/',$datainicio);
			$d = $arrdate[0];
			$m = $arrdate[1];
			$y = $arrdate[2];
			$datainicio = "$y-$m-$d";

			$arrdate = explode('/',$datafim);
			$d = $arrdate[0];
			$m = $arrdate[1];
			$y = $arrdate[2];
			$datafim = "$y-$m-$d";

			$arr = array($datainicio,$datafim);
		}

		return $arr;
	}

    function myUrlEncode($string) {
        $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
        $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
        return str_replace($entities, $replacements, urlencode($string));
    }

    public function validaCPF($cpf = null) {

		// Verifica se um número foi informado
		if(empty($cpf)) {
			return false;
		}

		// Elimina possivel mascara
		//$cpf = ereg_replace('[^0-9]', '', $cpf);
		$cpf = str_replace('.', '', $cpf);
		$cpf = str_replace('-', '', $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		// Verifica se o numero de digitos informados é igual a 11
		if (strlen($cpf) != 11) {
			return false;
		}
		// Verifica se nenhuma das sequências invalidas abaixo
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' ||
			$cpf == '11111111111' ||
			$cpf == '22222222222' ||
			$cpf == '33333333333' ||
			$cpf == '44444444444' ||
			$cpf == '55555555555' ||
			$cpf == '66666666666' ||
			$cpf == '77777777777' ||
			$cpf == '88888888888' ||
			$cpf == '99999999999') {
			return false;
		 // Calcula os digitos verificadores para verificar se o
		 // CPF é válido
		 } else {

			for ($t = 9; $t < 11; $t++) {

				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf[$c] * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf[$c] != $d) {
					return false;
				}
			}

			return true;
		}
    }
    function validaCNPJ($cnpj){
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    public function slackAPI($message){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://hooks.slack.com/services/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",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"text\":\"".$message."\"}",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: ea7c83f0-e5f9-c514-ffc2-391dce5e1aa1"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }
    public function TophoneBR($number){
        $mask = "(##) # ####-####";
        $str = $number;
        $str = str_replace(" ","",$str);

        for($i=0;$i<strlen($str);$i++){
            $mask[strpos($mask,"#")] = $str[$i];
        }

        return $mask;
    }


}
