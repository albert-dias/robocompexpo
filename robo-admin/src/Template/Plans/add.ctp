<?php
$general = [
    'label'       => 'Planos',
    'label_s'     => 'Adicionar',
    'actual'      => 'adcionar plano',
    'breadcrumbs' => [
        [
            'label' => 'Listar planos',
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
                <h4 class="mt-0 header-title">Cadastrar novo plano</h4>
                <p class="sub-title">Preencha o formulário e clique em salvar.</p>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div>  
                <?= $this->Form->create($Plans, ['type' => "file"]) ?>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Título <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('title', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Tipo de usuário <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('users_types_id', ['options' => $UsersType, 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Valor(R$) <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('value', ['label' => false, 'class' => "form-control", 'data-validate-minmax' => "0,00", 'required' => "required", 'type' => "number"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Raio(M) <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('radius', ['label' => false, 'class' => "form-control", 'data-validate-minmax' => "0,00", 'required' => "required", 'type' => "number"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Delay <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('priority_time', ['label' => false, 'class' => "form-control", 'data-validate-minmax' => "0,00", 'required' => "required", 'type' => "time"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Acesso site web? <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('is_admin', ['options' => [1=>'Sim',0=>'Não'], 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Acesso pelo app? <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('is_mobile', ['options' => [1=>'Sim',0=>'Não'], 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Descrição <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->textarea('description',['rows' => '10', 'cols' => '100']) ?>
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