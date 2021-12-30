<?php
$general = [
    'label'       => 'Módulos',
    'label_s'     => 'Visualizar',
    'actual'      => 'visualizar módulo',
    'breadcrumbs' => [
        [
            'label' => 'Listar módulos',
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
                <h4 class="mt-0 header-title">Visualizar módulo</h4>
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
                                    <td><?= $module->name ?></td>
                                </tr>
                                <tr>                         
                                    <td>Ícone</td>
                                    <td><i class="<?= $module->icon ?>"></i></td>
                                </tr>
                                <tr>                         
                                    <td>Empresas que usam</td>
                                    <td> 
                                        <ul class="list-group">
                                            <?php foreach ($module->companies as $c): ?>   
                                                <li><?= $c->name ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                </tr>

                            <td>Ativo?</td>
                            <td><?= $module->active ? 'Sim' : 'Não' ?></td>
                            </tr>
                            <tr>                         
                                <td>Criado em</td>
                                <td><?= $module->created ?></td>
                            </tr>
                            <tr>                         
                                <td>Modificado em</td>
                                <td><?= $module->modified ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-0">
                                <?= $this->Html->link('Editar', ['action' => 'edit', $module->id], ['escape' => false, 'class' => 'btn btn-primary waves-effect waves-light']) ?>
                                <?= $this->Html->link('Cancelar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary waves-effect m-l-5']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>              
