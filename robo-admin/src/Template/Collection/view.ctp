<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script> -->
<?= $this->Html->css('../assets/vendors/leaflet/leaflet.css') ?>
<?=$this->Html->script('../assets/vendors/leaflet/leaflet.js')?>
<style>
    .mt-70 {
        margin-top: 70px
    }

    .mb-70 {
        margin-bottom: 70px
    }

    .card {
        box-shadow: 0 0.46875rem 2.1875rem rgba(4, 9, 20, 0.03), 0 0.9375rem 1.40625rem rgba(4, 9, 20, 0.03), 0 0.25rem 0.53125rem rgba(4, 9, 20, 0.05), 0 0.125rem 0.1875rem rgba(4, 9, 20, 0.03);
        border-width: 0;
        transition: all .2s
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(26, 54, 126, 0.125);
        border-radius: .25rem
    }

    .card-body {
        flex: 1 1 auto;
        padding: 1.25rem
    }

    .vertical-timeline {
        overflow-y: auto;
        overflow-x: hidden;
        width: 100%;
        /* position: absolute; */
        padding: 1.5rem 0 1rem;
        /* height: 469px; */
        height: 29rem;
    }

    .vertical-timeline::before {
        content: '';
        position: absolute;
        /* top: 0; */
        left: 92px;
        height: 100%;
        width: 4px;
        background: #e9ecef;
        border-radius: .25rem;
        max-height: 80%;
    }

    .vertical-timeline-element {
        position: relative;
        margin: 0 0 1rem
    }

    .vertical-timeline--animate .vertical-timeline-element-icon.bounce-in {
        visibility: visible;
        animation: cd-bounce-1 .8s
    }

    .vertical-timeline-element-icon {
        position: absolute;
        top: 0;
        left: 66px;
    }

    .vertical-timeline-element-icon .badge-dot-xl {
        box-shadow: 0 0 0 5px #fff
    }

    .badge-dot-xl {
        width: 18px;
        height: 18px;
        position: relative
    }

    .badge:empty {
        display: none
    }

    .badge-dot-xl::before {
        content: '';
        width: 10px;
        height: 10px;
        border-radius: .25rem;
        position: absolute;
        left: 50%;
        top: 50%;
        margin: -5px 0 0 -5px;
        background: #fff
    }

    .vertical-timeline-element-content {
        position: relative;
        margin-left: 90px;
        font-size: .8rem
    }

    .vertical-timeline-element-content .timeline-title {
        font-size: .8rem;
        text-transform: uppercase;
        margin: 0 0 .5rem;
        padding: 2px 0 0;
        font-weight: bold
    }

    .vertical-timeline-element-content .vertical-timeline-element-date {
        display: block;
        position: absolute;
        left: -91px;;
        top: 0;
        padding-right: 10px;
        text-align: right;
        color: #adb5bd;
        font-size: .7619rem;
        white-space: nowrap
    }

    .vertical-timeline-element-content:after {
        content: "";
        display: table;
        clear: both
    }
</style>
<div class="card">
  <div class="card-header">
    Coleta - <?=$collection_orders->collection_orders_id?>
  </div>
  <div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <h5>Coleta: </h5>
            <span> <label> Tipo:</label>  <?=$collection_orders->type == 0 ? 'Doação': 'Venda'?></span></br>
            <span><label>Status:</label> <?=$collection_orders->status?></span></br>
            <span><label>Quantidade:</label> <?=$collection_orders->quantity_garbage_bags?></span></br>
            <span><label>Categoria:</label> <?=$collection_orders->materiais?></span></br>
            <span><label>Comentário:</label> <span class="text-justify"><?=$collection_orders->comments?></span></span></br>
            <span><label>Período de preferência:</label> <?=$collection_orders->period?></span></br>
            <span><label>Endereço:</label> <?=$collection_orders->address.", ".$collection_orders->number?> - <?=$collection_orders->district?>. <?=$collection_orders->city?>/<?=$collection_orders->state?></span></br>
            
            <div class="col-12">
            <div class="row d-flex justify-content-center  mb-70">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Respostas dos coletores:</h5>
                            <?php if($collection_orders->resposta != null || $collection_orders->status == "cancelada"){?>
                            <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                
                                   <?php $count = 0; foreach ($collection_orders->resposta as $key => $resposta) { $count = $resposta->id ?>
                                   
                                    <div class="vertical-timeline-item vertical-timeline-element"  id="res-<?=$key?>">
                                        <div> <span class="vertical-timeline-element-icon bounce-in"> <i class="badge badge-dot badge-dot-xl <?=$resposta->badge?>"> </i> </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title">Nome: <?= $resposta->name?></h4>
                                                <?php if($resposta->status == "aceita"){?>
                                                <h5 class="timeline-title">Telefone: <a href="tel:<?= $resposta->number_contact?>"><?= $this->TophoneBR($resposta->number_contact)?></a></h5>
                                                <?php }?>
                                                <p>
                                                <?php if($resposta->status == "pendente"){?>
                                                    <?php if($collection_orders->type == 1){?> 
                                                    <div class="row mb-3">
                                                    <?php foreach ($resposta->precos as $precos) {?>
                                                        <div class="col-sm-4 d-flex align-items-center">
                                                            <img height="47px" width="47px" src="<?=$this->request->getAttribute('webroot')?><?=$precos->url_icon?>" alt="">
                                                            &nbsp;<span ><?=$precos->name?><br> <b style="font-weight: 700;"><span class="text-break"> R$</b><?=number_format($precos->Price,2,",",".")?>/Kg</span></span>
                                                        </div>
                                                        <?php }?>
                                                    </div>
                                                        
                                                    <?php }?>
                                                    <?php if($this->request->session()->read('Auth.User.users_types_id') != 1){?>
                                                        <button id="aceito" onclick="aceito(this)" href="#" collection="res-<?=$key?>" respo="<?=$resposta->id?>" class="btn btn-success aceito">
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                        </button>
                                                        <button id="negado" onclick="negado(this)" href="#" collection="res-<?=$key?>" respo="<?=$resposta->id?>" class="btn btn-danger negado">
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        </button>
                                                    <?php }?>
                                                <?php }
                                                      if($resposta->status =="aceita" && $this->request->session()->read('Auth.User.users_types_id') != 1){?>
                                                        <?php if($collection_orders->type == 1){?> 
                                                        <div class="row mb-3">
                                                        <?php foreach ($resposta->precos as $precos) {?>
                                                            <div class="col-sm-4 d-flex align-items-center">
                                                                <img height="47px" width="47px" src="<?=$this->request->getAttribute('webroot')?><?=$precos->url_icon?>" alt="">
                                                                &nbsp;<span ><?=$precos->name?><br> <b style="font-weight: 700;"><span class="text-break"> R$</b><?=number_format($precos->Price,2,",",".")?>/Kg</span></span>
                                                            </div>
                                                            <?php }?>
                                                        </div>
                                                            
                                                        <?php }?>
                                                    <span class="timeline-title">
                                                    <a target="_blank"  href="https://api.whatsapp.com/send?phone=+55<?= $resposta->number_contact?>&text=Ol%C3%A1%2C%20aceitei%20a%20sua%20solicita%C3%A7%C3%A3o%20de%20coleta%20atrav%C3%A9s%20do%20Uzeh" class="btn btn-success">
                                                        <i class="fab fa-whatsapp"></i> Whatsapp
                                                    </a>
                                                    </span>
                                                    <button id="cancelar" onclick="cancelar(this)" href="#" collection="res-<?=$key?>" respo="<?=$resposta->id?>"  class="btn btn-danger cancelar">
                                                        <i class="fas fa-ban"></i> Cancelar
                                                    </button>
                                                    
                                                <?php }
                                                      if($resposta->status =="recebido" && $this->request->session()->read('Auth.User.users_types_id') != 1){?>
                                                    <span class="timeline-title">
                                                    <a target="_blank"  href="https://api.whatsapp.com/send?phone=+55<?= $resposta->number_contact?>" class="btn btn-success">
                                                        <i class="fab fa-whatsapp"></i> Whatsapp
                                                    </a>
                                                    </span>
                                                    
                                                <?php }
                                                      if($resposta->status =="negada" && $this->request->session()->read('Auth.User.users_types_id') != 1){?>
                                                        <abbr title="Essa situação acontece quando você recusa esse coletor ou quando um coletor é aceito ou o coletor recusou a sua solitação"><strong>Coletor recusado</strong></abbr>
                                                <?php }?>
                                                </p> <span class="vertical-timeline-element-date"><?= date("d/m, h:m",strtotime($resposta->created))?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    }
                                }else{?>
                                <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                    <div class="vertical-timeline-item vertical-timeline-element" >
                                        <div> <span class="vertical-timeline-element-icon bounce-in"> <i class="badge badge-dot badge-dot-xl badge badge-info"> </i>  </span>
                                        <div class="vertical-timeline-element-content bounce-in">
                                            
                                            <h4 class="timeline-title">Sem respostas de coletores ou coleta cancelada</h4>
                                            <span class="vertical-timeline-element-date"><?= date("d-m h:m")?></span>
                                            <p></p>
                                            
                                        </div>    
                                    </div>
                                </div>
                               <?php }?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <?php
            $carousel_itens =null;
            $carousel_indicators = null;
            $check = [];
            $check = $collection_orders->images->find('all')->toArray();
            
            if($check){
                foreach ($collection_orders->images as $key => $value) {
                    
                    $url = $value->url;
                    if($url == null){
                        $url = $this->request->getAttribute('webroot')."/webroot/assets/images/sem-fotos.png";
                    }
                    if($key == 0){
                        
                        $carousel_itens .= '<div class="carousel-item active">
                                <img src="'.$value->url.'" class="d-block w-100" alt="..." style="height: 20rem;" >
                                </div>';
                        $carousel_indicators .= '<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>';
                    }else{
                        $carousel_indicators .= '<li data-target="#carouselExampleIndicators" data-slide-to="'.$key.'"></li>';
                        $carousel_itens .= '<div class="carousel-item">
                        <img  src="'.$url.'" class="d-block w-100" alt="..." style="height: 20rem;" onerror="'.$this->request->getAttribute('webroot')."/webroot/assets/images/sem-fotos.png".'">
                        </div>';
                    }
                }
            }else{
                $key = 0;
                $url = $this->request->getAttribute('webroot')."/webroot/assets/images/sem-fotos.png";
                
                $carousel_itens .= '<div class="carousel-item active">
                <img src="'.$url.'" class="d-block w-100" alt="..." style="height: 20rem;" >
                </div>';
                $carousel_indicators .= '<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>';
             }
        ?>
        <div class="col-md-6">
        
            <h5>Localização: </h5>
            <div id="mapcoleta" style="width:100%; height:300px"></div>
					<a target="_blank" class="form-control btn btn-primary"
					href="https://www.google.com/maps?saddr=My+Location&daddr=<?=$collection_orders->address.", ".$collection_orders->number?> - <?=$collection_orders->district?>. <?=$collection_orders->city?>/<?=$collection_orders->state?>">
						<i class="fa fa-map" aria-hidden="true"></i> 
						Abrir rota
					</a>
            <hr>
            <h5>Fotos: </h5>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?=$carousel_indicators?>
                </ol>
                <div class="carousel-inner">
                    <?=$carousel_itens?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            

        </div>
    </div>
  </div>
</div>
<input id="csrfToken" type="hidden" value="<?= $this->request->getParam('_csrfToken') ?>">
<div class="modal fade text-left" id="modalresposta" tabindex="-1" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
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
                
				</div>
				<div class="modal-footer">
					<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">
					<i class="fa fa-times"></i> Sair
					</button>
				</div>
		  </div>
		</div>
	</div>

<script>
$(document).ready(function () {
    
    setInterval(() => {
        getNewResponse()
    }, 10000);

    function iniciar() {
        var initialCoordinates = [<?=$collection_orders->latitude?>, <?=$collection_orders->longitude?>]; // Rio de Janeiro
        var initialZoomLevel = 13;

        // create a map in the "map" div, set the view to a given place and zoom
        var map = L.map('mapcoleta').setView(initialCoordinates, initialZoomLevel);

        // add an OpenStreetMap tile layer
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; Contribuidores do <a href="http://osm.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var muxiCoordinates = [<?=$collection_orders->latitude?>, <?=$collection_orders->longitude?>];
        var muxiMarkerMessage = "Local da coleta!";

        var muxiIconProperties = {
        iconUrl: "<?=$this->request->getAttribute('webroot')?>webroot/img/placeholder.png"
        , iconSize: [50, 59]
        , iconAnchor: [22, 59]
        , popupAnchor: [0, -50]
        };

        var muxiIcon = L.icon(muxiIconProperties);

        L.marker(muxiCoordinates, {icon: muxiIcon})
        .addTo(map)
        .bindPopup(muxiMarkerMessage);
    }
    setTimeout(function() {
        iniciar();
    }, 200);
});

    function aceito(who) {
        var collection = $(who).attr("collection");
        var id_repos = $(who).attr("respo");
        $.ajax({
            url:"<?=$this->request->getAttribute('base')?>/collection/aceito/<?=$collection_orders->collection_orders_id?>",
            type: 'POST', 
                headers: { 'X-XSRF-TOKEN' : $("#csrfToken").val()},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
                },
                data: {
                    "_csrfToken": getCookie("_ga"),
                    "resposta": id_repos
                },
                dataType: 'json',
                success: function(data){   
                    window.location.reload(); 
                }, error: function(xhr,textStatus,error){ 
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.statusText
                    });
                }
        });
    }

    function negado(who) {
        var collection = $(who).attr("collection");
        var id_repos = $(who).attr("respo");
        Swal.fire({
        title: 'Deseja confirma o recebimento da coleta?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: `Negar coletor`,
        cancelButtonColor: '#d33',
        cancelButtonText: `cancelar`,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                url:"<?=$this->request->getAttribute('base')?>/collection/negado/<?=$collection_orders->collection_orders_id?>",
                type: 'POST', 
                    headers: { 'X-XSRF-TOKEN' : $("#csrfToken").val()},
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
                    },
                    data: {
                        "_csrfToken": getCookie("_ga"),
                        "resposta": id_repos
                    },
                    dataType: 'json',
                    success: async function(data){   
                        await Swal.fire(
                        'Coletor negado!',
                        '',
                        'success'
                        )
                        window.location.reload(); 
                    }, error: function(xhr,textStatus,error){ 
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.statusText
                        });
                    }
            });
            }
        });
    }
    function cancelar(who) {
        var collection = $(who).attr("collection");
        var id_repos = $(who).attr("respo");
        if(confirm("Tem certeza que quer cancelar sua coletar?")){
            $.ajax({
                url:"<?=$this->request->getAttribute('base')?>/collection/cancelar/<?=$collection_orders->collection_orders_id?>",
                type: 'POST', 
                    headers: { 'X-XSRF-TOKEN' : $("#csrfToken").val()},
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
                    },
                    data: {
                        "_csrfToken": getCookie("_ga"),
                        "resposta": id_repos
                    },
                    dataType: 'json',
                    success: function(data){   
                        Swal.fire({
                            icon: 'success',
                            title: 'Sua coleta foi cancelada com sucesso!'
                        });
                        window.location.reload(); 
                    }, error: function(xhr,textStatus,error){ 
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.statusText
                        });
                    }
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
   
   function createdCard(response) {
       var paragraph = ` `;
       var headings = ` `;
       var name = null;
       if( response.status == "aceita" && <?=$this->request->session()->read('Auth.User.users_types_id')?> != 1){
                paragraph = `<div class="row mb-3">`
                response.precos.forEach(function (pr) {
                    paragraph += `<div class="col-sm-4 d-flex align-items-center">
                                                            <img height="47px" width="47px" src="<?=$this->request->getAttribute('webroot')?>`+pr.url_icon+`" alt="">
                                                            &nbsp;<span >`+pr.name+`<br> <b style="font-weight: 700;"><span class="text-break"> R$</b>`+number_format(pr.Price,2,",",".")+`/Kg</span></span>
                                                        </div>`
                })
                paragraph += `</div>`
        paragraph += `<span class="timeline-title">
                                                    <a target="_blank"  href="https://api.whatsapp.com/send?phone=+55`+response.number_contact+`" class="btn btn-success">
                                                        <i class="fab fa-whatsapp"></i> Whatsapp
                                                    </a>
                                                    </span> 
                                                    <button id="cancelar" onclick="cancelar(this)" href="#" collection="res-" respo="`+response.id+`"  class="btn btn-danger cancelar">
                                                        <i class="fas fa-ban"></i> Cancelar
                                                    </button>`
        headings = `<h5 class="timeline-title">Telefone: <a href="tel:`+response.number_contact+`">`+mascaraDeTelefone(response.number_contact)+`</a></h5>`
       }
       if(response.status == "recebido" && <?=$this->request->session()->read('Auth.User.users_types_id')?> != 1){
        paragraph = `<span class="timeline-title">
                                                    <a target="_blank"  href="https://api.whatsapp.com/send?phone=+55`+response.number_contact+`" class="btn btn-success">
                                                        <i class="fab fa-whatsapp"></i> Whatsapp
                                                    </a>
                                                    </span>`
        headings = `<h5 class="timeline-title">Telefone: <a href="tel:`+response.number_contact+`">`+mascaraDeTelefone(response.number_contact)+`</a></h5>`
       }
        if(response.status == "pendente"){
            if(response.precos !== undefined){
                paragraph = `<div class="row mb-3">`
                response.precos.forEach(function (pr) {
                    paragraph += `<div class="col-sm-4 d-flex align-items-center">
                                                            <img height="47px" width="47px" src="<?=$this->request->getAttribute('webroot')?>`+pr.url_icon+`" alt="">
                                                            &nbsp;<span >`+pr.name+`<br> <b style="font-weight: 700;"><span class="text-break"> R$</b>`+number_format(pr.Price,2,",",".")+`/Kg</span></span>
                                                        </div>`
                })
                paragraph += `</div>`
                if(<?=$this->request->session()->read('Auth.User.users_types_id')?> != 1){
                    
                    paragraph  += ` <button id="aceito" onclick="aceito(this)" href="#" collection="res-" respo="`+response.id+`" class="btn btn-success aceito">
                                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                            </button>
                                                            <button id="negado" onclick="negado(this)" href="#" collection="res-" respo="`+response.id+`" class="btn btn-danger negado">
                                                                <i class="fa fa-times" aria-hidden="true"></i>
                                                         </button>`
                }                                         
            }else{
                if(<?=$this->request->session()->read('Auth.User.users_types_id')?> != 1){
                paragraph  = ` <button id="aceito" onclick="aceito(this)" href="#" collection="res-" respo="`+response.id+`" class="btn btn-success aceito">
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                        </button>
                                                        <button id="negado" onclick="negado(this)" href="#" collection="res-" respo="`+response.id+`" class="btn btn-danger negado">
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        </button>`
                }
            }
            
            
        }
        if(response.status == "negada" && <?=$this->request->session()->read('Auth.User.users_types_id')?> != 1){
            paragraph = `<abbr title="Essa situação acontece quando você recusa esse coletor ou quando um coletor é aceito ou o coletor recusou a sua solitação"><strong>Coletor recusado</strong></abbr>`

        }
        name = `<h4 class="timeline-title">Nome: `+response.name+`</h4>`
        return [name,headings,paragraph]
   }

   function setCard(card,response) {
        var badge = null;
        if(response.status == "pendente"){
            badge = "badge-warning";
        }
        if(response.status == "negada"){
            badge = "badge-danger";
        }
        if(response.status == "aceita" || response.status == "recebido" ){
            badge = "badge-success";
        }
        
       var data = new Date(response.created);
       
       var cardModel = `<div class="vertical-timeline-item vertical-timeline-element" >
                                        <div> <span class="vertical-timeline-element-icon bounce-in"> <i class="badge badge-dot badge-dot-xl badge `+badge+`"> </i>  </span>
                                        <div class="vertical-timeline-element-content bounce-in">
                                            
                                        `+card[0];
            if(response.status == "aceita"){
                cardModel += ` <h5>`+card[1] +`</h5>`;
            }                               
            cardModel +=  `<span class="vertical-timeline-element-date">`+data.toLocaleDateString("en-GB",{ day: 'numeric',month: 'numeric',hour:"numeric",minute:"numeric"   })+`</span>
                                            <p>`+card[2]+`</p>
                                            
                                        </div>    
                                    </div>` 
        
        $(".vertical-timeline").append(cardModel)
   }
   function getNewResponse() {
       
    $.ajax({
                url:"<?=$this->request->getAttribute('base')?>/collection/view/<?=$collection_orders->collection_orders_id?>",
                type: 'POST', 
                    headers: { 'X-XSRF-TOKEN' : $("#csrfToken").val()},
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
                    },
                    data: {
                        "_csrfToken": getCookie("_ga")
                    },
                    dataType: 'json',
                    success: function(data){   
                       
                       if(data.queryresposta.length != 0){
                        $(".vertical-timeline").html(" ")
                           var card = null;
                        //    last_resp = data.queryresposta[data.queryresposta.length -1]
                           data.queryresposta.map(function (res) {
                                
                                card = createdCard(res)
                                setCard(card,res)
                           });
                           
                           
                       }
                    }, error: function(xhr,textStatus,error){ 
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.statusText
                        });
                    }
            });
   }
   
    function mascaraDeTelefone(v){
        // var mask = "(##) # ####-####";
        // var str = new String(telefone);
        // str = str.replaceAll(" ","")
        // for(var i=0; i < str.length ;i++){
        //     mask[mask.indexOf("#")] = str[i];
        // }
        // return mask;
        var r = v.replace(/\D/g, "");
        r = r.replace(/^0/, "");
        if (r.length > 10) {
            r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
        } else if (r.length > 5) {
            r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
        } else if (r.length > 2) {
            r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
        } else {
            r = r.replace(/^(\d*)/, "($1");
        }
        return r;
    }
    function number_format(number, decimals, dec_point, thousands_sep) {
        var n = number, prec = decimals;
    
        var toFixedFix = function (n,prec) {
            var k = Math.pow(10,prec);        return (Math.round(n*k)/k).toString();
        };
    
        n = !isFinite(+n) ? 0 : +n;
        prec = !isFinite(+prec) ? 0 : Math.abs(prec);    var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
        var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;
    
        var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;
        var abs = toFixedFix(Math.abs(n), prec);
        var _, i;
    
        if (abs >= 1000) {
            _ = abs.split(/\D/);        i = _[0].length % 3 || 3;
    
            _[0] = s.slice(0,i + (n < 0)) +
                _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
            s = _.join(dec);    } else {
            s = s.replace('.', dec);
        }
    
        var decPos = s.indexOf(dec);    if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
            s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
        }
        else if (prec >= 1 && decPos === -1) {
            s += dec+new Array(prec).join(0)+'0';    }
        return s;
    }
</script>