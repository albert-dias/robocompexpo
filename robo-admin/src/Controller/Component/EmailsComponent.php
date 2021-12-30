<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use SendGrid\Mail\Mail;
use Cake\ORM\TableRegistry;

/**
 * Emails component
 */
class EmailsComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public function sendEmailBemVindo($data)
    {
        $email = new Mail();
        $email->setFrom("sac@uzeh.com.br", "SAC uzeh");
        $email->setSubject("Bem-vindo ao uzeh");
        $email->addTo(
            $data['email'],
            $data['name'],
            [
                "name" => $data['name']
            ]
        );

        $email->setTemplateId('d-5feca100a7a641e1beb5bbafa422d021');
        $sendgrid = new \SendGrid('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');

        $log = [
            'email' => $data['email'],
            'send' => json_encode($email)
        ];
        try {
            $response = $sendgrid->send($email);
            $log['received'] = json_encode($response->headers());
        //    print $response->statusCode() . "\n";
        //    print_r($response->headers());
        //    print $response->body() . "\n";
        } catch (Exception $e) {
            $log['received'] = json_encode($e->getMessage());
            // echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        
        $this->logEmail($log);
    }

    public function sendEmailPassword($data)
    {
        $email = new Mail();
        $email->setFrom("sac@uzeh.com.br", "SAC uzeh");
        $email->setSubject("Recuperação de senha");
        $email->addTo(
            $data['email'],
            $data['name'],
            [
                "subject" => "Bem vindo",
                "nome" => $data['name'],
                "senha" => $data['password']
            ]
        );

        $email->setTemplateId('d-d6bbd7438722426c99163a6feabe7150');
        $sendgrid = new \SendGrid('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');

        $log = [
            'email' => $data['email'],
            'send' => json_encode($email)
        ];
        try {
            $response = $sendgrid->send($email);
            $log['received'] = json_encode($response->headers());
           // print $response->statusCode() . "\n";
           // print_r($response->headers());
           // print $response->body() . "\n";
        } catch (Exception $e) {
            $log['received'] = json_encode($e->getMessage());
            //echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        
        $this->logEmail($log);
    }
    public function sendEmailUserLiberado($data)
    {
        $email = new Mail();
        $email->setFrom("sac@uzeh.com.br", "SAC uzeh");
        $email->setSubject("Usário ativo!");
        $email->addTo(
            $data['email'],
            $data['name'],
            [
                "nome" => $data['name']
            ]
        );

        $email->setTemplateId('d-e3777173228e41759f10614568fa45bc');
        $sendgrid = new \SendGrid('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');

        $log = [
            'email' => $data['email'],
            'send' => json_encode($email)
        ];
        try {
            $response = $sendgrid->send($email);
            $log['received'] = json_encode($response->headers());
           // print $response->statusCode() . "\n";
           // print_r($response->headers());
           // print $response->body() . "\n";
        } catch (Exception $e) {
            $log['received'] = json_encode($e->getMessage());
            //echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        
        $this->logEmail($log);
    }
    public function sendEmailNotificationGerador($data)
    {
        $email = new Mail();
        $email->setFrom("sac@uzeh.com.br", "SAC uzeh");
        $email->setSubject("Existe uma nova resposta para sua coleta!");
        $email->addTo(
            $data['email'],
            $data['name'],
            [
                "nome" => $data['name'],
                "nome_coletor" => $data['nome_coletor'],
                "count_respontas" => $data['count_respontas'],
                "coletor" => $data['coletor']
            ]
        );

        $email->setTemplateId('d-a8d487e4e98949b385c2dd853e52f579');
        $sendgrid = new \SendGrid('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');

        $log = [
            'email' => $data['email'],
            'send' => json_encode($email)
        ];
        try {
            $response = $sendgrid->send($email);
            $log['received'] = json_encode($response->headers());
           // print $response->statusCode() . "\n";
           // print_r($response->headers());
           // print $response->body() . "\n";
        } catch (Exception $e) {
            $log['received'] = json_encode($e->getMessage());
            //echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        
        $this->logEmail($log);
    }
    public function sendEmailNotificationColetor($data)
    {
        $email = new Mail();
        $email->setFrom("sac@uzeh.com.br", "SAC uzeh");
        $email->setSubject("Existe uma nova resposta para sua coleta!");
        $email->addTo(
            $data['email'],
            $data['name'],
            [
                "nome" => $data['name'],
                "id_coleta" => $data['id_coleta'],
                "nome_gerador" => $data['nome_gerador'],
                "telefone" => $data['telefone'],
                "endereco" => $data['endereco']
            ]
        );

        $email->setTemplateId('d-335cb36999c44009802f2729b7784202');
        $sendgrid = new \SendGrid('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');

        $log = [
            'email' => $data['email'],
            'send' => json_encode($email)
        ];
        try {
            $response = $sendgrid->send($email);
            $log['received'] = json_encode($response->headers());
           // print $response->statusCode() . "\n";
           // print_r($response->headers());
           // print $response->body() . "\n";
        } catch (Exception $e) {
            $log['received'] = json_encode($e->getMessage());
            //echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        
        $this->logEmail($log);
    }

    private function logEmail($data){
        $e = TableRegistry::get('emails_log');
        
        $log = $e->newEntity();
        $log->email = $data['email'];
        $log->send = $data['send'];
        $log->received = $data['received'];

        $e->save($log);

    }

    public function sendEmailNewPassword($data)
    {
        $email = new Mail();
        $email->setFrom("sac@uzeh.com.br", "SAC uzeh");
        $email->setSubject("Recuperação de senha");
        $email->addTo(
            $data['email'],
            $data['name'],
            [
                "nome" => $data['name'],
                "senha" => $data['password'],
                "personalizations"=>[
                    "subject"=>"Recuperação de senha"
                ]
            ]
        );

        $email->setTemplateId('d-d6bbd7438722426c99163a6feabe7150');
        $sendgrid = new \SendGrid('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');

        $log = [
            'email' => $data['email'],
            'send' => json_encode($email)
        ];
        try {
            $response = $sendgrid->send($email);
            $log['received'] = json_encode($response->headers());
        //    print $response->statusCode() . "\n";
        //    print_r($response->headers());
        //    print $response->body() . "\n";
        } catch (Exception $e) {
            $log['received'] = json_encode($e->getMessage());
            // echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        
        $this->logEmail($log);
    }
    public function sendEmailResumoDoacao($data)
    {
        $email = new Mail();
        $email->setFrom("sac@uzeh.com.br", "SAC uzeh");
        $email->setSubject("Resumo da sua doação!");
        $email->addTo(
            $data['email'],
            $data['name'],
            [
                "nome" => $data['name'],
                "residuos"=>$data['residuos'],
                "id_coleta"=>$data['id_coleta'],
                "nome_coletor"=>$data['nome_coletor']
            ]
        );

        $email->setTemplateId('d-95cfd386e37e4e81a25b7bcf9b2548fd');
        $sendgrid = new \SendGrid('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');

        $log = [
            'email' => $data['email'],
            'send' => json_encode($email)
        ];
        try {
            $response = $sendgrid->send($email);
            $log['received'] = json_encode($response->headers());
        //    print $response->statusCode() . "\n";
        //    print_r($response->headers());
        //    print $response->body() . "\n";
        } catch (Exception $e) {
            $log['received'] = json_encode($e->getMessage());
            // echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        
        $this->logEmail($log);  
    }
    public function sendEmailResumoVenda($data)
    {
        $email = new Mail();
        $email->setFrom("sac@uzeh.com.br", "SAC uzeh");
        $email->setSubject("Resumo da sua doação!");
        $email->addTo(
            $data['email'],
            $data['name'],
            [
                "nome" => $data['name'],
                "residuos"=>$data['residuos'],
                "id_coleta"=>$data['id_coleta'],
                "total"=> (String) $data['total'],
                "nome_coletor"=>$data['nome_coletor']
            ]
        );

        $email->setTemplateId('d-a1aecb41f2554feeb186d79832cfc67f');
        $sendgrid = new \SendGrid('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');

        $log = [
            'email' => $data['email'],
            'send' => json_encode($email)
        ];
        try {
            $response = $sendgrid->send($email);
            $log['received'] = json_encode($response->headers());
        //    print $response->statusCode() . "\n";
        //    print_r($response->headers());
        //    print $response->body() . "\n";
        } catch (Exception $e) {
            $log['received'] = json_encode($e->getMessage());
            // echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        
        $this->logEmail($log);  
    }
}
