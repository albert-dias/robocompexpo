<?php

$general = [
    'label'       => 'Empresas',
    'label_s'     => 'Adicionar',
    'actual'      => 'editar empresa',
    'breadcrumbs' => [
        [
            'label' => 'Listar empresas',
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
                <h4 class="mt-0 header-title">Editar empresa</h4>
                <p class="sub-title">Preencha o formulário e clique em salvar.</p>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div>  

                <?= $this->Form->create($company, ['type' => 'file']) ?>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Nome <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('name', ['label' => false, 'class' => "form-control", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="limit-users-text-input" class="col-sm-2 col-form-label">Limite de usuários <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('number_users', ['label' => false, 'class' => "form-control", 'required' => "required", 'type' => "number"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="plan-text-input" class="col-sm-2 col-form-label">Plano<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('resale_plans_id', ['options' => $resalePlans, 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="active-text-input" class="col-sm-2 col-form-label">Ativo<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('active', ['options' => ['1' => 'Sim', '0' => 'Não'], 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="modules-text-input" class="col-sm-2 col-form-label">Módulos<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->input('modules._ids', ['options' => $modules, 'multiple' => 'checkbox', 'label' => false]) ?>
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