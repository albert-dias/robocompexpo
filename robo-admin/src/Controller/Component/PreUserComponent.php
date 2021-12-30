<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;
/**
 * PreUser component
 */
class PreUserComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function run($email, $type_user, $type_action, $company_id, $name, $person_id){
        
        if(!$this->checkUser($email)){
            
            $this->removePreUser($email);
            
            $u = TableRegistry::get('PreUsers');
            $user = $u->newEntity();
            $user->company_id = $company_id;
            $user->users_type_id = $type_user;
            $user->people_id = $person_id;
            $user->email = $email;
            $user->hash = md5(uniqid(rand(), true));
            $user->type_action = $type_action;            
            
            if($u->save($user)){
                $this->sendMailNewCount($email, $user->hash, $name);
            }
        }        
    }
    
    private function checkUser($email) {
        $users = TableRegistry::get('Users');
        $u     = $users->find()->where(['email' => $email, 'active' => true])->toArray();

        if ($u) {
            return true;
        }

        return false;
    }
    
    private function removePreUser($email){
      $users = TableRegistry::get('PreUsers');  
      return $users->deleteAll(['email' => $email]);
    }
    
    private function sendMailNewCount($mail, $hash, $name) {

        $email = new Email();
        $email->transport('gmail');


        try {
            $res = $email->from(['contato@snad.com.br'=>'Avaliação de Desempenho'])
                    ->to([$mail])
                    ->subject('Nova Conta')
                     ->emailFormat('html')
                    ->send($this->emailText($name, $hash));
        } catch (Exception $e) {
            echo 'Exception : ', $e->getMessage(), "\n";
        //    die();
        }
    }
    
    private function emailText($name, $hash) {

        $_titulo       = 'Olá ' . $name . ', bem vindo ao SNAD';
        $_texto        = 'Você foi cadastrado(a) com sucesso no sistema nacional '
                . 'de análise de desempenho. Para criar sua senha e ter acesso ao '
                . 'sistema basta clicar no link abaixo.';
        $_texto_button = 'Criar senha';
        $_url_link     = Router::url(array('controller' => 'createdPass', 'action' => 'create', 'key'=>$hash), true);
        
        return '<html>

<head>
  <style>
    body {
      margin: 0;
      padding: 0;
    }

    @media only screen and (max-width: 640px) {
      table {
        width: 100% !important;
        min-width: 200px !important;
      }

      img[class="partial-image"] {
        width: 100% !important;
        min-width: 120px !important;
      }
    }
  </style>
</head>

<body topmargin="0" leftmargin="0">
  <!--?xml encoding="utf-8" ?-->
  <table style="border-collapse: collapse; border-spacing: 0; min-height: 418px;" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFFFFF">
    <tbody>
      <tr>
        <td align="center" style="border-collapse: collapse; padding-top: 30px; padding-bottom: 30px;">
          <table cellpadding="5" cellspacing="5" width="600" bgcolor="white" style="border-collapse: collapse; border-spacing: 0;">
            <tbody>
              <tr>
                <td style="border-collapse: collapse; width: 600px; padding: 0px; text-align: center;">
                  <table style="border-collapse: collapse; border-spacing: 0; position: relative; min-height: 40px; width: 100%; box-sizing: border-box; font-family: Arial; font-size: 25px; text-align: center; padding-top: 20px; padding-bottom: 20px; vertical-align: middle;">
                    <tbody>
                      <tr>
                        <td style="border-collapse: collapse; padding: 10px 15px; font-family: Arial;">
                          <table width="100%" style="border-collapse: collapse; border-spacing: 0; font-family: Arial;">
                            <tbody>
                              <tr>
                                <td style="border-collapse: collapse;">
                                  <h2 style="font-weight: normal; padding: 0px; margin: 0px; word-wrap: break-word; color: rgb(0,0,0); font-size: 35px;"><a style="text-decoration: none; display: inline-block; font-family: arial; box-sizing: border-box; word-wrap: break-word; width: 100%; text-align: center; color: rgb(0,0,0); font-size: 35px;"
                                      target="_blank"><span style="font-size: inherit; width: 100%; text-align: center; color: rgb(0,0,0);">' . $_titulo . '</span></a></h2>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table style="border-collapse: collapse; border-spacing: 0; position: relative; min-height: 40px; width: 100%; box-sizing: border-box; padding-top: 0px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; max-width: 600px; text-align: center;">
                    <tbody>
                      <tr>
                        <td style="border-collapse: collapse; font-family: Arial; line-height: 0px; mso-line-height-rule: exactly; padding: 0px;">

                        </td>
                      </tr>
                    </tbody>
                  </table>

                  <table style="border-collapse: collapse; border-spacing: 0; position: relative; min-height: 40px; width: 100%; box-sizing: border-box;">
                    <tbody>
                      <tr>
                        <td style="border-collapse: collapse; padding: 10px 15px; font-family: Arial;">
                          <table width="100%" style="border-collapse: collapse; border-spacing: 0; text-align: left; font-family: Arial;">
                            <tbody>
                              <tr>
                                <td style="border-collapse: collapse;">
                                  <div style="font-family: Arial; font-size: 15px; line-height: 170%; text-align: left; font-weight: normal; color: #666; word-wrap: break-word;">' . $_texto . '<span style="line-height: 0; display: none;"></span><span style="line-height: 0; display: none;"></span><br></div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table style="border-collapse: collapse; border-spacing: 0; position: relative; min-height: 40px; width: 100%; box-sizing: border-box; display: table;">
                    <tbody>
                      <tr>
                        <td style="border-collapse: collapse; padding: 10px 15px; font-family: Arial;">
                          <table width="100%" style="border-collapse: collapse; border-spacing: 0; font-family: Arial;">
                            <tbody>
                              <tr>
                                <td style="border-collapse: collapse;">
                                  <hr style="border-color: #BBB; border-style: dashed;">
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table style="border-collapse: collapse; border-spacing: 0; min-height: 40px; width: 100%; box-sizing: border-box; padding-top: 10px; padding-bottom: 10px; position: relative; z-index: 10; top: 0px; left: 0px;">
                    <tbody>
                      <tr>
                        <td style="border-collapse: collapse; padding: 10px 15px; font-family: Arial;">
                          <div style="font-family: Arial; text-align: center;">
                            <table style="border-collapse: collapse; border-spacing: 0; font-family: Arial; font-size: 15px; color: rgb(255,255,255); font-weight: bold; border-radius: 10px; display: inline-block; text-align: center; background-color: rgb(26,153,56);">
                              <tbody style="display: inline-block;">
                                <tr style="display: inline-block;">
                                  <td align="center" style="border-collapse: collapse; display: inline-block; padding: 15px 20px;"><a href="' . $_url_link . '" target="_blank" style="text-decoration: none; font-family: arial; box-sizing: border-box; color: #fff; font-weight: bold; margin: 0px; padding: 0px; text-align: center; font-size: 15px; display: inline-block; word-wrap: break-word; width: 100%;">' . $_texto_button . '</a></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>

                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</body>

</html>';
    }

}
