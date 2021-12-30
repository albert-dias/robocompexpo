<?php
$general = [
    'label'       => 'Coletas',
    'label_s'     => 'Adicionar',
    'actual'      => 'adicionar coleta',
    'breadcrumbs' => [
        [
            'label' => 'Listar coletas',
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
                <h4 class="mt-0 header-title">Cadastrar nova coleta</h4>
                <p class="sub-title">Preencha o formulário e clique em salvar.</p>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div>  
                <?= $this->Form->create($collection, ['type' => "file"]) ?>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Adicionar fotos <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="file" name="file[]" multiple="multiple" accept=".jpg,.png" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Tipo de coleta <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('type', ['options' => ['0'=>'Doação','1'=>'Venda'], 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Materias <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control" name="categories[]" id="categories" multiple required="required">
                                <?php foreach ($option_mult as $key => $value) { ?>
                                <option value="<?=$key?>"><?=$value?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Quantidade total (sacos) <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('quantity_garbage_bags', ['label' => false,'onkeyup'=>"maxnumber(this)", 'class' => "form-control",'max'=> 10.0, 'required' => "required", 'type' => "number"]) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Data de coleta <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input min="<?=date('Y-m-d')?>" type="date" name="datetime_collection_ordes" id="date_service_ordes" required="required">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Período da coleta <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control" name="period" id="period" required>
                                    <option value="manhã">Manhã</option>
                                    <option value="tarde">Tarde</option>
                                    <option value="noite">Noite</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">usar um endereço diferente do cadastrado?</label>
                    <div class="col-sm-10">
                        <input type="checkbox" name="endereco_diff" id="endereco-diff">
                    </div>
                </div>
                <div id="new-endereco" style="display:none">
                    <div class="form-group row">
                        <label for="name-text-input" class="col-sm-2 col-form-label">CEP <span class="required">*</span></label>
                        <div class="col-sm-10">
                        <?= $this->Form->control('cep', ['label' => false, 'class' => "form-control",  'onkeyup' => 'getEnderecoCorreios1(this)','data-validate-length-range' => "2", 'data-validate-words' => "1", 'type' => "hidden"]) ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name-text-input" class="col-sm-2 col-form-label">Rua <span class="required">*</span></label>
                        <div class="col-sm-10">
                        <?= $this->Form->control('address', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'type' => "hidden "]) ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name-text-input" class="col-sm-2 col-form-label">Número <span class="required">*</span></label>
                        <div class="col-sm-10">
                        <?= $this->Form->control('number', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'type' => "hidden "]) ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name-text-input" class="col-sm-2 col-form-label">Complemento</label>
                        <div class="col-sm-10">
                        <?= $this->Form->control('complement', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'type' => "hidden"]) ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name-text-input" class="col-sm-2 col-form-label">Bairro <span class="required">*</span></label>
                        <div class="col-sm-10">
                        <?= $this->Form->control('district', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'type' => "hidden"]) ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name-text-input" class="col-sm-2 col-form-label">Cidade <span class="required">*</span></label>
                        <div class="col-sm-10">
                        <?= $this->Form->control('city', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'type' => "hidden"]) ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name-text-input" class="col-sm-2 col-form-label">Estado <span class="required">*</span></label>
                        <div class="col-sm-10">
                        <?= $this->Form->control('state', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'type' => "hidden"]) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                        <label for="name-text-input" class="col-sm-2 col-form-label">incluir comentário <span class="required">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="comments"></textarea>
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

<script>

    $(document).ready(function(){
        $("#cep").mask("99999-999");
        $("#quantity-garbage-bags").mask("00.0")
        $("#endereco-diff").click(function () {
            
            if($("#endereco-diff").is(':checked')){
                var inputs = $("#new-endereco").children();
                for(var item of inputs){
                    $(item).find("input").attr("type","text")
                    $(item).find("input").attr("required","required")
                }

                $("#new-endereco").css("display",'');
            }else{
                var inputs = $("#new-endereco").children();
                for(var item of inputs){
                    $(item).find("input").attr("type","hidden")
                    $(item).find("input").attr("required",null)
                    $(item).find("input").val("")
                }
                $("#new-endereco").css("display",'none');
            }
            $("#complement").attr("required",null)
        })
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
                Swal.fire('CEP não encontrado. Informe outro.')
            });
        }
    }

    function maxnumber(who){
        if($(who).val() > 10){
            alert("Valor máximo de sacolas é 10.0 ")
            $(who).val(" ")
        }
    }
</script>