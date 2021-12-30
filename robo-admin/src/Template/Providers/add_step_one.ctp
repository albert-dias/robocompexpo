<?php
$general = [
    'label'       => 'Prestador',
    'label_s'     => 'Adicionar',
    'actual'      => 'adcionar prestador',
    'breadcrumbs' => [
        [
            'label' => 'Listar prestadores',
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
                <h4 class="mt-0 header-title">Cadastrar novo prestador</h4>
                <p class="sub-title">Preencha o formulário e clique em avançar.</p>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div>  
                <?= $this->Form->create($person, ['type' => "file"]) ?>
                
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Nome <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('name', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">CPF <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('cpf', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">RG <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('rg', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Instituição RG <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('institution_rg', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Data de Nascimento <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('date_of_birth', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Email <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('email', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Telefone <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('number_contact', ['label' => false, 'class' => "form-control", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Endereço <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('address', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Número <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('number', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "number"]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Bairro <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('district', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">CEP <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('cep', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "number"]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Cidade <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('city', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Estado <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('state', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Categoria <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?=$this->Form->control('category_id', ['options' => $categories, 'empty' => 'Selecione', 'label'=> false, 'class'=>'form-control',  'required'=>"required",])?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Subcategoria <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?=$this->Form->control('subcategory_id', ['options' => $subcategories, 'empty' => 'Selecione', 'label'=> false, 'class'=>'form-control',  'required'=>"required",])?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Prestador ativo? <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?=$this->Form->control('active', ['options' => ['1' => 'Sim', '0'=> 'Não'], 'empty' => 'Selecione', 'label'=> false, 'class'=>'form-control',  'required'=>"required",])?>
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