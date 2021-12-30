<?php
$general = [
    'label'       => 'Ordem de serviço',
    'label_s'     => 'Visualizar',
    'actual'      => 'visualizar OS',
    'breadcrumbs' => [
        [
            'label' => 'Listar ordens de serviços',
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
                <h4 class="mt-0 header-title">Visualizar OS</h4>
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
                                    <td>Cliente</td>
                                    <td><?= $serviceOrder->client->person->name ?></td>
                                </tr>
                                <tr>                         
                                    <td>Prestador</td>
                                    <td><?= $serviceOrder->provider ? $serviceOrder->provider->person->name : '--'?></td>
                                </tr>                  
                                <tr>
                                    <td>Categoria</td>
                                    <td><?= $serviceOrder->category->name ?></td>
                                </tr>
                                <tr>
                                    <td>Subcategoria</td>
                                    <td><?= $serviceOrder->subcategory->name ?></td>
                                </tr>
                                <tr>
                                    <td>Data da ordem de serviço</td>
                                    <td><?= $serviceOrder->date_service_ordes->format('d-m-Y') ?></td>
                                </tr>
                                <tr>
                                    <td>Descrição</td>
                                    <td><?= $serviceOrder->description ?></td>
                                </tr>
                                <tr>
                                    <td>Valor inicial</td>
                                    <td><?= $serviceOrder->value_initial ?></td>
                                </tr>
                                <tr>
                                    <td>Situação</td>
                                    <td><?= $status[$serviceOrder->status] ?></td>
                                </tr>
                                <tr>
                                    <td>Pago?</td>
                                    <td><?= $serviceOrder->pay ? "Sim" : "Não" ?></td>
                                </tr>
                                <tr>                         
                                    <td>Imagens</td>
                                    <td> 
                                        <ul class="list-group">
                                            <?php foreach ($serviceOrder->service_orders_images as $c): ?>   
                                                <li><?=  $c->path ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>                         
                                    <td>Criado em</td>
                                    <td><?= $serviceOrder->created->format('d-m-Y') ?></td>
                                </tr>
                                <tr>                         
                                    <td>Modificado em</td>
                                    <td><?= $serviceOrder->modified->format('d-m-Y') ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="ln_solid"></div>
                        <div class="col-12">
                            <h5 class="m-t-20 m-b-30">Imagens</h5>
                            <div class="card-deck-wrapper">
                                <div class="card-deck">
                                    <?php foreach ($images as $value) : ?>
                                        <div class="card m-b-30">
                                            <img class="card-img-top img-fluid" src="<?= $value->url ?>" alt="OS">
                                            <div class="card-body">
                                                <h4 class="card-title font-16 mt-0">OS</h4>
                                                <p class="card-text">
                                                    <small class="text-muted"><?= $value->created ?></small>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        </br>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-0">
                                <?= $this->Html->link('Editar', ['action' => 'edit', $serviceOrder->id], ['escape' => false, 'class' => 'btn btn-primary waves-effect waves-light']) ?>
                                <?= $this->Html->link('Cancelar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary waves-effect m-l-5']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    
