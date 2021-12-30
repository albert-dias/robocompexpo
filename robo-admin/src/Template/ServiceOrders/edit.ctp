<?php
$general = [
    'label'       => 'Ordem de serviço',
    'label_s'     => 'Editar',
    'actual'      => 'editar ordem de serviço',
    'breadcrumbs' => [
        [
            'label' => 'Listar páginas',
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
                <h4 class="mt-0 header-title">Editar ordem de serviço</h4>
                <p class="sub-title">Preencha o formulário e clique em salvar.</p>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div>  
                <?= $this->Form->create($serviceOrder, ['type' => "file"]) ?>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Cliente <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('clients_id', ['options' => $clients, 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Prestador <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('providers_id', ['options' => $providers, 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>
               
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Categoria <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('categories_id', ['options' => $categories, 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>
               
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Subcategoria <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('subcategories_id', ['options' => $subcategories, 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Descrição <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('description', ['label' => false, 'class' => "form-control", 'required' => "required", 'type' => "textarea"]) ?>
                    </div>
                </div>
               
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Data do serviço <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('date_service_ordes', ['label' => false, 'placeholder' => "DD-MM-YYYY", 'class' => "form-control", 'type' => "text"]) ?>
                    </div>
                </div>
              
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Valor do serviço <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('value_initial', ['label' => false, 'placeholder' => "R$", 'class' => "form-control", 'type' => "number"]) ?>
                    </div>
                </div>
                               
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Situação <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('status', ['options' => $status, 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">OS Paga <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('pay', ['options' => ['1' => 'Sim', '0'=>'Não'], 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required"]) ?>
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