<?php
$general = [
    'label'       => 'Ordens de serviços',
    'label_s'     => 'Criar nova ordem de serviço',
    'actual'      => 'Listar ordens de serviço',
    'breadcrumbs' => []
];

echo $this->element('Layout/_content_header', [
    'title'       => $general['label'],
    'small_title' => $general['label_s'],
    'actual'      => $general['actual'],
    'breadcrumbs' => $general['breadcrumbs'],
]);

use Cake\Routing\Router;

$sort      = $this->request->params['paging']['ServiceOrders']['sort'];
$direction = $this->request->params['paging']['ServiceOrders']['direction'];
?>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?= $this->Flash->render() ?>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">Lista de ordens de serviços</h4>
                <hr>
                <?= $this->Form->create(null, ['type' => 'post']) ?>
                <div class="row">

                    <div class="col-sm-6 col-md-4 col-xl-4 m-b-30">
                        <?= $this->Form->control('id', ['label' => false, 'placeholder' => "ID", 'class' => "form-control", 'type' => "text"]) ?>
                    </div>

                    <div class="col-sm-6 col-md-4 col-xl-4 m-b-30">
                        <?= $this->Form->control('status', ['options' => $status, 'empty' => 'Status', 'label' => false, 'class' => 'form-control']) ?>
                    </div>

                    <div class="col-sm-6 col-md-4 col-xl-4 m-b-30">
                        <?= $this->Form->control('pay', ['options' => ['1' => 'Sim', '0' => 'Não'], 'empty' => 'Pago', 'label' => false, 'class' => 'form-control']) ?>
                    </div>

                    <div class="col-sm-6 col-md-4 col-xl-4 m-b-30">
                        <?= $this->Form->control('categories_id', ['options' => $categories, 'empty' => 'Categoria', 'label' => false, 'class' => 'form-control']) ?>
                    </div>

                    <div class="col-sm-6 col-md-4 col-xl-4 m-b-30">
                        <?= $this->Form->control('subcategories_id', ['options' => $subcategories, 'empty' => 'Subcategoria', 'label' => false, 'class' => 'form-control']) ?>
                    </div>

                    <div class="col-sm-6 col-md-4 col-xl-4 m-b-30">
                        <?= $this->Form->control('providers_id', ['options' => $providers, 'empty' => 'Prestador', 'label' => false, 'class' => 'form-control']) ?>
                    </div>

                    <div class="col-sm-6 col-md-4 col-xl-4 m-b-30">
                        <?= $this->Form->control('date_start_search_orders', ['label' => false, 'placeholder' => "Data Inicial", 'class' => "form-control", 'type' => "text",  "autocomplete"=>"off"]) ?>
                    </div>

                    <div class="col-sm-6 col-md-4 col-xl-4 m-b-30">
                        <?= $this->Form->control('date_end_search_orders', ['label' => false, 'placeholder' => "Data Fim", 'class' => "form-control", 'type' => "text",  "autocomplete"=>"off"]) ?>
                    </div>

                    <div class="col-sm-3 col-md-2 col-xl-2 m-b-30">
                        <?= $this->Form->button(__('<i class="fa fa-search"></i> Filtrar'), ['class' => "btn btn-info btn-block"]) ?>
                    </div>

                    <div class="col-sm-3 col-md-2 col-xl-2 m-b-30">
                        <?= $this->Html->link('Limpar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary btn-block']) ?>
                    </div>
                </div>
                <hr>
                <?= $this->Form->end(); ?>
                <div class="table-rep-plugin">
                    <div class="table-responsive b-0" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table  table-striped">
                            <thead>
                                <tr>
                                    <th data-priority="2"><?= $this->Paginator->sort('id', 'ID ') ?><i class="<?= 'id' == $sort ? $direction == 'asc' ?  'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="1">Cliente</th>
                                    <th data-priority="1">Prestador</th>
                                    <th data-priority="1"><?= $this->Paginator->sort('Categories.name', 'Categoria') ?><i class="<?= 'Categories.name' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="1"><?= $this->Paginator->sort('Subcategories.name', 'Subcategoria ') ?><i class="<?= 'Subcategories.name' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="1"><?= $this->Paginator->sort('ServiceOrders.date_service_ordes', 'Data ') ?><i class="<?= 'ServiceOrders.date_service_ordes' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="1"><?= $this->Paginator->sort('ServiceOrders.value_initial', 'Valor ') ?><i class="<?= 'ServiceOrders.value_initial' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="1"><?= $this->Paginator->sort('ServiceOrders.status', 'Status ') ?><i class="<?= 'ServiceOrders.status' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="1"><?= $this->Paginator->sort('ServiceOrders.pay', 'Pago ') ?><i class="<?= 'ServiceOrders.pay' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="1">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($serviceOrders as $serviceOrder) : ?>
                                    <tr>
                                        <td><?= $serviceOrder->id ?></td>
                                        <td><?= $serviceOrder->client->person->name ?></td>
                                        <td><?= $serviceOrder->providers_left ? $serviceOrder->providers_left->person->name : "--" ?></td>
                                        <td><?= $serviceOrder->category->name ?></td>
                                        <td><?= $serviceOrder->subcategory->name ?></td>
                                        <td><?= $serviceOrder->date_service_ordes->format('d-m-Y') ?></td>
                                        <td><?= $serviceOrder->value_initial ?></td>
                                        <td><?= $status[$serviceOrder->status] ?></td>
                                        <td><?= $serviceOrder->pay ? 'Sim' : 'Não' ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), ['action' => 'edit', $serviceOrder->id], ['escape' => false, 'class' => "btn btn-primary btn-sm"]) ?>
                                                <?= $this->Html->link(__('<i class="fas fa-search-plus"></i>'), ['action' => 'view', $serviceOrder->id], ['escape' => false, 'class' => "btn btn-info btn-sm"]) ?>
                                                <?php // $this->Html->link('<i class="far fa-trash-alt"></i>',  '#', ['data-toggle' => 'modal', 'data-target' => '#ConfirmDelete', 'data-action' => Router::url(array('action' => 'delete', $serviceOrder->id)), 'escape' => false, 'class' => 'btn btn-danger btn-sm'], false) ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="box-footer clearfix">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?= $this->Paginator->prev('&laquo;', ['escape' => false]) ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next('&raquo;', ['escape' => false]) ?>
                        </ul>
                    </nav>
                    <p class="pull-left"><?= $this->Paginator->counter() ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bs-example-modal-center" id="ConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" id="myModalLabel">Deletar Registro</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja remover este registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <?php
                echo $this->Form->postLink(
                    'Confirmar',
                    array('action' => 'delete'),
                    array('class' => 'btn btn-danger active'),
                    false
                );
                ?>
            </div>
        </div>
    </div>
</div>