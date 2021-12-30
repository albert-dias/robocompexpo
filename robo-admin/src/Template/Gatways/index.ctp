<?php
$general = [
    'label'       => 'Gatways de pagamentos',
    'label_s'     => 'Cadastrar novo gatway de pagamento',
    'actual'      => 'Listar gatways',
    'breadcrumbs' => []
];

echo $this->element('Layout/_content_header', [
    'title'       => $general['label'],
    'small_title' => $general['label_s'],
    'actual'      => $general['actual'],
    'breadcrumbs' => $general['breadcrumbs'],
]);

use Cake\Routing\Router;

$sort      = $this->request->params['paging']['Gatways']['sort'];
$direction = $this->request->params['paging']['Gatways']['direction'];
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

                <h4 class="mt-0 header-title">Lista de gatways de pagamentos</h4>
                <hr>
                <?= $this->Form->create(null, ['type' => 'post']) ?> 
                <div class="row" style="margin-bottom: -25px">
                        
                      <div class="col-sm-6 col-md-4 col-xl-3 m-b-30">
                           <?= $this->Form->control('id', ['label'=>false, 'placeholder' =>"ID", 'class'=>"form-control", 'type'=>"text"])?>
                      </div>

                      <div class="col-sm-6 col-md-4 col-xl-3 m-b-30">
                        <?= $this->Form->control('name', ['label'=>false, 'placeholder' =>"Gatway", 'class'=>"form-control", 'type'=>"text"])?>
                      </div>
                      
                      <div class="col-sm-6 col-md-4 col-xl-3 m-b-30">
                        <?=$this->Form->control('active', ['options' => ['1' => 'Sim', '0' => 'Não'], 'empty' => 'Ativo?', 'label'=> false, 'class'=>'form-control'])?>
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
                            <th data-priority="1"><?= $this->Paginator->sort('name', 'Gatway ') ?><i class="<?= 'name' == $sort ? $direction == 'asc' ?  'fas fa-sort-amount-down' : 'fas fa-sort-amount-up':'fa fa-sort'?>"></i></th>
                            <th data-priority="2"><?= $this->Paginator->sort('active', 'Ativo ') ?><i class="<?= 'active' == $sort ? $direction == 'asc' ?  'fas fa-sort-amount-down' : 'fas fa-sort-amount-up':'fa fa-sort'?>"></i></th>
                            <th data-priority="1">Opções</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($gatways as $gatway): ?>
                              <tr>
                                  <td><?= $gatway->id ?></td>
                                  <td><?= $gatway->name ?></td>
                                  <td><?= $gatway->active ? 'Sim':'Não' ?></td>
                                  <td>
                                      <div class="btn-group">
                                          <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), ['action' => 'edit', $gatway->id], ['escape' => false, 'class'=>"btn btn-primary btn-sm" ]) ?>
                                          <?= $this->Html->link(__('<i class="fas fa-search-plus"></i>'), ['action' => 'view', $gatway->id], ['escape' => false, 'class'=>"btn btn-info btn-sm" ]) ?>
                                          <?=$this->Html->link('<i class="far fa-trash-alt"></i>',  '#',[ 'data-toggle'=> 'modal', 'data-target' => '#ConfirmDelete', 'data-action'=> Router::url(array('action'=>'delete',$gatway->id)), 'escape' => false, 'class'=> 'btn btn-danger btn-sm'], false)?>
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
  