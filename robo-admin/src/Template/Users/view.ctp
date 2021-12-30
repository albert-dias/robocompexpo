<?php

$general = [
    'label'       => 'Usuários',
    'label_s'     => 'Visualizar',
    'actual'      => 'visualizar usuário',
    'breadcrumbs' => [
        [
            'label' => 'Listar usuários',
            'link'  => ['action' => 'index']
        ]
    ]
];

echo $this->element('Layout/_content_header', [
    'title'       => $general['label'],
    'small_title' => $general['label_s'],
    'actual'      => $general['actual'],
    'breadcrumbs' => $general['breadcrumbs'],
]);
?>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Visualizar usuário</h4>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div> 
                  <div class="x_content">
                    <br />
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php $cpf = null; if(strlen($user->cpf) == 11): $cpf = true; endif; ?>

                    <table class="table">
                      <thead>
                        <tr>
                          <th>Campo</th>
                          <th>Valor</th>                         
                        </tr>
                      </thead>
                      <tbody>
                      <?php if($cpf){ ?>
                        <tr>                         
                          <td>Nome</td>
                          <td><?=$user->name?></td>
                        </tr>
                        <tr>                         
                          <td>Apelido</td>
                          <td><?=$user->nickname?></td>
                        </tr>
                        <tr>                         
                          <td>RG</td>
                          <td><?=$user->person->rg?></td>
                        </tr>
                        <tr>                         
                          <td>Instituto rg</td>
                          <td><?=$user->person->institution_rg?></td>
                        </tr>
                        <tr>                         
                          <td>Data de aniversário</td>
                          <td><?= $user->person->date_of_birth == null ?  "Data não cadastrada" : $user->person->date_of_birth->i18nFormat("yyyy-MM-dd")?></td>
                        </tr>
                      <?php }else{ ?>
                        <tr>                         
                          <td>Razão social</td>
                          <td><?=$user->name?></td>
                        </tr>
                        <tr>                         
                          <td>Nome Fantasia</td>
                          <td><?=$user->nickname?></td>
                        </tr>
                        <tr>                         
                          <td>Data de abertura</td>
                          <td><?= $user->person->date_of_birth == null ?  "Data não cadastrada" : $user->person->date_of_birth->i18nFormat("yyyy-MM-dd")?></td>
                        </tr>
                      <?php } ?>
                       
                        <tr>                         
                          <td>Email</td>
                          <td><?=$user->email?></td>
                        </tr>
                        <tr>                         
                          <td>Número para contato </td>
                          <td><?= $this->TophoneBR($user->person->number_contact)?></td>
                        </tr>
                        <tr>                         
                          <td>CPF/CNPJ</td>
                          <td><?= $this->formatCnpjCpf($user->cpf)?></td>
                        </tr>
                        <tr>                         
                          <td>Perfil</td>
                          <td><?=$user->users_type->type?></td>
                        </tr>
                        <?php if($user->plans_id){ ?>
                        <tr>                         
                          <td>Plano</td>
                          <td><?=$user->plan->title?></td>
                        </tr>
                        <?php } ?>
                        <tr>                         
                          <td>CEP </td>
                          <td><?=$this->Mask("#####-###",$user->person->cep)?></td>
                        </tr>
                        <tr>                         
                          <td>Rua </td>
                          <td><?=$user->person->address?></td>
                        </tr>
                        <tr>                         
                          <td>Número </td>
                          <td><?=$user->person->number?></td>
                        </tr>
                        <tr>                         
                          <td>Complemento  </td>
                          <td><?=$user->person->complement?></td>
                        </tr>
                        <tr>                         
                          <td>Bairro</td>
                          <td><?=$user->person->district?></td>
                        </tr>
                        <tr>                         
                          <td>Cidade </td>
                          <td><?=$user->person->city?></td>
                        </tr>
                        <tr>                         
                          <td>Estado </td>
                          <td><?=$user->person->state?></td>
                        </tr>
                        <?php if($cpf){ ?>
                        <tr>                         
                          <td>Sexo </td>
                          <td><?= $this->Sexo($user->person->gender)?></td>
                        </tr>
                        <tr>    
                        <?php }?>  
                        <?php if($user->users_types_id == 4 || $user->users_types_id == 6){?>                   
                          <td>Materias  </td>
                          <td><?php 
                            $aux = null;
                            foreach ($UsersCategories as $value) {
                              $aux .= $value->name .", ";
                              
                            }
                            echo substr($aux,0,-2);
                          ?></td>
                        </tr>
                        <?php }?>
                        <tr>                         
                          <td>Ativo?</td>
                          <td><?=$user->active ? 'Sim':'Não'?></td>
                        </tr>
                        <tr>                         
                          <td>Criado em</td>
                          <td><?=$user->created?></td>
                        </tr>
                        <tr>                         
                          <td>Modificado em</td>
                          <td><?=$user->modified?></td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-4 col-md-offset-0">
                           <?php if($user->users_type->id == 4){?>
                              <?php if($usertype == 1) echo $this->Html->link('Editar', ['action' => 'edit',$user->id],['escape' => false, 'class'=> 'btn btn-primary waves-effect waves-light'])?>
                           <?php }else{?>
                              <?php if($usertype == 1) echo $this->Html->link('Editar', ['action' => 'editgerador',$user->id],['escape' => false, 'class'=> 'btn btn-primary waves-effect waves-light'])?>
                           <?php }?>
                           <?=$this->Html->link('Cancelar', ['action' => 'index'],['escape' => false, 'class'=> 'btn btn-secondary waves-effect m-l-5'])?>
                        </div>
                      </div>
              </div>
                  </div>
                </div>
              </div>
            </div>
       </div>               
