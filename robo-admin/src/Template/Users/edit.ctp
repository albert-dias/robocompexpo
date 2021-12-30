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
                <?= $this->Form->create($People, ['type' => "file"]) ?>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Plano <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('plan_id', ['options' => $plans, 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required","default" => $id_plans]) ?>
                    </div>
                </div>
                <div class="form-group row cpf">
                    <label for="name-text-input" class="col-sm-2 col-form-label">CPF/CNPJ <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('cpf', ['label' => false, 'class' => "form-control",  'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>
                <div class="form-group row name">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Nome <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('name', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row nickname">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Apelido <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('nickname', ['label' => false, "value"=>$user->nickname,'class' => "form-control", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row rg">
                    <label for="name-text-input" class="col-sm-2 col-form-label">RG <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('rg', ['label' => false, 'class' => "form-control", 'type' => "text","maxlength"=>null]) ?>
                    </div>
                </div>

                <div class="form-group row institution_rg">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Instituto rg <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('institution_rg', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row date_of_birth">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Data de aniversário <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" name="date_of_birth" id="date_of_birth" value="<?=$People->date_of_birth == null ?  null : $People->date_of_birth->i18nFormat("yyyy-MM-dd")?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">E-mail <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('email', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "email"]) ?>
                    </div>
                </div>

               

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Número para contato <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('number_contact', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "17", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
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
                    <?= $this->Form->control('state', ['options' => $estadoUF,'label'=>false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required"]) ?>
                    </div>
                </div>
                <div class="form-group row gender">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Sexo <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('gender', ['options' => ['M'=>'Masculino','F'=>'Feminino','N'=>'indefinido'], 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Ativo? <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('active', ['options' => [1=>'Sim',0=>'Não'],'value'=>+$user->active, 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required"]); ?>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Materias <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control" name="categories[]" id="categories" multiple required="required">
                                <?php foreach ($option_mult as $key => $value) { ?>
                               <option value="<?=$key?>" <?= in_array($key,$option_select) ? 'selected' : null ?> ><?=$value?></option>
                           <?php }?>
                        </select>
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
<input id="csrfToken" type="hidden" value="<?= $this->request->getParam('_csrfToken') ?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>

    $(document).ready(function(){
        var check_cpfcnpj = null;
            try {
                $("#cpf").unmask();
            } catch (e) {}
            var tamanho = $("#cpf").val().length;
            console.log(tamanho)
            if(tamanho == 14){
                $("#cpf").mask("99.999.999/9999-99");
            }else{
                $("#cpf").mask("999.999.999-99");
            }
        $("#rg").mask("99.999.999-9");
        $("#cep").mask("99999-999");
        $("#number-contact").mask("(99) 9 9999-9999");
        $("#cpf").keyup(function () {
            try {
                $("#cpf").unmask();
            } catch (e) {}
            var cpfcnpj = null;
            var tamanho = $("#cpf").val().length;
                if(tamanho === 14){
                    console.log("cnpj")
                    $("#cpf").mask("99.999.999/9999-99");
                    //Variavel com valor do campo CPF
                    var cpf= $(this).val();
                    cpfcnpj = cpf;
                    if(validaCpfCnpj($(this).val())){
                    consultarcpfcnpj(cpfcnpj);
                    }else{
                        $("#cpf").val('');
                        Swal.fire({
                            icon: 'error',
                            title: "esse CPF/CNPJ não é valido"
                        });
                    }
                }else if(tamanho === 11){
                    $("#cpf").mask("999.999.999-99");
                    console.log("cpf")
                    //Variavel com valor do campo CPF
                    var cpf= $(this).val();
                    cpfcnpj = cpf;
                    if(validaCpfCnpj($(this).val())){
                    consultarcpfcnpj(cpfcnpj);
                    }else{
                        $("#cpf").val('');
                        Swal.fire({
                            icon: 'error',
                            title: "esse CPF não é valido"
                        });
                    }
                }
            
            
            // ajustando foco
            var elem = this;
            setTimeout(function(){
                // mudo a posição do seletor
                elem.selectionStart = elem.selectionEnd = 10000;
            }, 0);
            // reaplico o valor para mudar o foco
            var currentValue = $(this).val();
            $(this).val('');
            $(this).val(currentValue);
          })
          
    });

    function consultarcpfcnpj(cpfcnpj) {
      var csrfToken = $("#csrfToken").val();
      if(cpfcnpj.length == 14){
        cpfcnpj = cpfcnpj.trim();
        cpfcnpj = cpfcnpj.replace(/\./g, '');
        cpfcnpj = cpfcnpj.replace('-', '');

      }
      if(cpfcnpj.length == 18){
            cpfcnpj = cpfcnpj.trim();
            cpfcnpj = cpfcnpj.replace(/\./g, '');
            cpfcnpj = cpfcnpj.replace('-', '');
            cpfcnpj = cpfcnpj.replace('/', ''); 
      }
            $.ajax({ 
                type: 'POST', 
                url: '<?=$this->request->getAttribute('base')?>/users/consultacpfcnpjBB/',
                headers: { 'X-XSRF-TOKEN' : csrfToken},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                },
                data: {
                    "_csrfToken": getCookie("_ga"),
                    'cpf':cpfcnpj
                },
                async: false,
                dataType: 'json',
                statusCode:{
                  201: async function (data) {
                    await Swal.fire({
                            icon: 'error',
                            title: data.mensagem
                        });
                    location.reload();
                  },
                  500:async function (data) {
                    await Swal.fire({
                            icon: 'error',
                            title: data.responseJSON.mensagem
                        });
                  }
                }
            });
    }

    
    function validaCpfCnpj(val) {
        if (val.length == 14) {
            var cpf = val.trim();
        
            cpf = cpf.replace(/\./g, '');
            cpf = cpf.replace('-', '');
            cpf = cpf.split('');
            
            var v1 = 0;
            var v2 = 0;
            var aux = false;
            
            for (var i = 1; cpf.length > i; i++) {
                if (cpf[i - 1] != cpf[i]) {
                    aux = true;   
                }
            } 
            
            if (aux == false) {
                return false; 
            } 
            
            for (var i = 0, p = 10; (cpf.length - 2) > i; i++, p--) {
                v1 += cpf[i] * p; 
            } 
            
            v1 = ((v1 * 10) % 11);
            
            if (v1 == 10) {
                v1 = 0; 
            }
            
            if (v1 != cpf[9]) {
                return false; 
            } 
            
            for (var i = 0, p = 11; (cpf.length - 1) > i; i++, p--) {
                v2 += cpf[i] * p; 
            } 
            
            v2 = ((v2 * 10) % 11);
            
            if (v2 == 10) {
                v2 = 0; 
            }
            
            if (v2 != cpf[10]) {
                return false; 
            } else {   
                return true; 
            }
        } else if (val.length == 18) {
            var cnpj = val.trim();
            
            cnpj = cnpj.replace(/\./g, '');
            cnpj = cnpj.replace('-', '');
            cnpj = cnpj.replace('/', ''); 
            cnpj = cnpj.split(''); 
            
            var v1 = 0;
            var v2 = 0;
            var aux = false;
            
            for (var i = 1; cnpj.length > i; i++) { 
                if (cnpj[i - 1] != cnpj[i]) {  
                    aux = true;   
                } 
            } 
            
            if (aux == false) {  
                return false; 
            }
            
            for (var i = 0, p1 = 5, p2 = 13; (cnpj.length - 2) > i; i++, p1--, p2--) {
                if (p1 >= 2) {  
                    v1 += cnpj[i] * p1;  
                } else {  
                    v1 += cnpj[i] * p2;  
                } 
            } 
            
            v1 = (v1 % 11);
            
            if (v1 < 2) { 
                v1 = 0; 
            } else { 
                v1 = (11 - v1); 
            } 
            
            if (v1 != cnpj[12]) {  
                return false; 
            } 
            
            for (var i = 0, p1 = 6, p2 = 14; (cnpj.length - 1) > i; i++, p1--, p2--) { 
                if (p1 >= 2) {  
                    v2 += cnpj[i] * p1;  
                } else {   
                    v2 += cnpj[i] * p2; 
                } 
            }
            
            v2 = (v2 % 11); 
            
            if (v2 < 2) {  
                v2 = 0;
            } else { 
                v2 = (11 - v2); 
            } 
            
            if (v2 != cnpj[13]) {   
                return false; 
            } else {  
                return true; 
            }
        } else {
            return false;
        }
    }
    function getEnderecoCorreios1(el) {
        if (el.value.replace('-', '').length >= 8) {
            $('#loading').show();
            $.getJSON(window.location.protocol + "//viacep.com.br/ws/"+el.value.replace('-', '')+"/json/unicode/", function (data) {
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

                $('input[name="city"]').val(data.localidade);
                $('select[name="state"]').val(data.uf);
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
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
            c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
            }
        }
        return "";
    }

</script>