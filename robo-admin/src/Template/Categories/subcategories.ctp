<?php
use Cake\Routing\Router;
$general = [
    'label'       => 'Subcategorias',
    'label_s'     => 'Adicionar',
    'actual'      => 'adcionar subcategoria',
    'breadcrumbs' => [
        [
            'label' => 'Listar categorias',
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
                <h4 class="mt-0 header-title">Cadastrar nova subcategoria</h4>
                <p class="sub-title">Preencha o formulário e clique em salvar.</p>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div>  
                <?= $this->Form->create(null, ['type' => "file"]) ?>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Nome <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('name', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Margem %<span class="required"></span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('margin', ['label' => false, 'class' => "form-control", 'type' => "numeric"]) ?>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Ativo? <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('active', ['options' => ['1' => 'Sim', '0' => 'Não'], 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>
                
                <div class="form-group m-b-0">
                    <?= $this->Form->button(__('Salvar'), ['class' => "btn btn-primary waves-effect waves-light"]) ?>
                    <?= $this->Html->link('Cancelar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary waves-effect m-l-5']) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Subcategorias cadastradas</h4>
                <p class="sub-title">Listagem.</p>
                <div class="table-rep-plugin">
                    <div class="table-responsive b-0" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table  table-striped">
                       <thead>
                        <tr>                            
                            <th data-priority="2">ID</th>
                            <th data-priority="1">Subcategoria</th>
                            <th data-priority="2">Margem %</th>
                            <th data-priority="2">Ativa?</th>
                            <th data-priority="1">Opções</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($subcategories as $subcategory): ?>
                              <tr>
                                  <td><?= $subcategory->id ?></td>
                                  <td><?= $subcategory->name ?></td>
                                  <td><?= $subcategory->margin == NULL ? 'Padrão' : $subcategory->margin ?></td>
                                  <td><?= $subcategory->active ? 'Sim':'Não' ?></td>
                                  <td>
                                      <div class="btn-group">
                                          <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), ['action' => 'subcategories-edit', $category->id,$subcategory->id], ['escape' => false, 'class'=>"btn btn-primary btn-sm" ]) ?>
                                          <?=$this->Html->link('<i class="far fa-trash-alt"></i>',  '#',[ 'data-toggle'=> 'modal', 'data-target' => '#ConfirmDelete', 'data-action'=> Router::url(array('action'=>'deleteSubcategorie',$subcategory->id)), 'escape' => false, 'class'=> 'btn btn-danger btn-sm'], false)?>
                                      </div>
                                  </td>
                              </tr>
                          <?php endforeach; ?>

                      </tbody>

                    </table>
                  </div>
                 </div>
                            </div>
        </div>
    </div>
</div>
volta isso ai que deu pau em tudo
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