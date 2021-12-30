<?php
$general = [
    'label'       => 'Planos',
    'label_s'     => 'Criar novo plano',
    'actual'      => 'Listar planos',
    'breadcrumbs' => []
];

echo $this->element('Layout/_content_header', [
    'title'       => $general['label'],
    'small_title' => $general['label_s'],
    'actual'      => $general['actual'],
    'breadcrumbs' => $general['breadcrumbs'],
]);

use Cake\Routing\Router;

$sort      = $this->request->params['paging']['Plans']['sort'];
$direction = $this->request->params['paging']['Plans']['direction'];
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

                <h4 class="mt-0 header-title">Lista de planos</h4>
                <hr>

                <?= $this->Form->create(null, ['type' => 'post']) ?> 
                <div class="row" style="margin-bottom: -25px">

                    <div class="col-sm-6 col-md-4 col-xl-3 m-b-30">
                        <?= $this->Form->control('title', ['label' => false, 'placeholder' => "Título", 'class' => "form-control", 'type' => "text"]) ?>
                    </div>

                    <div class="col-sm-6 col-md-4 col-xl-3 m-b-30">
                        <?= $this->Form->control('UsersTypes', ['options' => $UsersType, 'empty' => 'Tipo de usuário', 'label' => false, 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 m-b-30">
                        <?= $this->Form->button(__('<i class="fa fa-search"></i> Filtrar'), ['class' => "btn btn-info btn-block"]) ?>
                    </div>                    
                </div>
                <hr>
                <?= $this->Form->end(); ?>
                <div class="table-rep-plugin">
                    <div class="table-responsive b-0" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table  table-striped">
                            <thead>
                                <tr>                            
                                    <th data-priority="2"><?= $this->Paginator->sort('id', 'ID ') ?><i class="<?= 'id' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="1"><?= $this->Paginator->sort('title', 'Título ') ?><i class="<?= 'title' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="2"><?= $this->Paginator->sort('UsersTypes.type', 'Tipo de usuário') ?><i class="<?= 'UsersTypes.type' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="2"><?= $this->Paginator->sort('value', 'Valor ') ?><i class="<?= 'value' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="2"><?= $this->Paginator->sort('radius', 'Raio(M) ') ?><i class="<?= 'radius' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="2"><?= $this->Paginator->sort('is_admin', '>Acesso ao site web ? ') ?><i class="<?= 'is_admin' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="2"><?= $this->Paginator->sort('is_mobile', 'Acesso pelo app ? ') ?><i class="<?= 'is_mobile' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="2"><?= $this->Paginator->sort('priority_time', 'Delay ') ?><i class="<?= 'priority_time' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="2"><?= $this->Paginator->sort('priority', 'Prioridade ') ?><i class="<?= 'priority' == $sort ? $direction == 'asc' ? 'fas fa-sort-amount-down' : 'fas fa-sort-amount-up' : 'fa fa-sort' ?>"></i></th>
                                    <th data-priority="2"><?= $this->Paginator->sort('description', 'Descrição ',['lock'=>true]) ?></th>
                                    <th data-priority="1">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($Plans as $Plan): ?>
                                    <tr>
                                        <td><?= $Plan->id ?></td>
                                        <td><?= $Plan->title ?></td>
                                        <td><?= $Plan->users_type->type ?></td>
                                        <td>R$ <?= $Plan->value ?></td>
                                        <td><?= $Plan->radius == 0? 'Estado':$Plan->radius.' M'?> </td>
                                        <td><?= $Plan->is_admin ? 'Sim':'Não'?></td>
                                        <td><?= $Plan->is_mobile ? 'Sim':'Não' ?></td>
                                        <td><?= $Plan->priority_time->format('H:i:s') == '00:00:00'? 'instantâneo':$Plan->priority_time->format('H:i:s').' h'?></td>
                                        <td><?= $Plan->priority ?></td>
                                        <td><?= substr($Plan->description,0,15) ?>...</td>
                                        <td>
                                            <div class="btn-group">
                                                <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), ['action' => 'edit', $Plan->id], ['escape' => false, 'class' => "btn btn-primary btn-sm"]) ?>
                                                <?= $this->Html->link(__('<i class="fas fa-search-plus"></i>'), ['action' => 'view', $Plan->id], ['escape' => false, 'class' => "btn btn-info btn-sm"]) ?>
                                                <?= $this->Html->link('<i class="far fa-trash-alt"></i>', '#', ['data-toggle' => 'modal', 'data-target' => '#ConfirmDelete', 'data-action' => Router::url(array('action' => 'delete', $Plan->id)), 'escape' => false, 'class' => 'btn btn-danger btn-sm'], false) ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>

                        </table>
                    </div>
                </div>
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
                        'Confirmar', array('action' => 'delete'), array('class' => 'btn btn-danger active'), false
                );
                ?>
            </div>
        </div>
    </div>
</div>

