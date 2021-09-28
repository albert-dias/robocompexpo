<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use RestApi\Controller\ApiController;

/**
 * Leads Controller
 *
 * @property \App\Model\Table\LeadsTable $Leads
 *
 * @method \App\Model\Entity\Lead[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LeadsController extends ApiController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function initialize(){
        parent::initialize();
        $this->loadModel('Users');
    }

    public function site()
    {
        $name   = $this->request->data('name');
        $email  = $this->request->data('email');
        $phone  = $this->request->data('phone');
        $type   = $this->request->data('type');

        $lead = $this->Leads->newEntity();

        $lead->companies_id     = 1;
        $lead->origin           = 'site';
        $lead->name             = $name;
        $lead->email            = $email;
        $lead->phone            = $phone;
        $lead->others_data	    = "{type:$type}";

        if($this->Leads->save($lead)){
            $this->apiResponse = true;
            return;
        }
        
        $this->apiResponse = 'Erro ao salvar';
        
    }
   
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function portalSite()
    {
        header("Access-Control-Allow-Origin: *");
        $name           = $this->request->data('name');
        $email          = $this->request->data('email');
        $phone          = $this->request->data('phone');
        $cep            = $this->request->data('cep');
        $msg            = $this->request->data('message');
        $type_form      = $this->request->data('type_form');

        $lead = $this->Leads->newEntity();

        $lead->companies_id     = 1;
        $lead->origin           = 'site';
        $lead->name             = $name;
        $lead->email            = $email;
        $lead->phone            = $phone;
        $lead->others_data	    = "{
                                    cep:$cep,
                                    msg:$msg,
                                    type_form: $type_form
                                   }";

        if($this->Leads->save($lead)){
            $this->apiResponse = true;
            return;
        }
        
        $this->apiResponse = 'Erro ao salvar';
        
    }

    public function app($id = 0) {
        $lead = null;
        if (intval($id) === 0) {
            $cpf = $this->removeCarcter($this->request->data('numero_cpf'));
            if ($cpf) {
                $lead = $this->Leads->find('all')->where(['Leads.cpf' => $cpf])->first();
                if (is_null($lead)) {
                    $lead = $this->Leads->newEntity();
                    $lead->cpf = $cpf;
                }
            }
            $lead->origin = 'app';
            $lead->companies_id = 1;
        } else {
            $lead = $this->Leads->get(intval($id));
        }

        if($this->request->data('user_type')) {
            $users_types_id = $this->request->data('user_type');
            switch($users_types_id) {
                /* case 4:
                    $lead->type_lead = 'coletor';
                    break; */
                case 5:
                    $lead->type_lead = 'cliente';
                    break;
                case 6:
                    $lead->type_lead = 'fornecedor';
                    break;
                default:
                    break;
            }
        }

        if($this->request->data('name')){
            $lead->name = $this->request->data('name');}
        if($this->request->data('number_contact')){
            $lead->phone = $this->request->data('number_contact');}
        if($this->request->data('rg')){
            $lead->rg = $this->request->data('rg');}
        if($this->request->data('institution_rg')){
            $lead->institution_rg = $this->request->data('institution_rg');}
        if($this->request->data('date_of_birth')){
            $lead->date_of_birth = $this->request->data('date_of_birth');}
        if($this->request->data('email')){
            $lead->email = $this->request->data('email');}
        if($this->request->data('cep')){
            $lead->cep = $this->request->data('cep');}
        if($this->request->data('address')){
            $lead->address = $this->request->data('address');}
        if($this->request->data('number')){
            $lead->number = $this->request->data('number');}
        if($this->request->data('complement')){
            $lead->complement = $this->request->data('complement');}
        if($this->request->data('password')){
            $lead->password = $this->request->data('password');}
        if($this->request->data('city')){
            $lead->city = $this->request->data('city');}
        if($this->request->data('state')){
            $lead->state = $this->request->data('state');}
        if($this->request->data('district')){
            $lead->district = $this->request->data('district');}
        if($this->request->data('nickname')){
            $lead->nickname = $this->request->data('nickname');}
        if($this->request->data('category_id')){
            $lead->category_id = $this->request->data('category_id');}
        if($this->request->data('subcategory_id')){
            $lead->subcategory_id = $this->request->data('subcategory_id');}
        if($this->request->data('bank_code')){
            $lead->bank_code = $this->request->data('bank_code');}
        if($this->request->data('bank_agency')){
            $lead->bank_agency = $this->request->data('bank_agency');}
        if($this->request->data('bank_account')){
            $lead->bank_account = $this->request->data('bank_account');}
        if($this->request->data('como_conheceu_robocomp')){
            $lead->como_conheceu_robocomp = $this->request->data('como_conheceu_robocomp');}
        if($this->request->data('nome_pessoa_indicou')){
            $lead->nome_pessoa_indicou = $this->request->data('nome_pessoa_indicou');}
        if($this->request->data('tempo_experiencia')){
            $lead->tempo_experiencia = $this->request->data('tempo_experiencia');}
        if($this->request->data('latitude')){
            $lead->latitude = $this->request->data('latitude');}
        if($this->request->data('longitude')){
            $lead->longitude = $this->request->data('longitude');}
        if($this->request->data('gender')){
            $lead->gender = $this->request->data('gender');}

        if(intval($id) == 0) {
            if($this->Leads->save($lead))
                $this->apiResponse['id'] = $lead->id;
        } else {
            $this->Leads->save($lead);
            $this->apiResponse['id'] = $id;
        }

        return;
    }

    private function removeCarcter($string) {
        $remove = [
            ",", "/", ".", "-", "(", ")"," "
        ];

        $str = str_replace($remove, "", $string);

        return $str;
    }

    public function checkCPF() {
        $cpf        = $this->removeCarcter($this->request->data('cpf'));
        $tableUsers = TableRegistry::getTableLocator()->get('Users');

        $check = '';
        $check = $tableUsers->find()->where([
            "Users.cpf" => $cpf,
        ])->first();
        $this->apiResponse['cpf'] = $check;
        return;
    }
}
