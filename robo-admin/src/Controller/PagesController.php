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

use Cake\ORM\TableRegistry;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */

class PagesController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('S3Tools');
    }

    public function index(){
        $this->redirect(['action' => 'redirecttype']);
    }

    public function home() {
        $users = $this->request->session()->read('Auth.User');
    }

    public function redirecttype(){
        
        $users = $this->request->session()->read('Auth.User');

        // Páginas acessadas pelo administrador
        if($users['users_types_id'] === 1){
            $this->redirect(['action' => 'administrator']);
        }
        // Páginas acessadas pelo cliente
        if($users['users_types_id'] === 5 ){
            $this->redirect(['action' => 'clientpage']);
        }
        // Páginas acessadas pelo técnico (prestador de serviços)
        if($users['users_types_id'] === 6){
            $this->redirect(['action' => 'tecnicpage']);
        }
    }

    public function administrator() {
        $count_users = $this->query("SELECT 
        SUM( CASE WHEN users_types_id = 6 AND active = 1 THEN 1 ELSE 0 END ) as `tecnico`, 
        SUM( CASE WHEN users_types_id = 6 AND active = 0 THEN 1 ELSE 0 END ) as `tecnicoinativo`, 
        SUM( CASE WHEN users_types_id = 5 AND active = 1 THEN 1 ELSE 0 END ) as `cliente`,
        SUM( CASE WHEN users_types_id = 5 AND active = 0 THEN 1 ELSE 0 END ) as `clienteinativo`
        FROM `users`")[0];

        $count_processos = $this->query("SELECT 
        SUM( CASE WHEN status_cliente = 'carrinho' THEN 1 ELSE 0 END
        ) as 'Carrinho',
        SUM( CASE WHEN status = 'requisitado' AND status_cliente = 'aceito' THEN 1 ELSE 0 END
        ) as 'Em_espera',
        SUM( CASE WHEN status = 'aceito' AND status_cliente = 'aceito' THEN 1 ELSE 0 END
        ) as 'Andamento',
        SUM( CASE WHEN status = 'negado' AND status_cliente = 'aceito' THEN 1 ELSE 0 END
        ) as 'Negado',
        SUM( CASE WHEN status = 'finalizado' AND status_cliente = 'finalizado' THEN 1 ELSE 0 END
        ) as 'Finalizado',
        SUM( CASE WHEN status = 'finalizado' AND status_cliente <> 'finalizado' THEN 1 ELSE 0 END
        ) as 'FinalizadoTec',
        SUM( CASE WHEN status <> 'finalizado' AND status_cliente = 'finalizado' THEN 1 ELSE 0 END
        ) as 'FinalizadoCliente',
        SUM( CASE WHEN status = 'avaliado' AND status_cliente = 'avaliado' THEN 1 ELSE 0 END
        ) as 'Avaliado',
        SUM( CASE WHEN status = 'avaliado' AND status_cliente <> 'avaliado' THEN 1 ELSE 0 END
        ) as 'AvaliadoTec',
        SUM( CASE WHEN status <> 'avaliado' AND status_cliente = 'avaliado' THEN 1 ELSE 0 END
        ) as 'AvaliadoCliente'
        FROM `shopping_cart`")[0];

        $this->set(compact('count_users','count_processos'));

        $cout_people_month  = $this->query("SELECT dt.mes, dt.ano,
                                                SUM(CASE WHEN users_types_id = 5 THEN 1 ELSE 0 END) as `cliente`,
                                                SUM(CASE WHEN users_types_id = 6 THEN 1 ELSE 0 END) as `tecnico` 
                                            FROM (
                                                SELECT MONTH(dt._date) as `mes`,
                                                        YEAR(dt._date) as `ano` 
                                                FROM datetable as dt GROUP BY 1,2) as `dt`
                                            LEFT JOIN  users as u
                                            ON dt.ano = YEAR(u.created) AND dt.mes = MONTH(u.created)
                                            WHERE u.created BETWEEN (CURDATE() - INTERVAL 12 MONTH) 
                                            AND CURDATE() OR u.created IS NULL
                                            GROUP BY 1 ORDER BY dt.ano,dt.mes"
        );  

        $cout_people_day = $this->query("SELECT dt.dia, dt.mes,
            SUM(CASE WHEN users_types_id = 5 THEN 1 ELSE 0 END) as `cliente`,
            SUM(CASE WHEN users_types_id = 6 THEN 1 ELSE 0 END) as `tecnico`
            FROM (SELECT MONTH(dt._date) as `mes`,
                         DAY(dt._date) as `dia`
            FROM datetable as dt GROUP BY 1,2) as `dt` 
            LEFT JOIN (SELECT * FROM users as u
            WHERE MONTH(u.created) = MONTH(now())) as u ON dt.dia = DAY(u.created) AND dt.mes = MONTH(u.created)
            WHERE dt.mes = MONTH(now()) 
            GROUP BY 2,1");

        $location_map = $this->query("SELECT people.name, users.users_types_id, latitude, longitude, address, number, district, complement, city, state
            FROM people INNER JOIN users WHERE people.cpf = users.cpf");

        $cout_people_month_json = null;
        $cout_people_day_json = null;
        $aux_cliente = 0;
        $aux_tecnico = 0;

        foreach ($cout_people_month as $cout_people) {
            $aux_cliente += $cout_people->cliente;
            $aux_tecnico += $cout_people->tecnico;
            $aux_total = $aux_cliente + $aux_tecnico;
            
            $cout_people_month_json .= '{mes:"'.$this->Nomemes($cout_people->mes).'/'.$cout_people->ano.'",';
            $cout_people_month_json .= 'cliente'.':'.$aux_cliente.
                                   ','.'tecnico'.':'.$aux_tecnico.
                                   ','.'total'.':'.$aux_total.'},';
    
        }

    
        foreach ($cout_people_day as $cout_people) {
            $auxcliente += $cout_people->cliente;
            $auxtecnico += $cout_people->tecnico;
            $auxtotal = $auxcliente + $auxtecnico;

            $cout_people_day_json .= '{dia:"'.$cout_people->dia.'/'.$this->Nomemes($cout_people->mes).'",';
            $cout_people_day_json .= 'cliente'.':'.$cout_people->cliente.
                                 ','.'tecnico'.':'.$cout_people->tecnico.
                                 ','.'total'.':'.$auxtotal.'},';
        }

        // $this->d($location_map);

        $local = '[';

        foreach ($location_map as $local_map) {
            $local .= '{"latitude": "'.$local_map->latitude.'",'; 
            $local .= '"longitude": "'.$local_map->longitude.'",';
            $local .= '"name": "'.$local_map->name.'",';
            $local .= '"address": "'.$local_map->address.'",';
            $local .= '"number": "'.$local_map->number.'",';
            $local .= '"district": "'.$local_map->district.'",';
            $local .= '"complement": "'.$local_map->complement.'",';
            $local .= '"usertype": "'.$local_map->users_types_id.'"},';
        }

        $cout_people_month_json = substr($cout_people_month_json,0,-1);
        $cout_people_day_json = substr($cout_people_day_json,0,-1);
        $local = substr($local,0,-1);
        $local .= ']';
        
        $ativos = $count_users->tecnico + $count_users->cliente;
        $inativos = $count_users->tecnicoinativo + $count_users->clienteinativo;
        $total = $count_users->tecnico + $count_users->cliente;

        $this->set([
            'cout_people_month_json'=>$cout_people_month_json,
            'cout_people_day_json'=>$cout_people_day_json,
            'cout_people_month' => $cout_people_month,
            'cout_people_day' => $cout_people_day,
            'local' => $local,
            'tecnico' => $count_users->tecnico,
            'cliente' => $count_users->cliente,
            'tecnicoinativo' => $count_users->tecnicoinativo,
            'clienteinativo' => $count_users->clienteinativo,
            'ativos' => $ativos,
            'inativos' => $inativos,
            'total' => $total,
        ]);

    }

    public function users() {
        
        $count = $this->request->session()->read('Auth.User.users_types_id');

        // Filtro para mostrar os menus que somente aquele tipo de usuário poderá visualizar
        $count_menus = "SELECT modules.id, modules.name, modules.icon,
            permissions.id, permissions.name, permissions.controller, users_types.type
            FROM users_types
            INNER JOIN permissions
            INNER JOIN users_types_has_modules
            INNER JOIN modules
            WHERE users_types_has_modules.users_types_id = users_types.id
            AND users_types_has_modules.modules_id = modules.id
            AND permissions.modules_id = modules.id
            AND users_types.id = ". $count;

        // $count_menus = 'SELECT modules.id, modules.name, modules.icon FROM modules';
        $menus = $this->query($count_menus);

        $usuario = $this->request->session()->read('Auth.User');
        
        // Puxar a informação da data de nascimento do banco
        $data = $usuario['person']['date_of_birth'];
        list($mes, $dia, $ano) = explode('/',$data);
        $data = $dia.'/'.$mes.'/'.$ano;
        
        // Puxar a informação do email do banco
        $email = $usuario['email'];

        // Puxar a informação do número de contato do banco
        $number = $usuario['person']['number_contact'];
        $number = '('.substr($number,0,2).')'.substr($number,2,-4).'-'.substr($number,-4,4);

        // Puxar a informação do CEP do banco e dados
        $cep = $usuario['person']['cep'];

        // Puxar a informação da rua do banco e dados
        $rua = $usuario['person']['address'];
        // Puxar a informação do número do banco e dados
        $numero = $usuario['person']['number'];
        // Puxar a informação do bairro do banco e dados
        $bairro = $usuario['person']['district'];
        // Puxar a informação da cidade do banco e dados
        $cidade = $usuario['person']['city'];
        // Puxar a informação do estado do banco e dados
        $estado = $usuario['person']['state'];
        // Puxar a informação do sexo do banco e dados
        $genero = $usuario['person']['gender'];
        if($genero === 'N'){ $gender = 'Indefinido'; }
        else if($genero === 'masculino'){ $gender = 'Masculino'; }
        else if($genero === 'feminino'){ $gender = 'Feminino'; }

        // Puxar a informação do CPF do banco e dados
        $cpf = $usuario['cpf'];

        // Envia as variáveis para poder tratar a informação no front
        $this->set([
            'count' => $count,
            'count_menus' => $count_menus,
            'menus' => $menus,
            'data' => $data,
            'number' => $number,
            'cep' => $cep,
            'rua' => $rua,
            'numero' => $numero,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado,
            // 'gender' => $gender,
            'cpf' => $cpf,
            'tipo' => $usuario['users_types_id'],
        ]);
    }

    public function usersconfig() {

    }

    public function reports(){

    }

    public function support(){
        
    }

    public function clientpage(){
        $user = $this->request->session()->read('Auth.User');
        $users = json_encode($user);
        $usertype = $user['users_types_id'];
        $user_id = $user['person_id'];

        $count_status = $this->query("SELECT
                SUM( CASE WHEN client_id = ". $user['person_id'] ." AND status_cliente = 'carrinho' THEN 1 ELSE 0 END) AS 'carrinho',
                SUM( CASE WHEN client_id = ". $user['person_id'] ." AND status_cliente = 'aceito' AND status = 'requisitado' THEN 1 ELSE 0 END) AS 'espera',
                SUM( CASE WHEN client_id = ". $user['person_id'] ." AND status_cliente = 'aceito' AND status = 'aceito' THEN 1 ELSE 0 END) AS 'andamento',
                SUM( CASE WHEN client_id = ". $user['person_id'] ." AND status_cliente = 'aceito' AND status = 'negado' THEN 1 ELSE 0 END) AS 'negado',
                SUM( CASE WHEN client_id = ". $user['person_id'] ." AND (status_cliente = 'finalizado' OR status = 'finalizado') THEN 1 ELSE 0 END) AS 'finalizado',
                SUM( CASE WHEN client_id = ". $user['person_id'] ." AND (status_cliente = 'avaliado' OR status = 'avaliado') THEN 1 ELSE 0 END) AS 'avaliado',
                SUM( CASE WHEN client_id = ". $user['person_id'] ." AND (status_cliente = 'avaliado' OR status_cliente = 'finalizado' OR status = 'avaliado' OR status = 'finalizado') THEN 1 ELSE 0 END) AS 'finish'
            FROM shopping_cart;")[0];

        $inprogress = $this->query("SELECT * FROM shopping_cart WHERE client_id = ".$user['person_id']." AND status_cliente = 'aceito' AND status = 'aceito';")[0];

        $finalizados = $count_status->finalizado;
        $andamento = $count_status->andamento;
        $negado = $count_status->negado;
        $espera = $count_status->espera;
        $avaliado = $count_status->avaliado;
        $finish = $count_status->finish;
        
        $this->set(compact('users','usertype', 'user_id', 'count_status'));
    }

    public function tecnicpage(){
        $user = $this->request->session()->read('Auth.User');
        $users = json_encode($user);
        $usertype = $user['users_types_id'];
        $user_id = $user['person_id'];

        $count_status = $this->query("SELECT
                SUM( CASE WHEN company_id = ". $user['person_id'] ." AND status_cliente = 'carrinho' THEN 1 ELSE 0 END) AS 'carrinho',
                SUM( CASE WHEN company_id = ". $user['person_id'] ." AND status_cliente = 'aceito' AND status = 'requisitado' THEN 1 ELSE 0 END) AS 'espera',
                SUM( CASE WHEN company_id = ". $user['person_id'] ." AND status_cliente = 'aceito' AND status = 'aceito' THEN 1 ELSE 0 END) AS 'andamento',
                SUM( CASE WHEN company_id = ". $user['person_id'] ." AND status_cliente = 'aceito' AND status = 'negado' THEN 1 ELSE 0 END) AS 'negado',
                SUM( CASE WHEN company_id = ". $user['person_id'] ." AND (status_cliente = 'finalizado' OR status = 'finalizado') THEN 1 ELSE 0 END) AS 'finalizado',
                SUM( CASE WHEN company_id = ". $user['person_id'] ." AND (status_cliente = 'avaliado' OR status = 'avaliado') THEN 1 ELSE 0 END) AS 'avaliado',
                SUM( CASE WHEN company_id = ". $user['person_id'] ." AND (status_cliente = 'avaliado' OR status_cliente = 'finalizado' OR status = 'avaliado' OR status = 'finalizado') THEN 1 ELSE 0 END) AS 'finish'
            FROM shopping_cart;")[0];

        $inprogress = $this->query("SELECT * FROM shopping_cart WHERE company_id = ".$user['person_id']." AND status_cliente = 'aceito' AND status = 'aceito';")[0];

        $finalizados = $count_status->finalizado;
        $andamento = $count_status->andamento;
        $negado = $count_status->negado;
        $espera = $count_status->espera;
        $avaliado = $count_status->avaliado;
        $finish = $count_status->finish;
        
        $this->set(compact('users','usertype', 'user_id', 'count_status'));
    }

    public function inprogress(){
        $user = $this->request->session()->read('Auth.User');
        $users = json_encode($user);
        $usertype = $user['users_types_id'];
        $user_id = $user['person_id'];
        
        if($usertype === 5)
        {
            $services = $this->query("SELECT * FROM shopping_cart WHERE status = 'aceito' AND status_cliente = 'aceito' AND client_id = ".$user['id']);
            $teste = "";
            for($i=0; $i < count($services); $i++) {
                $teste = explode('/',$services[$i]->dia);
                $services[$i]->dia = $teste[2].'/'.$teste[1].'/'.$teste[0];
            }
            $service = json_encode($services);

            $this->set(compact('user', 'services'));
        } else if($usertype === 6){
            $services = $this->query("SELECT * FROM shopping_cart WHERE status = 'aceito' AND status_cliente = 'aceito' AND company_id = ".$user['id']);
            $teste = "";
            for($i=0; $i < count($services); $i++) {
                $teste = explode('/',$services[$i]->dia);
                $services[$i]->dia = $teste[2].'/'.$teste[1].'/'.$teste[0];
            }
            $service = json_encode($services);

            $this->set(compact('user', 'services'));
        }
    }
    public function finished(){
        $user = $this->request->session()->read('Auth.User');
        $users = json_encode($user);
        $usertype = $user['users_types_id'];
        $user_id = $user['person_id'];
        
        if($usertype === 5)
        {
            $services = $this->query("SELECT * FROM shopping_cart WHERE (status_cliente = 'avaliado' OR status_cliente = 'finalizado' OR status = 'avaliado' OR status = 'finalizado') AND client_id = ".$user['id']);
            $teste = "";
            for($i=0; $i < count($services); $i++) {
                $teste = explode('/',$services[$i]->dia);
                $services[$i]->dia = $teste[2].'/'.$teste[1].'/'.$teste[0];
            }
            $service = json_encode($services);

            $this->set(compact('user', 'services'));
        }
        else if($usertype === 6)
        {
            $services = $this->query("SELECT * FROM shopping_cart WHERE (status_cliente = 'avaliado' OR status_cliente = 'finalizado' OR status = 'avaliado' OR status = 'finalizado') AND company_id = ".$user['id']);
            $teste = "";
            for($i=0; $i < count($services); $i++) {
                $teste = explode('/',$services[$i]->dia);
                $services[$i]->dia = $teste[2].'/'.$teste[1].'/'.$teste[0];
            }
            $service = json_encode($services);

            $this->set(compact('user', 'services','usertype'));
        }
    }

    public function d($value,$message = null){
		debug($value);
		if(isset($message)){
			throw new Exception($message);
		}
		exit();
	}
}