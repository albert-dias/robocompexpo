<?php
$general = [
    'label'       => 'Avaliações',
    'label_s'     => 'Lista de avaliações',
    'actual'      => 'Lista de avaliações',
    'breadcrumbs' => [
        [
            'label' => 'Lista de avaliações',
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

use Cake\Routing\Router;

$sort      = $this->request->params['paging']['Ratings']['sort'];
$direction = $this->request->params['paging']['Ratings']['direction'];

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

                <h4 class="mt-0 header-title">Lista de avaliações</h4>
                <hr>
                <?= $this->Form->create(null, ['type' => 'post']) ?> 
                <div class="row" style="margin-bottom: -25px">
                        
                      <div class="col-sm-6 col-md-4 col-xl-3 m-b-30">
                           <?= $this->Form->control('id', ['label'=>false, 'placeholder' =>"ID", 'class'=>"form-control", 'type'=>"text"])?>
                      </div>

                      <div class="col-sm-6 col-md-4 col-xl-3 m-b-30">
                        <?= $this->Form->control('stars', ['options' => ['5' => '5', '4' => '4', '3'=>'3', '2'=> '2', '1'=>'1'], 'label'=>false, 'placeholder' =>"Estrelas", 'class'=>"form-control", 'type'=>"text"])?>
                      </div>
                      
                      <div class="col-sm-6 col-md-4 col-xl-3 m-b-30">
                        <?=$this->Form->control('type', ['options' => ['provider' => 'Prestador', 'client' => 'Cliente'], 'empty' => 'Tipo', 'label'=> false, 'class'=>'form-control'])?>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl-3 m-b-30">
                        <?= $this->Form->button(__('<i class="fa fa-search"></i> Filtrar'), ['class'=>"btn btn-info btn-block"]) ?>
                      </div>
                    
                    </div>
                    <hr>
                <?= $this->Form->end();?>
                <div class="table-rep-plugin">
                    <div class="table-responsive b-0" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table  table-striped">
                       <thead>
                        <tr>                            
                            <th data-priority="2"><?= $this->Paginator->sort('id', 'ID ') ?><i class="<?= 'id' == $sort ? $direction == 'asc' ?  'fas fa-sort-amount-down' : 'fas fa-sort-amount-up':'fa fa-sort'?>"></i></th>
                            <th data-priority="1">OS</th>
                            <th data-priority="1">Cliente</th>
                            <th data-priority="1">Prestador</th>
                            <th data-priority="1">Avaliação</th>
                            <th data-priority="1">Avaliado</th>
                            <th data-priority="1">Data</th>
                            <th data-priority="1">Opções</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($ratings as $rating): ?>
                              <tr>
                                  <td><?= $rating->id ?></td>
                                  <td><?= $rating->service_orders_id ?></td>
                                  <td><?= $rating->client->person->name ?></td>
                                  <td><?= $rating->provider ? $rating->provider->person->name : '-' ?></td>
                                  <td><?= $rating->stars ?></td>
                                  <td><?= $types[$rating->type] ?></td>
                                  <td><?= $rating->created->format('d-m-Y') ?></td>
                                  <td>
                                      <div class="btn-group">
                                          <?= $this->Html->link(__('<i class="fas fa-search-plus"></i>'), ['action' => 'view', $rating->id], ['escape' => false, 'class'=>"btn btn-info btn-sm" ]) ?>
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
  