<?php
$general = [
    'label'       => 'Funcionário',
    'label_s'     => 'Visualizar',
    'actual'      => 'visualizar funcionário',
    'breadcrumbs' => [
        [
            'label' => 'Listar funcionário',
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
                <h4 class="mt-0 header-title">Visualizar dados de funcionário</h4>
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
                                    <td><?= $user->name ?></td>
                                </tr>
                                <tr>                         
                                    <td>Apelido</td>
                                    <td><?= $user->nickname ?></td>
                                </tr>                  
                                <tr>
                                    <td>CPF</td>
                                    <td><?= substr($user->person->cpf,0,3) ?>***</td>
                                </tr>
                                <tr>                         
                                    <td>RG</td>
                                    <td><?=$this->Mask("##.###.###-#",$user->person->rg) ?></td>
                                </tr>
                                <tr>                         
                                    <td>Instituto RG</td>
                                    <td><?=$user->person->institution_rg ?> </td>
                                </tr>
                                <tr>                         
                                    <td>Data de aniversário </td>
                                    <td><?=$user->person->date_of_birth->i18nFormat("dd/MM/yyyy")?></td>
                                </tr>
                                <tr>                         
                                    <td>E-mail</td>
                                    <td><?= $user->person->email ?></td>
                                </tr>
                                <tr>                         
                                    <td>CEP </td>
                                    <td><?= $this->Mask("#####-###",$user->person->cep) ?></td>
                                </tr>
                                <tr>                         
                                    <td>Rua </td>
                                    <td><?= $user->person->address ?></td>
                                </tr>
                                <tr>                         
                                    <td>Número  </td>
                                    <td><?= $user->person->number ?></td>
                                </tr>
                                <tr>                         
                                    <td>Bairro  </td>
                                    <td><?= $user->person->district ?></td>
                                </tr>
                                <tr>                         
                                    <td>Cidade  </td>
                                    <td><?= $user->person->city ?></td>
                                </tr>
                                <tr>                         
                                    <td>Estado  </td>
                                    <td><?= $user->person->state ?></td>
                                </tr>
                                <tr>                         
                                    <td>Sexo  </td>
                                    <td><?= $user->person->gender ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-0">
                                <?= $this->Html->link('Editar', ['action' => 'edit', $user->id], ['escape' => false, 'class' => 'btn btn-primary waves-effect waves-light']) ?>
                                <?= $this->Html->link('Cancelar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary waves-effect m-l-5']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    
