<?php
$general = [
    'label'       => 'Módulos',
    'label_s'     => 'Adicionar',
    'actual'      => 'adcionar módulo',
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
                <h4 class="mt-0 header-title">Cadastrar novo módulo</h4>
                <p class="sub-title">Preencha o formulário e clique em salvar.</p>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div>  
                <?= $this->Form->create($module, ['type' => "file"]) ?>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Nome <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('name', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Ativo? <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('active', ['options' => ['1' => 'Sim', '0' => 'Não'], 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Ícone <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('icon', ['label' => false, 'class' => "form-control", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Planos <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('ModulesHasCompany.plans_id', ['options' => $module_plans, 'multiple' => 'checkbox',  'label' => false]) ?>
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