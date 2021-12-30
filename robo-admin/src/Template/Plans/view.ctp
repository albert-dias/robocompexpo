<?php
$general = [
    'label'       => 'Planos',
    'label_s'     => 'Visualizar',
    'actual'      => 'visualizar planos',
    'breadcrumbs' => [
        [
            'label' => 'Listar planos',
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
                <h4 class="mt-0 header-title">Visualizar planos</h4>
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
                                    <td>Título</td>
                                    <td><?= $Plans->title ?></td>
                                </tr>
                                <tr>                         
                                    <td>Tipo de usuário</td>
                                    <td><?= $Plans->users_type->type ?></td>
                                </tr>                  
                                <tr>
                                    <td>Valor</td>
                                    <td><?= $Plans->value ?></td>
                                </tr>
                                <tr>                         
                                    <td>Raio(M)</td>
                                    <td><?= $Plans->radius == 0? 'Estado':$Plans->radius.' M'?></td>
                                </tr>
                                <tr>                         
                                    <td>Delay</td>
                                    <td><?= $Plans->priority_time->format('H:i:s')?> h</td>
                                </tr>
                                <tr>                         
                                    <td>>Acesso ao site web ?</td>
                                    <td><?= $Plans->is_admin ? 'Sim':'Não'?></td>
                                </tr>
                                <tr>                         
                                    <td>Acesso pelo app ?</td>
                                    <td><?= $Plans->is_mobile ? 'Sim':'Não' ?></td>
                                </tr>
                                <tr>                         
                                    <td>Prioridade</td>
                                    <td><?= $Plans->priority ?></td>
                                </tr>
                                <tr>                         
                                    <td>Descrição</td>
                                    <td><?= $Plans->description ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-0">
                                <?= $this->Html->link('Editar', ['action' => 'edit', $Plans->id], ['escape' => false, 'class' => 'btn btn-primary waves-effect waves-light']) ?>
                                <?= $this->Html->link('Cancelar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary waves-effect m-l-5']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    
