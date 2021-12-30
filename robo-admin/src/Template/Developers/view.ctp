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
         

                    <table class="table">
                      <thead>
                        <tr>
                          <th>Campo</th>
                          <th>Valor</th>                         
                        </tr>
                      </thead>
                      <tbody>
                        <tr>                         
                          <td>Nome</td>
                          <td><?=$user->name?></td>
                        </tr>
                        <tr>                         
                          <td>Email</td>
                          <td><?=$user->email?></td>
                        </tr>
                        <tr>                         
                          <td>Perfil</td>
                          <td><?=$user->users_type->type?></td>
                        </tr>
                        <tr>                         
                          <td>Empresa</td>
                          <td><?=$user->company->name?></td>
                        </tr>
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
                           <?=$this->Html->link('Editar', ['action' => 'edit',$user->id],['escape' => false, 'class'=> 'btn btn-primary waves-effect waves-light'])?>
                           <?=$this->Html->link('Cancelar', ['action' => 'index'],['escape' => false, 'class'=> 'btn btn-secondary waves-effect m-l-5'])?>
                        </div>
                      </div>
              </div>
                  </div>
                </div>
              </div>
            </div>
       </div>               
