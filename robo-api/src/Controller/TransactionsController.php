<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use RestApi\Controller\ApiController;



/**
 * Transactions Controller
 *
 *
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransactionsController extends ApiController
{
    public $HTTP;

    public function initialize() {
        $c = Configure::read('GTW');
        $this->HTTP = new Client($c);
        return parent::initialize();
    }

    /**
     * Metodo para criar vendedores dentro do marketplace
     */
    public function createSellers()
    {
        $t = TableRegistry::get('Providers');

        $provider_id = $this->request->data('provider_id');

        $provider = $t->get($provider_id, [
            'contain' => 'People'
        ]);

        $name = explode(' ', $provider->person->name);
        
        $response = $this->HTTP->post('/sellers/individuals', [
            'id'                    => $provider->id,
            'status'                => 'new',
            'resource'              => '',
            'type'                  => 'individual',
            'account_balance'       => '0',
            'current_balance'       => '0',
            'fiscal_responsibility' => null,
            'first_name'            => $name[0],
            'last_name'             => end($name),
            'email'                 => $provider->person->email,
            'phone_number'          => $provider->person->number_contact,
            'taxpayer_id'           => $provider->person->cpf,
            'birthdate'             => $provider->person->date_of_birth->format('Y-m'),
            'statement_descriptor'  => null,
            'description'           => 'Prestador',
            'address'               => [
                'line1'        => $provider->person->andress . ', ' . $provider->person->number,
                'line2'        => $provider->person->district,
                'line3'        => $provider->person->complement,
                'neighborhood' => '',
                'city'         => $provider->person->city,
                'state'        => $provider->person->state,
                'postal_code'  => $provider->person->cep,
                'country_code' => 'BR',
            ],
            'delinquent'     => true,
            'default_debit'  => null,
            'default_credit' => null,
            'mcc'            => null,
            'metadata'       => null,
            'created_at'     => date('Y-m-d h:i:s'),
            'updated_at'     => date('Y-m-d h:i:s'), 
        ]);

        $obj = json_decode($response->body);

        if (isset($obj->id) && $obj->id) {
            $this->apiResponse = [
                'save' => true,
                'id' => $obj->id
            ];  
            return;
        }

        $this->responseStatus = false;
        $this->apiResponse = [
            'save' => false,
            'msg_erro' => 'Erro ao cadastrar vendedor ao gatway de pagamento. '.$obj->error->message.' cod: '.$obj->error->status_code
        ]; 
        
    }

    public function createTrasaction()
    {
            $sallers_id = $this->request->data('sallers_id');
            
            $obj = [
                "amount" => "20000",
                "currency" => 'BRL',
                "description" => "pagamento",
                "on_behalf_of" => "c4ea2b094b6c4d3ca3f65ddecd1b2320",
                "statement_descriptor" => "LOJA JOAO",
                "payment_type" => "credit",
                "source" => [
                    "usage" => "single_use",
                    "amount" => "20000",
                    "currency"=> "BRL",
                    "type"=> "card",
                    "card" => [
                        "card_number"=> "5201561050024014",
                        "holder_name" => "João Silva",
                        "expiration_month"=> "03",
                        "expiration_year"=> "2018",
                        "security_code"=> "123"
                    ],
                    
                    ],
                    "split_rules" =>[
                        [
                          "recipient" => $sallers_id,
                          "liable"=> "1",
                          "charge_processing_fee" => "0",
                          "percentage" => "90",
                          //"amount"=> "630"
                        ]
                      ] 
                    
            ];

            $response = $this->HTTP->post('/transactions',$obj);
            
            
            debug($response->body);
            die();

/*
           
            "source": {
                "type": "<string>",
                "usage": "single_use",
                "amount": "<integer>",
                "currency": "<string>",
                "description": "<string>",
                "capture": "<boolean>",
                "on_behalf_of": "<string>",
                "reference_id": "<string>",
                "card": {
                    "id": "<string>",
                    "amount": "<integer>",
                    "holder_name": "<string>",
                    "expiration_month": "<string>",
                    "expiration_year": "<string>",
                    "card_number": "<string>",
                    "security_code": "<string>"
                },
                "cards": [
                    {
                        "id": "<string>",
                        "amount": "<integer>",
                        "holder_name": "<string>",
                        "expiration_month": "<string>",
                        "expiration_year": "<string>",
                        "card_number": "<string>",
                        "security_code": "<string>"
                    },
                    {
                        "id": "<string>",
                        "amount": "<integer>",
                        "holder_name": "<string>",
                        "expiration_month": "<string>",
                        "expiration_year": "<string>",
                        "card_number": "<string>",
                        "security_code": "<string>"
                    }
                ],
                "installment_plan": {
                    "mode": "<string>",
                    "number_installments": "<integer>"
                },
                "statement_descriptor": "<string>",
                "customer": {
                    "id": "<string>",
                    "amount": "<integer>"
                },
                "token": {
                    "id": "<string>",
                    "amount": "<integer>"
                },
                "metadata": "<object>"
            },
            "installment_plan": {
                "mode": "<string>",
                "number_installments": "<integer>"
            },
            "statement_descriptor": "<string>",
            "customer": "<string>",
            "token": "<string>",
            "metadata": "<object>"
        }*/
    }

    public function tokenCard(){

        $obj = [
           "holder_name" =>  "João Silva",
           "expiration_month" =>  "03",
           "expiration_year" =>  "2018",
           "security_code" =>  "123",
           "card_number" =>  "5201561050024014"
        ];

        $response = $this->HTTP->post('/cards/tokens',$obj);

        debug($response->body);
        die();
    }

    public function createTrasactionToken()
    {
        $obj = [
            "amount"               => "1360",
            "currency"             => 'BRL',
            "description"          => "pagamento",
           // "on_behalf_of"         => "2c279f27f48946c89899841bee9d17f5",
            "on_behalf_of"         => "f1c24f9417d745b3b91be8bfa1f920d4",
            "statement_descriptor" => "Loja China",
            "payment_type"         => "credit",
            "token"                => "09d15692452b49749a33069e8c334a7c",
            "split_rules" => [
                [
                    "recipient"             => "008247e01be54be381a99c6481bce2e7",
                    "liable"                => "1",
                    "charge_processing_fee" => "0",
                    "percentage"            => "50",
                    //"amount"=> "630"
                ]
            ]

        ];

            $response = $this->HTTP->post('/transactions',$obj);
            
            debug($response->body);
            die();
        }
}
