<?php
$general = [
    'label'       => 'Usuários',
    'label_s'     => 'Adicionar',
    'actual'      => 'adcionar usuário',
    'breadcrumbs' => [
        [
            'label' => 'Listar usuários',
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
                <h4 class="mt-0 header-title">Cadastrar novo usuário</h4>
                <p class="sub-title">Preencha o formulário e clique em salvar.</p>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div>  
                <?= $this->Form->create($user, ['type' => "file"]) ?>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Nome <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('name', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "6", 'data-validate-words' => "2", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Email (login) <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('email', ['label' => false, 'class' => "form-control", 'required' => "required", 'type' => "email"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Empresa<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('company_id', ['options' => $companies, 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Permissão <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('users_types_id', ['options' => $usersTypes, 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Senha <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('password', ['label' => false, 'class' => "form-control", 'data-validate-length' => "1,2,3,4,5", 'required' => "required", 'type' => "password"]) ?>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Repetir senha <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('password2', ['label' => false, 'class' => "form-control", 'required' => "required", 'type' => "password"]) ?>
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