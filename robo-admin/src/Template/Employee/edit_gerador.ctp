<?php
$general = [
    'label'       => 'Usuário',
    'label_s'     => 'Adicionar',
    'actual'      => 'adicionar usuário',
    'breadcrumbs' => [
        [
            'label' => 'Listar de Usuário',
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
                <?= $this->Form->create($People, ['type' => "file",'onsubmit'=>"btn.disabled = true; return true;"]) ?>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Imagem do perfil <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="file" id="perfil" name="perfil" accept="image/png, image/jpeg">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Nome <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('name', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Apelido <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('nickname', ['value'=>$People->users[0]->nickname,'label' => false, 'autocomplete'=>'off', 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">CPF <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('cpf', ['label' => false, 'class' => "form-control",  'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">RG <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('rg', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Instituto rg <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('institution_rg', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Data de aniversário <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input max="<?=date('Y-m-d', strtotime('-18 years'))?>" type="date" name="date_of_birth" id="date_of_birth" value="<?=$People->date_of_birth->i18nFormat("yyyy-MM-dd")?>" required="required">
                    </div>
                </div>

            

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Número para contato <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('number_contact', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">CEP <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('cep', ['label' => false, 'class' => "form-control",  'onkeyup' => 'getEnderecoCorreios1(this)','data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Rua <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('address', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Número <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('number', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Complemento <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('complement', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Bairro <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('district', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
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
                    <label for="name-text-input" class="col-sm-2 col-form-label">Sexo <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('gender', ['options' => ['M'=>'Masculino','F'=>'Feminino','N'=>'indefinido'], 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>



                <div class="form-group m-b-0">
                    <?= $this->Form->button(__('Salvar'), ['name'=>'btn','class' => "btn btn-primary waves-effect waves-light"]) ?>
                    <?= $this->Html->link('Cancelar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary waves-effect m-l-5']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>         

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>

    $(document).ready(function(){
        $("#cpf").mask("999.999.999-99");
        $("#rg").mask("99.999.999-9");
        $("#cep").mask("99999-999");
        $("#number-contact").mask("(99) 9 9999-9999");
    });

    function getEnderecoCorreios1(el) {
        if (el.value.replace('-', '').length >= 8) {
            $('#loading').show();
            $.getJSON(window.location.protocol + "//api.postmon.com.br/v1/cep/" + el.value.replace('-', ''), function (data) {
                $('#loading').hide();
                if (data.bairro) {
                    $('input[name="district"]').val(data.bairro);
                } else {
                    $('input[name="district"]').val("Sem bairro");
                }
                if (data.logradouro) {
                    $('input[name="address"]').val(data.logradouro);
                } else {
                    $('input[name="address"]').val("Sem logradouro");
                }

                $('input[name="city"]').val(data.cidade);
                $('input[name="state"]').val(data.estado);
            }).fail(function () {
                $('#loading').hide();
                $('input[name="district"]').val('');
                $('input[name="city"]').val('');
                $('input[name="address"]').val('');
                $('input[name="state"]').val('');
                Swal.fire({
                    icon: 'error',
                    title: 'CEP não encontrado. Informe outro.'
                });
            });
        }
    }

</script>