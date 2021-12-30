

<style>
    #termopriv{
        -ms-transform: scale(1.4);
        -moz-transform: scale(1.4);
        -webkit-transform: scale(1.4);
        -o-transform: scale(1.4);
        transform: scale(1.4);
        padding: 8px;
    }
    .download-badges{
        list-style: none;
        margin: 0;
        text-align: center;
    }
    .download-badges li {
        
        display: inline-block;
        margin: 0 7.5px;
        padding-left: 0;

    }
    .download-badges a{
        display: block;
        width: 230px;
        height: 71px;
        font: 0/0 a;
        text-shadow: none;
        color: transparent;
        background-repeat: no-repeat;
        background-position: center;
        background-size: 230px 71px;
    }
    .appstore{
        background: url("<?=$this->request->getAttribute("webroot")?>assets/images/appstore.png")
    }
    .googleplay{
        background: url("<?=$this->request->getAttribute("webroot")?>assets/images/google-play.png")
    }
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: rgba(255,255,255,0.7);
        display:none;
    }
    #map{
        width: 100%;
        height: 250px;
    }
    span#categorie_id_1 {
        position: absolute;
        background-color: rgba(0,0,0,0.5);
        color:#fff;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 30px;
        height: 70px;
    }
</style>
<div class="loader bd-highlight align-items-center " style="color:#156875">
<i class="fas fa-recycle fa-spin fa-7x m-auto p-2 bd-highlight"></i>
</div>
<?= $this->Html->css('../assets/vendors/leaflet/leaflet.css') ?>
<?=$this->Html->script('../assets/vendors/leaflet/leaflet.js')?>
<script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y&libraries=places">
</script>
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
  <h2>Cadastro de Cliente</h2>
<div id="smartwizard">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="#step-1">
                    (1) Dados 
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#step-2">
                    (2) Endereço
                </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-3">
                        (3) Dados de acesso
                    </a>
                </li>
            </ul>
            <br><br>
            <?= $this->Form->create($People, ['type' => "file",'id'=>"myForm"]) ?>
            <div class="tab-content">
                <div id="step-1" class="tab-pane" role="tabpanel">
                <h4 class="ml-2 text-center">Quais são os seus dados?</h4>
                        
                        

                        <div class="form-group mb-3 name">
                            <label for="name-text-input" class="col-sm-2 col-form-label">Nome/Razão social <span class="required">*</span></label>
                            
                            <?= $this->Form->control('name', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                            
                        </div>

                        <div class="form-group mb-3 cpf">
                            <label for="name-text-input" class="col-sm-2 col-form-label">CPF/CNPJ <span class="required">*</span></label>
                            
                            <?= $this->Form->control('cpf', ['label' => false, 'class' => "form-control",  'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                            <div class="invalid-feedback" id="cpf-invalid">
                                <span style="font-size: 12px;color: #ff0000;">CPF/CNPJ inválido</span>
                            </div>
                            
                        </div>
                        <div class="form-group mb-3">
                            <label for="name-text-input" class="col-sm-2 col-form-label">Telefone <span class="required">*</span></label>
                            
                            <?= $this->Form->control('number_contact', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "17", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                           
                        </div>

                   
                </div>
                <div id="step-2" class="tab-pane" role="tabpanel">
                    <h4 class="ml-2" style="text-align: center;" >Confirme o seu endereço</h4>
                        <div class="form-group mb-3">
                            
                            <label for="pesquisa">Endereço <span class="required">*</span></label>

                            <input id="pesquisa" class="form-control"  type="text">
                        </div>
                    <div class="col-12">
                            <div id="map"></div>   
                    </div>
                    <div style="display:none;">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label for="name-text-input" class="input-group-text">CEP <span class="required">*</span></label>
                                </div>
                                <input id="cep" name="cep" class="form-control"  type="hidden" >
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label for="name-text-input" class="input-group-text">Rua <span class="required">*</span></label>
                                </div>
                                <input id="address" name="address" class="form-control"  type="hidden" >
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label for="name-text-input" class="input-group-text">Número <span class="required">*</span></label>
                                </div>
                                <input id="number" name="number" class="form-control" type="hidden">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label for="name-text-input" class="input-group-text">Complemento <span class="required">*</span></label>
                                </div>
                                <input id="complement" name="complement" class="form-control" type="hidden">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label for="name-text-input" class="input-group-text">Bairro <span class="required">*</span></label>
                                </div>
                                <input id="district" name="district" class="form-control" type="hidden">
                            </div>
                            
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label for="name-text-input" class="input-group-text">Cidade <span class="required">*</span></label>
                                </div>
                                <input id="city" name="city" class="form-control" type="hidden">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label for="name-text-input" class="input-group-text">Estado <span class="required">*</span></label>
                                </div>
                                <input id="state" name="state" class="form-control" type="hidden">
                            </div>
                    </div>
                </div>
                <div id="step-3" class="tab-pane" role="tabpanel">
                    <h4 class="ml-2 text-center">Preenchar os dados para ter acesso a plataforma</h4>
                    <div class="form-group mb-3">
                        <label for="name-text-input" class="col-sm-2 col-form-label">E-mail <span class="required">*</span></label>
                        <?= $this->Form->control('email', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "email"]) ?>
                    </div>

                    <div class="form-group mb-3">
                        <label for="name-text-input" class="col-sm-2 col-form-label">Senha <span class="required">*</span></label>
                        <?= $this->Form->control('password', ['autocomplete'=>'off','label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "password"]) ?>

                    </div>
                    <div class="form-check">
                        <?= $this->Form->checkbox('termopriv', ['id'=>"termopriv",'label' => false, 'class' => "form-check-input", 'required' => "required","style"=>"width:initial !important"]) ?>
                        <h5 for="termopriv" class="form-check-label">
                            <mark>Concordo com os</mark>
                                <?= $this->Html->link('Termos de Uso e Política de Privacidade', ['action' => 'termopriv'], ['escape' => false,'target'=>"_black"]) ?>
                                <span class="required">*</span>
                        </h5>

                        
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
</div>
<div class="modal fade text-left" id="modalsuccess" tabindex="-1" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header  white" style="background: #156875;">
					<h4 style="text-align:center;width: 100%;" class="modal-title" id="modallabel">
                    <?=$this->Html->link('<span class="logo-light">'.$this->Html->image('/assets/images/logo.png', ['alt' => 'logo', 'width="120"']).'</span>', ['controller' => 'Pages'], ['escape' => false, 'class'=>"logo"]) ?>
						<br>
						
					</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body">
                    <div class="row mt-5 mb-5">
                        <div class="col-xl-6 d-flex justify-content-center">
                            <img src="<?=$this->request->getAttribute("webroot")?>/assets/images/modal_sucesss.png" alt="">
                        </div>
                        <div class="col-xl-6 text-mensagem">
                            <h5 class="mb-5 text-center">Seu cadastro foi realizado com sucesso!</h5>
                            <p class="text-justify">Todos os novos cadastros são verificado para garantir máxima segurança, dentro de minutos você vai receber um e-mail confirmando o seu acesso a plataforma Uzeh.<br> Não se esqueça de baixar o nosso app para ter acesso na palma da sua mão!</p>
                            <ul class="download-badges">
                                <li><a class="appstore" href="#" target="_blank"></a></li>
                                <li><a class="googleplay" href="#" target="_blank"></a></li>
                            </ul>
                            
                            
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">
					<i class="fa fa-times"></i> Sair
					</button>
				</div>
		  </div>
		</div>
	</div>
<!-- <div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Cadastrar novo usuário</h4>
                <p class="sub-title">Preencha o formulário e clique em salvar.</p>

               
                
                
                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Imagem do perfil </label>
                    <div class="col-sm-2">
                        <input type="file" id="perfil" name="perfil" accept="image/png, image/jpeg">
                    </div>
                </div>
                

                <div class="form-group row nickname">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Apelido <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('nickname', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row rg">
                    <label for="name-text-input" class="col-sm-2 col-form-label">RG <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('rg', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row institution_rg">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Instituto rg <span class="required">*</span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('institution_rg', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1", 'required' => "required", 'type' => "text"]) ?>
                    </div>
                </div>

                <div class="form-group row date_of_birth">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Data de aniversário <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" name="date_of_birth" id="date_of_birth" required="required">
                    </div>
                </div>

                

                

                
                <div class="form-group row gender">
                    <label for="name-text-input " class="col-sm-2 col-form-label">Sexo <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('gender', ['options' => ['M'=>'Masculino','F'=>'Feminino','N'=>'indefinido'], 'empty' => 'Selecione', 'label' => false, 'class' => 'form-control', 'required' => "required",]) ?>
                    </div>
                </div>
                
                
                
            </div>
        </div>
    </div>
</div> -->
<input id="csrfToken" type="hidden" value="<?= $this->request->getParam('_csrfToken') ?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
var pond;
var map;
var markerPoint;
var autocomplete;
var categorie_id = [];
    $(document).ready(function(){
       var smartwizard = $('#smartwizard').smartWizard({
            selected: 0,
            theme: 'arrows',
            cycleSteps : true,
            enableURLhash : false,
            lang: { // Language variables for button
                next: 'Próximo',
                previous: 'Anterior',
                finish:'Finalizar'
            },
            autoAdjustHeight : false,
            justified : true,
            enableFinishButton: true,
            keyboardSettings : { 
            keyNavigation : false // Habilita / desabilita a navegação do teclado (as teclas esquerda e direita são usadas se habilitadas)  
            }
        }
        );
        $("#smartwizard").on("leaveStep", async function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
            if(currentStepIndex == 0 && stepDirection == "forward"){
                if($("#name").val() != "" && $("#cpf").val() != "" && $("#number-contact").val() != ""){
                    return true;
                }else{
                    await Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: "Você precisa preencher os dados"
                    });
                    $('#smartwizard').smartWizard("prev");
                    return false; 
                }
                
            }
            if(currentStepIndex == 2 && stepDirection == "forward"){
                if($("#email").val() != "" && $("#password").val() != "" && $("#termopriv").prop("checked") != true){
                    $(".toolbar-bottom").find('.sw-btn-next').remove()
                    $(".toolbar-bottom").find(".enviar").remove()
                    $(".toolbar-bottom").append('<button type="submit" class="btn enviar">Finalizar</button>')
                    return true;
                }else{
                    await Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: "Você precisa preencher os dados de acesso e confirmar os Termos de Uso e Política de Privacidade"
                    });
                    $('#smartwizard').smartWizard("prev");
                    return false; 
                }
            }
        });
        $ ( "#smartwizard" ). on ( "stepContent" , async function ( e , anchorObject , stepIndex , stepDirection ) { 
            if(stepIndex == 1 && stepDirection == "forward"){
                if(map == undefined){
                    await leafletjsStart()
                    initAutocompleteMaps()
                    map.invalidateSize(true)
                }
            }
            if(stepIndex != 2){
                $(".toolbar-bottom").find('.sw-btn-next').remove()
                $(".toolbar-bottom").find(".enviar").remove()
                $(".toolbar-bottom").append('<button onclick="next()" class="btn sw-btn-next" type="button">Próximo</button>')
            }
            if(stepIndex == 2 && stepDirection == "forward"){
                $(".toolbar-bottom").find('.sw-btn-next').remove()
                $(".toolbar-bottom").find(".enviar").remove()
                $(".toolbar-bottom").append('<button type="submit" class="btn enviar">Finalizar</button>')
            }
        });
        
       
         // Register the plugin with FilePond
         FilePond.registerPlugin(
             
             FilePondPluginImageCrop,
             FilePondPluginImagePreview,
             FilePondPluginFileValidateType
         );
         
         // Get a reference to the file input element
         const inputElement = document.querySelector('input[type="file"]');
 
         // Create the FilePond instance
             pond = FilePond.create(inputElement, {
            acceptedFileTypes:['image/png','image/jpeg','image/jpg'],
            imagePreviewHeight: 170,
            imageCropAspectRatio: '1:1',
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 200,
            stylePanelLayout: 'compact circle',
            styleButtonRemoveItemPosition: 'center bottom',

             fileMetadataObject: {
                 'markup': [
                     [
                         'rect', {
                             left: 0,
                             right: 0,
                             bottom: 0,
                             height: '60px',
                             backgroundColor: 'rgba(0,0,0,.5)'
                         },
                     ],
                     [
                         'image', {
                             right: '10px',
                             bottom: '10px',
                             width: '10%px',
                             height: '20%px',
                             fit: 'contain'
                         }
                     ]
                 ]
             }
         });
         pond.setOptions({
             labelIdle: '<span class="filepond--label-action"> Clique aqui </span>',
             labelInvalidField: 'Arquivos inválidos',
             labelFileWaitingForSize: 'Calculando o tamanho do arquivo',
             labelFileSizeNotAvailable: 'Tamanho do arquivo indisponível',
             labelFileLoading: 'Carregando',
             labelFileLoadError: 'Erro durante o carregamento',
             labelFileProcessing: 'Enviando'
         })
 
     // Set allowMultiple property to true
     $('#file').filepond('allowMultiple', false);
        var check_cpfcnpj = true;
        $("#rg").mask("99.999.999-9");
        $("#cep").mask("99999-999");
        $("#number-contact").mask("(99) 9 9999-9999");
        $("#cpf").focusout(function () {
            try {
                $("#cpf").unmask();
            } catch (e) {}
            var cpfcnpj = null;
            var tamanho = $("#cpf").val().length;
            console.log(tamanho)
                if(tamanho === 14){
                    console.log("cnpj")
                    $("#cpf").mask("99.999.999/9999-99");
                    //Variavel com valor do campo CPF
                    var cpf= $(this).val();
                    cpfcnpj = cpf;
                    if(validaCpfCnpj($(this).val())){
                    consultarcpfcnpj(cpfcnpj);
                    $("#cpf-invalid").hide();
                    }else{
                        $("#cpf").val('');
                        $("#cpf-invalid").show();
                    }
                }else if(tamanho === 11){
                    
                    $("#cpf").mask("999.999.999-99");
                    console.log("cpf ",$(this).val())
                    //Variavel com valor do campo CPF
                    var cpf= $(this).val();
                    cpfcnpj = cpf;
                    if(validaCpfCnpj($(this).val())){
                    consultarcpfcnpj(cpfcnpj);
                    $("#cpf-invalid").hide();
                    }else{
                        $("#cpf").val('');
                        $("#cpf-invalid").show();
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
        //   $("#plan-id").on('change',function () {
        //       console.log($("#plan-id").val() == "5")
        //     if($("#plan-id").val() == 5 || $("#plan-id").val() == 4){
        //         check_cpfcnpj = true;
        //         $("#cpf").mask("99.999.999/9999-99");
        //         $("#rg").attr('required',null)
        //         $("#institution-rg").attr('required',null)
        //         $(".rg").hide()
        //         $(".institution_rg").hide()
        //         $(".cpf").find("label").html('CNPJ <span class="required">*</span>')
        //         $(".name").find("label").html('Razão Social <span class="required">*</span>')
        //         $(".nickname").find("label").html('Nome fantasia <span class="required">*</span>')
        //         $(".date_of_birth").html("")
        //         $(".gender").hide()
        //         $("#cpf").attr("disabled",null)
        //     }else if($("#plan-id").val() != null){
        //         check_cpfcnpj = false;
        //         $("#cpf").mask("999.999.999-99");
        //         $("#rg").attr('required',"required")
        //         $(".rg").show()
        //         $(".gender").show()
        //         $(".institution_rg").show()
        //         $(".date_of_birth").html(`<label for="name-text-input" class="col-sm-2 col-form-label">Data de aniversário <span class="required">*</span></label>
        //             <div class="col-sm-10">
        //                 <input type="date" name="date_of_birth" id="date_of_birth" required="required">
        //             </div>`)
        //         $(".cpf").find("label").html('CPF <span class="required">*</span>')
                
        //         $("#institution-rg").attr('required',"required")
        //         $("#cpf").attr("disabled",null)
        //     }

        // })
        
    $("#step-4 input").click(function (e) {
        if($(e.target).val() != ""){
            if(jQuery.inArray($(e.target).val(),categorie_id) == -1){
                categorie_id.push($(e.target).val())
                var aux =  $(e.target)
                .parent().parent()
                .find("label[for='"+$(e.target).attr("id")+"']")
                .html();
                $(e.target)
                .parent().parent()
                .find("label[for='"+$(e.target).attr("id")+"']")
                .attr("material",aux )
                $(e.target)
                .parent().parent()
                .find("label[for='"+$(e.target).attr("id")+"']")
                .html('<span style="color: Tomato;"><i class="fas fa-check fa-5x"></i>'+aux+'</span>' )
            }else{
                var aux =
                $(e.target)
                .parent().parent()
                .find("label[for='"+$(e.target).attr("id")+"']")
                .attr('material')
                $(e.target)
                .parent().parent()
                .find("label[for='"+$(e.target).attr("id")+"']")
                .html(aux)
                categorie_id.splice(categorie_id.indexOf($(e.target).val()),1)
            }
        }
        
    });
    $('#modalsuccess').on('hidden.bs.modal', function (e) {
     window.open('<?=$this->request->getAttribute('base')?>/users/login',"_self")
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
                
                data: {
                    
                    'cpf':cpfcnpj
                },
                async: true,
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
    $('#myForm').off().on('submit', function(e){
        e.preventDefault();
        enviar()
    });
    function enviar() {
        
        if($("#name").val() == "" && $("#cpf").val() == "" && $("#number-contact").val() == ""){
            $('#smartwizard').smartWizard("goToStep", 0);
            $("#step-1 h4").html("Quais são os seus dados? (Precisamos saber os seus dados)");
            $("#step-1 h4").css("color","red");
            $("#step-1 h4").addClass("animate__animated animate__shakeY")
            return null;
        }
        if($("#cep").val() == "" && $("#address").val() == "" && $("#district").val() == "" && $("#city").val() == "" && $("#state").val() == ""){
            $('#smartwizard').smartWizard("goToStep", 1);
            $("#step-2 h4").html("Confirme o seu endereço (Precisamos do seu endereço para fazer as coletas)");
            $("#step-2 h4").css("color","red");
            $("#step-2 h4").addClass("animate__animated animate__shakeY")
            return null;
        }
        if($("#email").val() == "" || $("#password").val() == "" || $("#termopriv").prop("checked") != true){
            $('#smartwizard').smartWizard("goToStep", 2);
            $("#step-3 h4").html("Preenchar os dados para ter acesso a plataforma (Esses dados são fundamentais para ter acesso a plataforma)");
            $("#step-3 h4").css("color","red");
            $("#step-3 h4").addClass("animate__animated animate__shakeY")
            if($("#termopriv").prop("checked") != true){
                Swal.fire({
                    icon: 'error',
                    title: 'Você precisa concordar com os Termos de Uso e Política de Privacidade para acessar a plataforma!',
                });
            }
            return null;
        }
        
        let fd =  new FormData($("#myForm")[0]);
        let latlng = map.getCenter();
        fd.append('lat',latlng.lat);
        fd.append('lng',latlng.lng);
        $.ajax({
            url:"<?=$this->request->getAttribute('base')?>/newuser/cliente"
            ,type:"POST"
            ,beforeSend: function (xhr) {
                $(".container").toggle("fast");
                $(".loader").fadeIn("slow");
                $(".loader").addClass("d-flex");
            }
            ,data:fd,
            dataType:'json',
            contentType: false,
            processData: false,
            cache: false,
            mimeType: "multipart/form-data"

        }).done(function(msg){
            $(".container").toggle("fast");
            $(".loader").fadeOut("slow");
            $(".loader").removeClass("d-flex");
            $(".toolbar-bottom").find('.sw-btn-next').remove()
            $(".toolbar-bottom").find(".enviar").remove()
            $(".toolbar-bottom").append('<button onclick="next()" class="btn sw-btn-next" type="button">Próximo</button>')
            $('#modalsuccess').modal('toggle')
        }).fail(function(jqXHR, textStatus, msg){
            $(".container").toggle("fast");
            $(".loader").fadeOut("slow");
            console.log(jqXHR, " 0 ",textStatus)
             Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: msg
                });
        });
        $(".loader").fadeOut("slow");
        $(".container").toggle("fast");
        $('#smartwizard').smartWizard("reset");
    }
    async function leafletjsStart() {
        
        var localizacaouseratual = {lat:-5.8393267,lon:-35.231889};
        // await $.getJSON("https://ip-api.com/json")
        //     .done(async function (res) {
        //         localizacaouseratual = res
        //         console.log(localizacaouseratual)
        //     })
        //     .fail(function (error) {
        //         localizacaouseratual = {lat:-5.8393267,lon:-35.231889}
                
        //     })
        map = await L.map('map').setView([localizacaouseratual.lat, localizacaouseratual.lon], 18);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        setTimeout(() => {
            map.invalidateSize(true)
        }, 200);
        var point = L.icon({
            iconUrl:"<?=$this->request->getAttribute('webroot')?>/assets/images/placeholder.png",
            iconSize:[70, 70]
        })
        markerPoint = L.marker([localizacaouseratual.lat, localizacaouseratual.lon], {icon: point}).addTo(map);
        map.on('move',function (e) {
            
            var latlon = map.getCenter()
            markerPoint.setLatLng( map.getCenter() )
        });
        map.on('moveend',function (e) {
            var latlon = map.getCenter()
            const request = {
                location: {lat:latlon.lat,lng:latlon.lng}
                
            };
            const address_components = {
                street_number: "short_name",
                route: "long_name",
                locality: "long_name",
                administrative_area_level_1: "short_name",
                administrative_area_level_2:"long_name",
                country: "long_name",
                postal_code: "short_name",
                political:"short_name"
            };
            service = new google.maps.Geocoder({types: ['route'],address_components});
            service.geocode(request, (results, status) => {
                if (status === google.maps.GeocoderStatus.OK) {
                    $("#pesquisa").val(results[0].formatted_address)          
                for (const component of results[0].address_components) {
                    const addressType = component.types[0];
                    if (address_components[addressType]) {
                        const val = component[address_components[addressType]];
                        if(addressType == "route"){
                            $("#address").val(val)
                        }
                        if(addressType == "political"){
                            $("#district").val(val)
                        }
                        if(addressType == "administrative_area_level_2"){
                            $("#city").val(val)
                        }
                        if(addressType == "administrative_area_level_1"){
                            $("#state").val(val)
                        }
                        if(addressType == "postal_code"){
                            $("#cep").val(val)
                        }
                        if(addressType == "street_number"){
                            $("#number").val(val)
                        }
                    }
                }
            }
            });

        });
        map.on('load',function (e) {
            map.invalidateSize(true)
            var latlon = map.getCenter()
            const request = {
                location: {lat:latlon.lat,lng:latlon.lng}
                
            };
            const address_components = {
                street_number: "short_name",
                route: "long_name",
                locality: "long_name",
                administrative_area_level_1: "short_name",
                administrative_area_level_2:"long_name",
                country: "long_name",
                postal_code: "short_name",
                political:"short_name"
            };
            service = new google.maps.Geocoder({types: ['route'],address_components});
            service.geocode(request, (results, status) => {
                if (status === google.maps.GeocoderStatus.OK) {
                        $("#pesquisa").val(results[0].formatted_address)
                        
                        
                for (const component of results[0].address_components) {
                    const addressType = component.types[0];
                    if (address_components[addressType]) {
                        const val = component[address_components[addressType]];
                        if(addressType == "route"){
                            $("#address").val(val)
                        }
                        if(addressType == "political"){
                            $("#district").val(val)
                        }
                        if(addressType == "administrative_area_level_2"){
                            $("#city").val(val)
                        }
                        if(addressType == "administrative_area_level_1"){
                            $("#state").val(val)
                        }
                        if(addressType == "postal_code"){
                            $("#cep").val(val)
                        }
                        if(addressType == "street_number"){
                            $("#number").val(val)
                        }
                    }
                }
            }
            });
        })
        
    }
    function initAutocompleteMaps() {
        var defaultBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(-7.81615, -46.565945),
        new google.maps.LatLng(-5.8455186, -36.7949025));

        var input = document.getElementById('pesquisa');
        var options = {
        bounds: defaultBounds,
        types: ['geocode'],
        };

        autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.setFields(["address_component","geometry"]);
        autocomplete.addListener("place_changed", getEndereco);
    }
    function next(){
        $('#smartwizard').smartWizard("next");
    }

    function getEndereco() {
        const componentForm = {
            street_number: "short_name",
            route: "long_name",
            locality: "long_name",
            administrative_area_level_1: "short_name",
            administrative_area_level_2:"long_name",
            country: "long_name",
            postal_code: "short_name",
            sublocality:"short_name",
            political:"short_name"
        };
        var place = autocomplete.getPlace();
        map.setView([place.geometry.location.lat(),place.geometry.location.lng()],18);
        for (const component of place.address_components) {
            const addressType = component.types[0];

            if (componentForm[addressType]) {
            const val = component[componentForm[addressType]];
                if(addressType == "route"){
                    $("#address").val(val)
                }
                if(addressType == "sublocality"){
                    $("#district").val(val)
                }
                if(addressType == "administrative_area_level_2"){
                    $("#city").val(val)
                }
                if(addressType == "administrative_area_level_1"){
                    $("#state").val(val)
                }
                if(addressType == "postal_code"){
                    $("#cep").val(val)
                }
                if(addressType == "street_number"){
                    $("#number").val(val)
                }
            }
        }
    }
    

</script>