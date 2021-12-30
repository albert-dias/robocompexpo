<?php
$general = [
    'label'       => 'Avaliação',
    'label_s'     => 'Visualizar',
    'actual'      => 'visualizar avaliação',
    'breadcrumbs' => [
        [
            'label' => 'Listar avaliações',
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
                <h4 class="mt-0 header-title">Visualizar avaliação</h4>
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
                                    <td>Ordem de serviço</td>
                                    <td><?= $rating->service_orders_id ?></td>
                                </tr>
                                
                                <tr>                         
                                    <td>Avaliação de </td>
                                    <td><?= $type[$rating->type] ?></td>
                                </tr>
                                <tr>                         
                                    <td>Categoria</td>
                                    <td><?= $rating->service_order->category->name ?></td>
                                </tr>
                                <tr>                         
                                    <td>Subcategoria</td>
                                    <td><?= $rating->service_order->subcategory->name ?></td>
                                </tr>
                                <tr>                         
                                    <td>Descrição do serviço</td>
                                    <td><?= $rating->service_order->description ?></td>
                                </tr>
                                <tr>                         
                                    <td>Data do serviço</td>
                                    <td><?= $rating->service_order->date_service_ordes->format('d-m-Y') ?></td>
                                </tr>
                                <tr>                         
                                    <td>Cliente</td>
                                    <td><?= $rating->client->person->name ?></td>
                                </tr>
                                <tr>                         
                                    <td>Prestador</td>
                                    <td><?= $rating->provider->person->name ?></td>
                                </tr>
                                <tr>                         
                                    <td>Avaliação desse serviço</td>
                                    <td><?= $rating->stars ?> Estrelas</td>
                                </tr>
                                <tr>                         
                                    <td>Data da avaliação</td>
                                    <td><?= $rating->created->format('d-m-Y') ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-0">
                                <?= $this->Html->link('Voltar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary waves-effect m-l-5']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>              
