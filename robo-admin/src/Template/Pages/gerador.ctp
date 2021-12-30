<style>
    #map{
        width: 100%;
        height: 250px;
    }
    .grandient{
        background: rgb(49,154,114);
        background: linear-gradient(90deg, rgba(49,154,114,1) 8%, rgba(18,119,143,1) 63%);
        opacity: 0.7;
        
    }
    .sw-theme-arrows .toolbar>.btn>.sw-btn-prev{
        background-color: #CFCFCF !important;
    }
    @media only screen and (max-width: 600px) {
        .grandient{
            margin-left: 0rem!important;
            
        }
        #card-1{
            display: contents !important;
        }
        
    }
    .grandient  h2, h3{
        color:white;
    }
    .grandient:hover{
        opacity: 1;
    }
    #step-2 input[type=checkbox] {
    display:none;
    }
    #step-2 input[type=checkbox] + label {
        background-size:cover;
        background-position:center;
        background-repeat: no-repeat;
        height: 68px;
        width: 70px;
        display:inline-block;
        margin-left: 1px;
        margin-right: 18px;
        font-size: 10px;
    }

    input#categorie_id_1 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/papel.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 154px;
        height: 68px;
    }
    input#categorie_id_1:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/papel.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height:  37px;
        height: 70px;
    }

    input#categorie_id_2 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/Icone_Metal.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 154px;
        height: 70px;
    }
    input#categorie_id_2:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/Icone_Metal.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height:  37px;
        height: 70px;
    }
    input#categorie_id_3 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/plastico.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 154px;
        height: 70px;
    }
    input#categorie_id_3:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/plastico.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height:  37px;
        height: 70px;
    }
    input#categorie_id_4 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/pet.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 50px;
        height: 70px;
    }
    input#categorie_id_4:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/pet.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 38px;
        height: 70px;
    }
    input#categorie_id_5 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/vidro.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 154px;
        height: 70px;
    }
    input#categorie_id_5:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/vidro.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height:  37px;
        height: 70px;
    }
    input#categorie_id_6 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/oleo.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 154px;
        height: 70px;
    }
    input#categorie_id_6:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/oleo.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height:  37px;
        height: 70px;
    }
    input#categorie_id_7 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/misturado.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 154px;
        height: 70px;
    }
    input#categorie_id_7:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/misturado.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height:  37px;
        height: 70px;
    }
    input#categorie_id_8 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/metal.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 157px;
        height: 68px;
    }
    input#categorie_id_8:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/metal.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 38px;
        height: 70px;
    }
    input#categorie_id_9 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/eletronicos.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 154px;
        height: 70px;
    }
    input#categorie_id_9:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/eletronicos.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height:  37px;
        height: 70px;
    }
    input#categorie_id_10 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/baterias.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 154px;
        height: 70px;
    }
    input#categorie_id_10:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/baterias.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height:  37px;
        height: 70px;
    }
    input#categorie_id_11 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/moveis.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 154px;
        height: 70px;
    }
    input#categorie_id_11:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/moveis.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height:  37px;
        height: 70px;
    }
    input#categorie_id_12 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/entulho.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 154px;
        height: 70px;
    }
    input#categorie_id_12:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/entulho.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height:  37px;
        height: 70px;
    }
    input#categorie_id_16 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/latinha.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 154px;
        height: 70px;
    }
    input#categorie_id_16:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/latinha.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height:  37px;
        height: 70px;
    }
    input#categorie_id_14 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/vasilhames.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height: 154px;
        height: 70px;
    }
    input#categorie_id_14:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/vasilhames.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        line-height:  37px;
        height: 70px;
    }
    input#categorie_id_15 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/Aluminio_Panela.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        padding-top: 66px;
        height: 70px;
    }
    input#categorie_id_15:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/Aluminio_Panela.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        padding-top: 18px;
        height: 70px;
    }
    input#categorie_id_17 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/cobre.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        padding-top: 66px;
        height: 70px;
    }
    input#categorie_id_17:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/cobre.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        padding-top: 18px;
        height: 70px;
    }
    input#categorie_id_18 + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/stretch.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        padding-top: 66px;
        height: 70px;
    }
    input#categorie_id_18:checked + label{
        background-image: url("<?=$this->request->getAttribute("webroot")?>upload/categories/icones/stretch.png");
        color:black;
        text-align: center;
        top: 10px;
        width: 70px;
        padding-top: 18px;
        height: 70px;
    }
    #step-3 img {
        opacity: 0.7;
    }
    #step-3 img:hover {
        opacity: 1;
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

</style>
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
<?= $this->Html->css('../assets/vendors/leaflet/leaflet.css') ?>
<?=$this->Html->script('../assets/vendors/leaflet/leaflet.js')?>
<script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y&libraries=places">
</script>
<div class="loader bd-highlight align-items-center " style="color:#004938">
<i class="fas fa-recycle fa-spin fa-7x m-auto p-2 bd-highlight"></i>
</div>
<div class="container mt-5">
    
    <div id="smartwizard">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="#step-1">
                    (1) Doação ou Venda ?
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#step-2">
                    (2) Tipo de matérial
                </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-3">
                        (3) Dados para coleta
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-4">
                        (4) Local da coleta
                    </a>
                </li>
            </ul>
            <br><br>
            <?= $this->Form->create(null, ['id' => "formcollection"]) ?>
            <div class="tab-content">
                <div id="step-1" class="tab-pane" role="tabpanel">
                <h4 class="ml-2">O que deseja fazer com o seu Resíduo ?(*)</h4>
                    <div class="row ">
                       <div id="card-1" class="row col-12 col-sm-12 d-flex justify-content-center">
                            <div class="col-xl-4 p-0 col-md-6 col-12 h-100" id="doar" onclick="mudar(this)" >
                                <div class="p-5 border bg-light text-center grandient" style="border-radius:10px;">
                                    <img src="<?=$this->request->getAttribute("webroot")?>/assets/images/doar.png" alt="" srcset="">
                                    <h2 class="typetext" for="i1"> DOAR </h2>
                                    <h3 class="typetext" for="i1"> meu resíduo </h3>
                                </div>
                            </div>
                            <div  class="col-xl-4 p-0 col-md-6  col-12 h-100" id="vender" onclick="mudar(this)">
                                <div class="p-5 ml-4 border bg-light text-center grandient" style="border-radius:10px;">
                                    <img src="<?=$this->request->getAttribute("webroot")?>/assets/images/vender.png" alt="" srcset="">
                                    <h2 class="typetext" for="i2"> VENDER </h2>
                                    <h3 class="typetext" for="i1"> meu resíduo </h3>
                                </div>
                            </div>
                       </div>
                    </div>
                
                </div>
                <div id="step-2" class="tab-pane" role="tabpanel">
                <h4 class="ml-2">Fotos e qual o tipo de resíduo a ser coletado?</h4>
                    <div class="row">
                        
                        <div class="col-sm-12 col-xl-6">
                            <div class="col-12">
                                
                                <input type="file" class="filepond" name="file[]" id="file" data-max-files="5" multiple="multiple" accept="image/png, image/jpeg,image/jpg">
                                <input type="file" name="teste[]" id="teste"  data-max-files="5" multiple="multiple" accept="image/png, image/jpeg,image/jpg" style="display:none;">
                            </div>
                        </div>
                        <div class="col-sm-12 col-xl-6 ">
                            <div class="col-12 mt-3 d-flex justify-content-center">
                                <div class="col-xl-12  col-sm-12">
                                    <div class="col-xl-12 ">
                                        <input type="checkbox" name="categories[]" id="categorie_id_16" value="16">
                                        <label for="categorie_id_16">Latinha</label> 
                                        <input class="order-0" type="checkbox" name="categories[]" id="categorie_id_1" value="2">
                                        <label for="categorie_id_1" title="Papel/Papelão">Papel/Papelão</label>
                                        <input type="checkbox" name="categories[]" id="categorie_id_3" value="4">
                                        <label for="categorie_id_3">Plástico</label> 
                                        <input type="checkbox" name="categories[]" id="categorie_id_4" value="5">
                                        <label for="categorie_id_4"></br>PET</label> 
                                    </div>
                                    <div class="col-xl-12">
                                        <input type="checkbox" name="categories[]" id="categorie_id_2" value="3">
                                        <label for="categorie_id_2">Metais</label> 
                                        <input type="checkbox" name="categories[]" id="categorie_id_5" value="6">
                                        <label for="categorie_id_5">Vidro</label> 
                                        <input type="checkbox" name="categories[]" id="categorie_id_6" value="7">
                                        <label for="categorie_id_6" title="Óleo Vegetal">Óleo Vegetal</label> 
                                        <input type="checkbox" name="categories[]" id="categorie_id_8" value="9">
                                        <label for="categorie_id_8">Ferro/Aço</label> 
                                    </div>
                                    <div class="col-xl-12">
                                        <input type="checkbox" name="categories[]" id="categorie_id_17" value="17">
                                        <label for="categorie_id_17">Cobre</label>
                                        <input type="checkbox" name="categories[]" id="categorie_id_11" value="12">
                                        <label for="categorie_id_11">Móveis</label>
                                        <input type="checkbox" name="categories[]" id="categorie_id_9" value="10">
                                        <label for="categorie_id_9">Eletrônicos</label> 
                                        <input type="checkbox" name="categories[]" id="categorie_id_14" value="14">
                                        <label for="categorie_id_14">Vasilhame</label> 
                                        <input type="checkbox" name="categories[]" id="categorie_id_15" value="15">
                                        <label for="categorie_id_15">Alumínio de Panela </label> 
                                        <input type="checkbox" name="categories[]" id="categorie_id_10" value="11">
                                        <label for="categorie_id_10">Baterias</label> 
                                        <input type="checkbox" name="categories[]" id="categorie_id_7" value="8">
                                        <label for="categorie_id_7">Outros</label> 
                                        <input type="checkbox" name="categories[]" id="categorie_id_18" value="18">
                                        <label for="categorie_id_18">Stretch</label> 
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
        
            
                <div id="step-3" class="tab-pane" role="tabpanel">
                    <h4 class="ml-2 mb-3">Informações da Coleta</h4>
                        <div class="form-group mb-3">
                            
                            <label for="quantidade">Quantidade Total ( volumes )<span class="required">*</span></label>

                            <input type="text" id="quantity_garbage_bags" class="form-control" onkeyup="maxnumber(this)" placeholder="informe a quantidade de volumes da sua coleta">
                        </div>
                        <div class="form-group mb-3">
                            <label for="date_service_ordes">Data da coleta<span class="required">*</span></label>
                            <input min="<?=date('Y-m-d')?>" type="date" name="date_service_ordes" id="date_service_ordes" style="min-width:10%;">
                        </div>
                        <p style="text-align: center;" >Você que quer seu resíduo seja coletado em qual período ?<span class="required">*</span></p>
                        <div class="col-12 mt-3 d-flex justify-content-center">
                            
                            <div class="d-flex flex-column bd-highlight mb-3 mr-3" id="manha" onclick="mudarimg(this)" >
                                <img width="70px" style="border-radius:34px" src="<?=$this->request->getAttribute("webroot")?>/assets/images/manha.png" alt="">
             
                                <span class="text-center">Manhã</span>
                            </div>
                            <div class="d-flex flex-column bd-highlight mb-3 mr-3" id="tarde" onclick="mudarimg(this)" >
                                <img width="70px" style="border-radius:34px" src="<?=$this->request->getAttribute("webroot")?>/assets/images/tarde.png" alt="">
                                <span class="text-center">Tarde</span>
                            </div>
                            <div class="d-flex flex-column bd-highlight mb-3 mr-3" id="noite" onclick="mudarimg(this)" >
                                <img  width="70px" style="border-radius:34px" src="<?=$this->request->getAttribute("webroot")?>/assets/images/noite.png" alt="">
                                <span class="text-center">Noite</span>
                            </div>
                        
                        </div>
                        <div class="mt-3">
                            <div class="form-group">
                                <label for="name-text-input text-wrap">Descreva seu resíduo</label>
                            
                                <?= $this->Form->control('comments', ['label' => false, 'class' => "form-control", 'data-validate-length-range' => "2", 'data-validate-words' => "1",'cols'=>50, 'type' => "textarea"]) ?>
                            </div>
                        </div>
                        
                </div>
                <div id="step-4" class="tab-pane" role="tabpanel">
                    <h4 class="ml-2" style="text-align: center;" >Confirme o local dessa coleta</h4>
                    <div class="form-group mb-3">
                        
                        <label for="pesquisa">Endereço <span class="required">*</span></label>

                        <input id="pesquisa" class="form-control"  type="text" value="<?= $endereco->endereco?>">
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
            </div>
            <?= $this->Form->end() ?>
    </div>
</div>
<div class="modal fade text-left" id="modalsuccess" tabindex="-1" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header  white" style="background: #004938;">
					<h4 style="text-align:center;width: 100%;" class="modal-title" id="modallabel">
                    <?=$this->Html->link('<span class="logo-light">'.$this->Html->image('/assets/images/logo.png', ['alt' => 'logo', 'width="120"']).'</span>', ['controller' => 'Pages'], ['escape' => false, 'class'=>"logo"]) ?>
						<br>
						<span style="font-size:12px;color: white;">
						<?php
                            $empresas = $session['company'];

								echo $empresas['name'];
						?>
						</span>
					</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body">
                    <div class="row mt-5 mb-5">
                        <div class="col-xl-6 d-flex justify-content-center">
                            <img src="<?=$this->request->getAttribute("webroot")?>/assets/images/reziduo.png" alt="">
                        </div>
                        <div class="col-xl-6 text-mensagem">
                            <h5 class="mb-5 text-center">Sua solicitação foi realizada com sucesso</h5>
                            <p class="text-justify">Sua solicitação de coleta pode ser acompanhada tanto pelo app quanto pela web. Não se esqueça de responder os coletores para que possam buscar o seu resíduo.</p>
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
<div class="modal fade text-left" id="modalfail" tabindex="-1" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header  white" style="background: #004938;">
					<h4 style="text-align:center;width: 100%;" class="modal-title" id="modallabel">
                    <?=$this->Html->link('<span class="logo-light">'.$this->Html->image('/assets/images/logo.png', ['alt' => 'logo', 'width="120"']).'</span>', ['controller' => 'Pages'], ['escape' => false, 'class'=>"logo"]) ?>
						<br>
						<span style="font-size:12px;color: white;">
						<?php
                            $empresas = $session['company'];

								echo $empresas['name'];
						?>
						</span>
					</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body">
                    <div class="row mb-5">
                        <div class="col-xl-12 d-flex justify-content-center">
                            <img src="<?=$this->request->getAttribute("webroot")?>/webroot/assets/images/not_found.jpeg" alt="">
                        </div>
                        <div class="col-xl-12 text-mensagem">
                            <h5 class="mb-5 text-center">Ocorreu algum problema</h5>
                            <p class="text-justify text-center">Sua solicitação não foi enviada. Por favor contate o suporte</p>
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
<input id="csrfToken" type="hidden" value="<?= $this->request->getParam('_csrfToken') ?>">

<script>
//var do formulario
var type = null; 
var categorie_id = [];
var period = null;
var countfile = 0;
var pond;
var map;
var markerPoint;
var autocomplete;
var imagens = [];
$(document).ready(function(){
        
        
        // Register the plugin with FilePond
        FilePond.registerPlugin(
             
            FilePondPluginImageCrop,
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginImageResize,
            FilePondPluginImageTransform
        );
        
        // Get a reference to the file input element
        const inputElement = document.querySelector('input[type="file"]');

        // Create the FilePond instance
            pond = FilePond.create(inputElement, {
            acceptedFileTypes:['image/png','image/jpeg','image/jpg'],
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
            },
            allowImageResize:true,
            allowImageTransform:true,
            imageResizeTargetHeight:320,
            imageResizeTargetWidth:320,
            imageCropAspectRatio:1,
            imageTransformOutputQuality:80,
            imageResizeMode:"cover",
            onaddfile:(error,fileItem) =>{
                // console.log(error, fileItem.getMetadata('resize')," ",fileItem.file)
                fileItem.getMetadata('resize')
            },
            onpreparefile:(fileItem, res) =>{
                console.log(res,"files: ",fileItem.file)
                imagens.push({id:fileItem.id,file:res[0].file});
            },
            onremovefile: (error, file) => {
                imagens.splice(imagens.indexOf(file.id), 1);
                countfile--
            },
            imageTransformVariants: {
                thumb_medium_: (transforms) => {
                transforms.resize.size.width = 384;
                return transforms;
                },
                thumb_small_: (transforms) => {
                transforms.resize.size.width = 128;
                return transforms;
                }
            }
        });
        pond.setOptions({
            labelIdle: 'Arraste e solte as fotos ou <span class="filepond--label-action" style="color:blue;"> Clique aqui </span>',
            labelInvalidField: 'Arquivos inválidos',
            labelFileWaitingForSize: 'Calculando o tamanho do arquivo',
            labelFileSizeNotAvailable: 'Tamanho do arquivo indisponível',
            labelFileLoading: 'Carregando',
            labelFileLoadError: 'Erro durante o carregamento',
            labelFileProcessing: 'Enviando'
        })

    // Set allowMultiple property to true
    $('#file').filepond('allowMultiple', true);
    // Listen for addfile event
    $('#file').on('FilePond:addfile', function(e) {
        countfile++;
    });
    $('#file').on('FilePond:warning', async function(e) {

       await Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: "Você só pode colocar até 5 fotos!"
            });
    });


    
    $("#quantity_garbage_bags").mask("00.0")
    $("#cep").mask("99999-999");
    // SmartWizard initialize
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
    // $('#smartwizard').smartWizard("goToStep", 0);
    $('#modalsuccess').on('hidden.bs.modal', function (e) {
     window.open('<?=$this->request->getAttribute('base')?>/collection',"_self")
    })
    $("#smartwizard").on("leaveStep", async function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
        if(nextStepIndex == 2){
                    $(".toolbar-bottom").find('.sw-btn-next').remove()
                    $(".toolbar-bottom").find(".enviar").remove()
                    $(".toolbar-bottom").append('<button onclick="next()" class="btn sw-btn-next" type="button">Próximo</button>')

        }
        if(currentStepIndex == 0 && stepDirection == "forward"){
            if(type !== null){
                return true;
            }else{
                await Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: "Você precisa preencher o que deseja fazer com o seu Resíduo!"
                });
                $('#smartwizard').smartWizard("prev");
                return false; 
            }
            
        }
        if(currentStepIndex == 1 && stepDirection == "forward"){
            if(categorie_id.length != 0 && countfile != 0){
                var options = {
                    toolbarSettings: {
                        showNextButton: false
                    }
                };


                $(".toolbar-bottom").find('.sw-btn-next').remove()
                $(".toolbar-bottom").find(".enviar").remove()
                $(".toolbar-bottom").append('<button onclick="next()" class="btn sw-btn-next" type="button">Próximo</button>')
                
                
                // smartwizard.smartWizard("setOptions", options);
                return true;
            }else{
                await Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: "Você precisa selecionar pelo menos um tipo de material da sua coleta e adicionar pelo menos uma foto!"
                });
                $('#smartwizard').smartWizard("prev");
                return false; 
            }
        } 
        if(currentStepIndex == 2 && stepDirection == "forward"){
            if($("#quantity_garbage_bags").val() != "" && $("#date_service_ordes").val() != "" && period != ""){
                $(".toolbar-bottom").find('.sw-btn-next').remove()
                $(".toolbar-bottom").find(".enviar").remove()
                $(".toolbar-bottom").append('<button type="submit" class="btn enviar">Finalizar</button>')
                return true;
            }else{
                await Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: "Você precisa selecionar pelo menos um tipo de material da sua coleta e adicionar pelo menos uma foto!"
                });
                $('#smartwizard').smartWizard("prev");
                return false; 
            }
        }

        
    });
    $ ( "#smartwizard" ). on ( "stepContent" , function ( e , anchorObject , stepIndex , stepDirection ) { 
        if(stepIndex == 3 && stepDirection == "forward"){
            if(map == undefined){
                leafletjsStart()
                initAutocompleteMaps()
                map.invalidateSize(true)
                
            }
            $(".toolbar-bottom").find('.sw-btn-next').remove()
            $(".toolbar-bottom").find(".enviar").remove()
            $(".toolbar-bottom").append('<button type="submit" class="btn enviar">Finalizar</button>')
        }
        if(stepIndex != 3){
            $(".toolbar-bottom").find('.sw-btn-next').remove()
            $(".toolbar-bottom").find(".enviar").remove()
            $(".toolbar-bottom").append('<button onclick="next()" class="btn sw-btn-next" type="button">Próximo</button>')
        }
    });
    // $ ( "#smartwizard" ). on ( "showStep" , function ( e , anchorObject , stepIndex , stepDirection ) { 
    //     console.log(stepIndex)
    //     if(stepIndex == 3){
    //         $(".toolbar-bottom").find('.sw-btn-next').remove()
    //         $(".toolbar-bottom").find(".enviar").remove()
    //         $(".toolbar-bottom").append('<button type="submit" class="btn enviar">Finalizar</button>')
    //     }
    // });
    $("#step-2 input").click(function (e) {
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
});
$('#formcollection').off().on('submit', function(e){
    e.preventDefault();
    enviar()
});
async function enviar() {
        if(type == null){
            $('#smartwizard').smartWizard("goToStep", 0);
            $("#step-1 h4").append("(Precisamos saber se quer DOAR ou VENDER o seu resíduo)");
            $("#step-1 h4").css("color","red");
            $("#step-1 h4").addClass("animate__animated animate__shakeY")
            $(".toolbar-bottom").find(".enviar").remove()
            $(".toolbar-bottom").find(".sw-btn-next").remove()
            $(".toolbar-bottom").append('<button onclick="next()" class="btn sw-btn-next" type="button">Próximo</button>')
            return false;
        }else if(categorie_id.length == 0){
            
            $('#smartwizard').smartWizard("goToStep", 1);
            $("#step-2 h4").append("(Precisamos saber que tipo de resíduo que você tem!)");
            $("#step-2 h4").css("color","red");
            $("#step-2 h4").addClass("animate__animated animate__shakeY")
            $(".toolbar-bottom").find(".enviar").remove()
            $(".toolbar-bottom").find(".sw-btn-next").remove()
            $(".toolbar-bottom").append('<button onclick="next()" class="btn sw-btn-next" type="button">Próximo</button>')
            return false;
        }else if($("#quantity_garbage_bags").val() == "" || $("#date_service_ordes").val() == "" || period == null){
            $('#smartwizard').smartWizard("goToStep", 2);
            // $("#step-3 h4").html($("#step-3 h4").html()+" (Precisamos dessas informações para que possamos !)");
            $("#step-3 h4").css("color","red");
            $("#step-3 h4").addClass("animate__animated animate__shakeY")
            await Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: "Você preencher todos os campos!"
                });
            return false;
        }else if(true){
                if($("#cep").val() == "" && $("#address").val() == "" && $("#district").val() == "" && $("#city").val() == "" && $("#state").val() == ""){
                    $("#step-4 h4").css("color","red");
                    $("#step-4 h4").addClass("animate__animated animate__shakeY")
                    return false;
                }
        }
            if($("#newendereco").prop("checked")){
                $(".toolbar-bottom").find('.sw-btn-next').remove()
                $(".toolbar-bottom").find(".enviar").remove()
                $(".toolbar-bottom").append('<button onclick="next()" class="btn sw-btn-next" type="button">Próximo</button>')
                if($("#cep").val() == "" || $("#address").val() == "" || $("#district").val() == "" || $("#city").val() == "" || $("#state").val()){
                    $("#step-4 h4").css("color","red");
                    $("#step-4 h4").addClass("animate__animated animate__shakeY")
                    return false;
                }
            }else{
                $(".toolbar-bottom").find(".enviar").remove()
                $(".toolbar-bottom").find('.sw-btn-next').remove()
                $(".toolbar-bottom").append('<button type="submit" class="btn enviar">Finalizar</button>')
            }
        var quantity_garbage_bags = $("#quantity_garbage_bags").val();
        var date_service_ordes = $("#date_service_ordes").val();
        var cep = $("#cep").val();
        var address = $("#address").val();

        var complement = $("#complement").val();
        var district = $("#district").val();
        var city = $("#city").val();
        var state = $("#state").val();
        let fd = new FormData($("#formcollection")[0]);
        const files = imagens
        var latlon = map.getCenter()
        for ( var i in files) {
            var img = new File([files[i].file],files[i].file.name,{type:files[i].file.type});
            fd.append('file[]', img);
        }
        fd.append("quantity_garbage_bags",quantity_garbage_bags)
        fd.append("datetime_collection_ordes",date_service_ordes)
        fd.append("period",period)
        fd.append("type",type)
        fd.append("cep",cep)
        fd.append("address",address)
        fd.append("complement",complement)
        fd.append("district",district)
        fd.append("city",city)
        fd.append("state",state)
        fd.append("latitude",latlon.lat)
        fd.append("longitude",latlon.lng)
        $.ajax({
            url:"<?=$this->request->getAttribute('base')?>/collection/add"
            ,type:"POST"
            ,headers: {
                'X-XSRF-TOKEN': $("#csrfToken").val()
            },beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
                $(".container").toggle("fast");
                $(".loader").fadeIn("slow");
                $(".loader").addClass("d-flex");
            }
            ,data:fd,
            contentType: false,
            processData: false,
            cache: false,
            mimeType: "multipart/form-data",
            dataType: 'json'

        }).done(function(msg){
            $(".container").toggle("fast");
            $(".loader").fadeOut("slow");
            $(".loader").removeClass("d-flex");
            $(".toolbar-bottom").find('.sw-btn-next').remove()
            $(".toolbar-bottom").find(".enviar").remove()
            $(".toolbar-bottom").append('<button onclick="next()" class="btn sw-btn-next" type="button">Próximo</button>')
            resetinputs();
            $('#modalsuccess').modal('toggle')
        }).fail(function(jqXHR, textStatus, msg){
            $(".container").toggle("fast");
            $(".loader").fadeOut("slow");

             Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: msg
                });
        });

        $('#smartwizard').smartWizard("reset");

}

function resetinputs(){
    $("#doar").children().css("opacity",0.7)
    $("#vender").children().css("opacity",0.7)
    $("#vender").children().css("box-shadow","none")
    $("#doar").children().css("box-shadow","none")
    type = null;
    categorie_id.map(function(ca){
        var aux =
        $("#categorie_id_"+(ca-1))
        .parent().parent()
        .find("label[for='categorie_id_"+(ca-1)+"']")
        .attr('material')
        $("#categorie_id_"+(ca-1))
        .parent().parent()
        .find("label[for='categorie_id_"+(ca-1)+"']")
        .html(aux)
        $("#categorie_id_"+(ca-1))
        .parent().parent()
        .find("input[id='categorie_id_"+(ca-1)+"']").prop("checked",false);
    })
    $("#file").val("")
    categorie_id = [];
    $("#manha").children().css("opacity",0.7)
    $("#manha").children().css("box-shadow","none")
    $("#tarde").children().css("opacity",0.7)
    $("#tarde").children().css("box-shadow","none")
    $("#noite").children().css("opacity",0.7)
    $("#noite").children().css("box-shadow","none")
    period = null;
    $("#quantity_garbage_bags").val("");
    $("#date_service_ordes").val("");
    $("#comments").val("");
    $("#newendereco").prop("checked",false);
    $('#smartwizard').smartWizard("stepState", [3], "hide");
    $(".toolbar-bottom").find('.sw-btn-next').remove()
    $(".toolbar-bottom").find(".enviar").remove()
    $(".toolbar-bottom").append('<button onclick="next()" class="btn sw-btn-next" type="button">Próximo</button>')
    $("#cep").val("");
    $("#address").val("");
    $("#number").val("");
    $("#complement").val("");
    $("#district").val("");
    $("#city").val("");
    $("#state").val("");

}



function mudar(who){
    if($(who).attr("id") == "doar"){
        $(who).children().css("opacity",1)
        $(who).children().css("box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $(who).children().css("-webkit-box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $(who).children().css("-moz-box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $("#vender").children().css("opacity",0.7)
        $("#vender").children().css("box-shadow","none")
        type = 0;
        $('#smartwizard').smartWizard("goToStep", 1);
    }else{
        $(who).children().css("opacity",1)
        $(who).children().css("box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $("#doar").children().css("opacity",0.7)
        $("#doar").children().css("box-shadow","none")
        type = 1;
        $('#smartwizard').smartWizard("goToStep", 1);
    }
}

function mudarimg(who) {
    if($(who).attr("id") == "manha"){
        $(who).children().first().css("opacity",1)
        $(who).children().first().css("box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $(who).children().first().css("-webkit-box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $(who).children().first().css("-moz-box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $("#tarde").children().first().css("opacity",0.7)
        $("#tarde").children().first().css("box-shadow","none")
        $("#noite").children().first().css("opacity",0.7)
        $("#noite").children().first().css("box-shadow","none")
        period = "manhã";
    }else if($(who).attr("id") == "tarde"){
        $(who).children().first().css("opacity",1)
        $(who).children().first().css("box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $(who).children().first().css("-webkit-box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $(who).children().first().css("-moz-box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $("#manha").children().first().css("opacity",0.7)
        $("#manha").children().first().css("box-shadow","none")
        $("#noite").children().first().css("opacity",0.7)
        $("#noite").children().first().css("box-shadow","none")
        period = "tarde";
    }else if($(who).attr("id") == "noite"){
        $(who).children().first().css("opacity",1)
        $(who).children().first().css("box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $(who).children().first().css("-webkit-box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $(who).children().first().css("-moz-box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $("#manha").children().first().css("opacity",0.7)
        $("#manha").children().first().css("box-shadow","none")
        $("#tarde").children().first().css("opacity",0.7)
        $("#tarde").children().first().css("box-shadow","none")
        period = "noite";
    }
}
    function leafletjsStart() {
        map = L.map('map').setView([<?=$endereco->latitude?>, <?=$endereco->longitude?>], 18);
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
        markerPoint = L.marker([<?=$endereco->latitude?>, <?=$endereco->longitude?>], {icon: point}).addTo(map);
        map.on('move',function (e) {
            
            var latlon = map.getCenter()
            markerPoint.setLatLng( map.getCenter() )
        });
        map.on('moveend',function (e) {
            console.log(e)
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


    function next(){
        $('#smartwizard').smartWizard("next");
    }


    function maxnumber(who){

        if($(who).val() > 10){
            Swal.fire({
                icon: 'error',
                title: 'CEP não encontrado. Informe outro.'
            });
            $(who).val("")
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