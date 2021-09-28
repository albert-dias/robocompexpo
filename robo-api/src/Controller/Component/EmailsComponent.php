<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use SendGrid\Mail\Mail;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;

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

    public function sendEmailPassword($data)
    {
        $email = new Mail();
        $email->setFrom("contato@robocomp.com.br", "Robocomp");
        $email->setSubject("Novo Usuário");
        $email->addTo(
            $data['email'],
            $data['name'],
            [
                "subject" => "Bem vindo",
                "nome" => $data['name'],
                "senha" => $data['password']
            ]
        );

        $email->setTemplateId('d-5e5c32490a8146b5910ce26a692e727b');
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
    
    public function sendEmailNewPassword($data)
    {
        $email = new Mail();
        $email->setFrom("contato@robocomp.com.br", "Robocomp");
        $email->setSubject("Novo Senha");
        $email->addTo(
            $data['email'],
            $data['name'],
            [
                "subject" => "Nova senha",
                "nome" => $data['name'],
                "senha" => $data['password']
            ]
        );

        //$email->setTemplateId('d-e49772ecbc4146ebb6913461aecd0be6');
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
           return $response->body();
        } catch (Exception $e) {
            $log['received'] = json_encode($e->getMessage());
            //echo 'Caught exception: ' . $e->getMessage() . "\n";
            return null;
        }
        
        $this->logEmail($log);
    }

   private function logEmail($data){
        $e = TableRegistry::get('EmailsLog');
        
        $log = $e->newEntity();
        $log->email = $data['email'];
        $log->send = $data['send'];
        $log->received = $data['received'];

        $e->save($log);

    }

    public function sendEmailRecoverPassword($data) {
        $email = new Mail();
        $email->setFrom("robocomp@corpstek.com.br", "Robocomp");
        $email->setSubject("Nova senha");
        $email->addTo($data['email'], $data['name']);
        $email->addContent(
            "text/plain", "Essa é sua nova senha temporária, ao entrar no app novamente, lembre-se de alterá-la: ".$data['password']
        );
        $email->addContent(
            "text/html", "Essa é sua nova senha temporária, ao entrar no app novamente, lembre-se de alterá-la: ".$data['password']
        );
        $sendgrid = new \SendGrid('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');
        try {
            $response = $sendgrid->send($email);
            return $response->statusCode();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
        return null;
    }
}
