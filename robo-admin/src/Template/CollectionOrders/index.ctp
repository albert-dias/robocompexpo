
<style>
    .btn-warning{
        background-color:#d85f03
    }
    .border{
        border: 1px solid #dcdcdc !important;
        box-shadow: 6px 5px 4px rgba(0, 0, 0, 0.05);
        
    }
</style>
<div class="card">
    <div class="card-header">
        <h3><?= __('Coletas') ?></h3>
       
    </div>
    <div class="card-body">

            <div class="row">
                <div class="col-xl-3 col-sm-2 col-md-4 pt-3" style="box-shadow: 7px 0px 26px -4px #BEBEBE;">
                    <div class="nav flex-column nav-pills" id="myTab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active border border-left-0 " id="new-collection" data-toggle="pill" href="#new-collection-tab" role="tab" aria-controls="v-pills-home" aria-selected="true" list="pendente"><i class="fa fa-circle" style="color:blue" aria-hidden="true"></i> Novas Coletas </a><br>
                    <a class="nav-link border border-left-0" id="collection-solicitation" data-toggle="pill" href="#collection-solicitation-tab" role="tab" aria-controls="v-pills-settings" aria-selected="false" list="pendente-order"><i class="fa fa-circle" style="color:yellow" aria-hidden="true"></i> Coletas aguardando ok do gerador </a><br>
                    <a class="nav-link border border-left-0 " id="collection-in-progress" data-toggle="pill" href="#collection-in-progress-tab" role="tab" aria-controls="v-pills-profile" aria-selected="false" list="agendada"><i class="fa fa-circle" style="color:orange" aria-hidden="true"></i> Coletas em andamento </a><br>
                    <a class="nav-link border border-left-0 " id="finished-collection" data-toggle="pill" href="#finished-collection-tab" role="tab" aria-controls="v-pills-messages" aria-selected="false" list="finalizada"><i class="fa fa-circle" style="color:green" aria-hidden="true"></i> Coletas finalizadas </a><br>
                    <a class="nav-link border border-left-0" id="collection-canceled" data-toggle="pill" href="#collection-canceled-tab" role="tab" aria-controls="v-pills-settings" aria-selected="false" list="negada"><i class="fa fa-circle" style="color:red" aria-hidden="true"></i> Coletas rejeitadas por você </a><br>
                    <a class="nav-link border border-left-0 " id="collection-denied" data-toggle="pill" href="#collection-denied-tab" role="tab" aria-controls="v-pills-settings" aria-selected="false" list="negada-order"><i class="fa fa-circle" style="color:red" aria-hidden="true"></i>  Coletas rejeitada pelo gerador </a>
                    </div>
                </div>
                <div class="col-sm-7 col-xl-9 col-md-8">
                    <div class="tab-content" id="v-pills-tabContent" >
                        <div style="transform: scale(0.9);transform-origin: 50% 0% 100px;" class="tab-pane fade show active" id="new-collection-tab" role="tabpanel" aria-labelledby="v-pills-home-tab"></div>
                        <div style="transform: scale(0.9);transform-origin: 50% 0% 100px;" class="tab-pane fade" id="collection-denied-tab" role="tabpanel" aria-labelledby="v-pills-settings-tab">Você não tem dados dessas coleta.</div>
                        <div style="transform: scale(0.9);transform-origin: 50% 0% 100px;" class="tab-pane fade" id="collection-in-progress-tab" role="tabpanel" aria-labelledby="v-pills-profile-tab">Você não tem dados dessas coleta.</div>
                        <div style="transform: scale(0.9);transform-origin: 50% 0% 100px;" class="tab-pane fade" id="finished-collection-tab" role="tabpanel" aria-labelledby="v-pills-messages-tab">Você não tem dados dessas coleta.</div>
                        <div style="transform: scale(0.9);transform-origin: 50% 0% 100px;" class="tab-pane fade" id="collection-canceled-tab" role="tabpanel" aria-labelledby="v-pills-settings-tab">Você não tem dados dessas coleta.</div>
                        <div style="transform: scale(0.9);transform-origin: 50% 0% 100px;" class="tab-pane fade" id="collection-solicitation-tab" role="tabpanel" aria-labelledby="v-pills-settings-tab">Você não tem dados dessas coleta.</div>
                    </div>
                </div>
            </div>
    </div>
</div>
<input id="csrfToken" type="hidden" value="<?= $this->request->getParam('_csrfToken') ?>">
<div class="modal fade text-left" id="modalcollection" tabindex="-1" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header  white" style="background: #009975;">
					<h4 style="text-align:center;width: 100%;" class="modal-title" id="modallabel">
						<?=$this->Html->link(
						$this->Html->image('/assets/images/logo2.png', [
							'class'=>'brand-logo',
							'width="100"'
						]),
						"#",
						['class'=> 'navbar-brand','escape'=>false])?>
						<br>
						
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
// <li data-target="#fotos" data-slide-to="0" class="active"></li>
//                                             <li data-target="#fotos" data-slide-to="1"></li>
//                                             <li data-target="#fotos" data-slide-to="2"></li>
let cont = 0;
let person = <?=json_encode($person)?>;
function addCard(index,button,id_resp = null) {
    cont++;
    var idcard = "card"+cont;
    var idcarousel = "carousel"+cont;
    var aceita = "";
    var negada = "";
    var recebido = "";
    var button_datalhes = `<button class="modal-click btn btn-warning mr-3" onclick="modalCollection(this)" data-target="#modalcollection" target="_BLANK" src="<?=$this->request->getAttribute('base')?>/collection-orders/view/`+index+`">Detalhes da Coleta</button>`;
    if(button[0] === "aceita"){
        aceita = `<button id="aceito" onclick="aceito(this)" collection="`+index+`" collectionresponde="`+id_resp+`" card="#`+idcard+`" class="btn btn-success aceito"><i class="fa fa-check" aria-hidden="true"></i></button>`
    }
    if(button[1] == "negada"){
        negada = `<button id="negado" onclick="negado(this)" collection="`+index+`" collectionresponde="`+id_resp+`" card="#`+idcard+`" class="btn btn-danger negado"><i class="fa fa-times" aria-hidden="true"></i></button>`;
    }
    if(button[1] == "finalizar"){
        recebido = `<button id="finalizar" onclick="finalizar(this)" collection="`+index+`" collectionresponde="`+id_resp+`" card="#`+idcard+`" class="btn btn-success finalizar">Coleta recebida</button>`;
        
    }
    if(button[1] == "info"){
        button_datalhes = `<button class="modal-click btn btn-danger mr-3" onclick="modalCollection(this)" data-target="#modalcollection" target="_BLANK" src="<?=$this->request->getAttribute('base')?>/collection-orders/view/`+index+`">informar pesagem da Coleta</button>`
    }
    var transform
    var card = `<div id="`+idcard+`" class="card mb-0 mr-8 card-data border border-bottom" style="    max-width: 100%;/* height: 10rem; */">
                            <div class="row no-gutters">
                                <div class="col-md-4 col-sm-3">
                                <div id="`+idcarousel+`" class="carousel slide" data-ride="carousel" data-interval="0">
                                        <ol id="itens-fotos" class="carousel-indicators">
                                            
                                        </ol>
                                        <div id="fotos`+cont+`" class="carousel-inner" data-ride="carousel" >
                        
                                        </div>
                                        <a class="carousel-control-prev" onclick="previous(`+idcarousel+`)" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" onclick="next(`+idcarousel+`)"  role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="card-body">
                                        `+button_datalhes+``+recebido+`
                                        <p  class="card-text"><small id="title-time" class="text-muted">Carregando...</small></p>
                                        <h5 id="title-card"class="card-title">Carregando...</h5>
                                        <p id="title-data" class="card-text">Carregando...</p>
                                        <label id="image-categorie">Carregando...</label>
                                        <p  class="card-text"><small id="title-distance" class="text-muted">Carregando...</small></p>
                                        `+aceita+``+negada+`
                                        
                                        <p  class="card-text"><small id="title-info" class="text-muted">Carregando...</small></p>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 text-center text-xl-left d-flex align-items-end  flex-column bd-highlight mb-3">
                                <h4 class="font-weight-bold foo justify-content-end"></h4>
                                
                                </div>
                                
                        </div>
                        </div>
                        `;
    return card;
}
 function removeCard(who) {
     $(who).remove();
 }
function addImagem(index,src) {
    var idimagem = "#foto"+index;
    var imagem = `<div id="carousel-item`+index+`" class="carousel-item">
                    <img id="`+idimagem+`" src="`+src+`" class="d-block w-100" style="height: 200px;" alt="..." onerror="<?=$this->request->getAttribute('webroot')?>webroot/assets/images/sem-fotos.png">
                  </div>`
    return imagem;
}
function addItens(index) {
    var idimagem = "#foto"+index;
    var item = `<li id="item`+index+`" data-target="#fotos" data-slide-to="`+index+`"></li>`;
    return item;
}
    let ativo = {list: "pendente",id:"#new-collection-tab"};
    let last_id = null;
    $( document ).ready(function() {
        
        setCard(jsonAjax("pendente"),"#new-collection-tab");
        $('.carousel').carousel();
        
        $('#myTab a').on('click', async function (e) {
            ativo.list = $(this).attr('list');
            $(ativo.id).html("&nbsp;")
            ativo.id = $(this).attr('href');
            last_id = null;
            cont = 0;
            await $(ativo.id).html("&nbsp;");
            
            setCard(jsonAjax(ativo.list),ativo.id)
            $('.carousel').carousel();
            e.preventDefault();
            $(this).tab('show')
        })
        
        
        setInterval(function(){ 
            setCard(jsonAjax(ativo.list,last_id),ativo.id);
        }, 30000);

        $( ".modal-click" ).click(function() {
            modalCollection(this)
        });
    });

    
    
     function jsonAjax(lista,id = null) {
        ativo.list = lista;
        var targeturl = '<?=$this->request->getAttribute('base')?>/collection-orders/lists/'+lista;
        var array_collection = null;
            if(id != null){
                targeturl += '/'+last_id;
            }
           var csrfToken = $("#csrfToken").val();
        $.ajax({ 
                type: 'POST', 
                url: targeturl,
                headers: { 'X-XSRF-TOKEN' : csrfToken},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                },
                data: {
                    "_csrfToken": getCookie("_ga")
                },
                async: false,
                dataType: 'json',
                success: function(data){                 
                    array_collection = data.collection_orders;
                    if(array_collection.length === 0){
                        array_collection = undefined;
                    }else{
                        array_collection.map(function(co) {
                                last_id = co.id;
                            
                        })
                        // last_id = array_collection[array_collection.length -1].id
                    }
                    
                }, 
                error: function(xhr,textStatus,error){ 
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.statusText
                    });
                },
                complete : function(data) {
                } 
            });

        return array_collection;
    }

    function setCard(array,id_nav) {
        if(array === undefined){
            if(last_id === null){
                $(id_nav).html("Você não tem dados dessas coleta.");
            }
            return null;
        }
         buttons = null;
         if(ativo.list === "pendente"){
            buttons = ["aceita","negada"];
        }
        if(ativo.list === "negada"){
            buttons = ["aceita",null];
        }
        if(ativo.list === "agendada"){
            buttons = [null,"finalizar"];
        }
        if(ativo.list === "finalizada"){
            buttons = [null,"info"];
        }
        if(ativo.list === "pendente-order"){
            buttons = [null,"negada"];
        }
        if(ativo.list === "negada-order"){
            buttons = [null,null];
        }
        ativo.id = id_nav;
        
        array.forEach(function (data,index) {
                $(id_nav).prepend(addCard(data.id,buttons,data.id_resp))
                $("#card"+cont+" #title-card").html("Nome: "+data.user.name)
                $("#card"+cont+" #title-data").html(data.quantity_garbage_bags+" Sacolas de "+data.comments) 
                var htmlcategorias = " ";
                
                data.categories_info.map(function (cc) {
                    htmlcategorias += '&nbsp;<img style="width: 30px;" src="<?=$this->request->getAttribute('webroot')?>/webroot/'+cc.url_icon+'" title="'+cc.name+'" alt="'+cc.name+'">'+cc.name+'&nbsp;'
                })
                
                $("#card"+cont+" #image-categorie").html('Categorias: '+htmlcategorias)
                
                var distancia = Number.parseFloat(getDistanceFromLatLonInKm(person.latitude,person.longitude,data.latitude,data.longitude)).toFixed(2)
                $("#card"+cont+" #title-distance").html("Essa coleta está a "+distancia+"Km de você");
                var dateSoliction = new Date(data.data_soliction)
                var dateCollection = new Date(data.date_service_ordes)
                $("#card"+cont+" #title-info").html("\n Data prevista da coleta : "+dateCollection.toLocaleDateString("en-GB")+" Turno: "+data.period)
                $("#card"+cont+" #title-time").html("Data da solicitação: "+dateSoliction.toLocaleDateString("en-GB",{ day: 'numeric',month: 'numeric',year: 'numeric',hour:"numeric",minute:"numeric"   }))
                if(data.images.length != 0 ){
                    data.images.forEach(function (data, index) {
                        var url = null;
                        url = String(data.url);
                        
                        // $("#card"+cont+" #fotos"+cont).append(addImagem(index,url));
                        $("#card"+cont+" #fotos"+cont).append(addImagem(index,url));
                        $("#card"+cont+" #itens-fotos").append(addItens(index));
                    });
                }else{
                    $("#card"+cont+" #fotos"+cont).append(addImagem(0,"<?=$this->request->getAttribute('webroot')?>/webroot/assets/images/sem-fotos.png"));
                    $("#card"+cont+" #itens-fotos").append(addItens(0));
                }
                $("#card"+cont+" #carousel-item0").addClass("active");
                $("#card"+cont+" #item0").addClass("active");
            
        });
        
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

    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
        var R = 6371; // Radius of the earth in km
        var dLat = deg2rad(lat2-lat1);  // deg2rad below
        var dLon = deg2rad(lon2-lon1); 
        var a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2)
            ; 
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        var d = R * c; // Distance in km
        return d;
    }

    function deg2rad(deg) {
        return deg * (Math.PI/180)
    }

    function modalCollection(who) {
			$('.modal-body').html('<div style="text-align:center"><i class="fa fa-refresh fa-spin"></i></div>');
			
			
			$('#modalcollection').modal('show').find('.modal-body').load($(who).attr('src'),function(responseText, textStatus, req){
			if (textStatus == "error") {
				alert('Sua consulta retornou um número muito grande de registros. Tente um período menor.');
				$('[data-dismiss="modal"]').click();
			}
		});
			$('#loading').hide();
		

		$('button[data-dismiss="modal"]').on('click', function(e){
			$('.modal-body').html("");
		});
    }
    function aceito(who) {

            id_collection = $(who).attr("collection");
            id_card = $($(who).attr("card"));
            var id_resp = $(who).attr("collectionresponde");
            var targeturl = '<?=$this->request->getAttribute('base')?>/collection-orders/aceita/';    
            var csrfToken = $("#csrfToken").val();

            $.ajax({ 
                type: 'POST', 
                url: targeturl,
                headers: { 'X-XSRF-TOKEN' : csrfToken},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                },
                data: {
                    "_csrfToken": getCookie("_ga"),
                    "id_collection": id_collection,
                    "id_resp": id_resp
                },
                async: false,
                dataType: 'json',
                success: function(data){                 
                    removeCard(id_card);
                    
                }, 
                error: function(xhr,textStatus,error){ 
                    Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.statusText
                        });
                },
                complete : function(data) {
                }
            });
    }
    
    function negado(who) {
            id_collection = $(who).attr("collection");
            id_card = $($(who).attr("card"));
            var id_resp = $(who).attr("collectionresponde")
            var targeturl = '<?=$this->request->getAttribute('base')?>/collection-orders/negado/';    
            var csrfToken = $("#csrfToken").val();

            $.ajax({ 
                type: 'POST', 
                url: targeturl,
                headers: { 'X-XSRF-TOKEN' : csrfToken},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                },
                data: {
                    "_csrfToken": getCookie("_ga"),
                    "id_collection": id_collection,
                    "id_resp": id_resp
                },
                async: false,
                dataType: 'json',
                success: function(data){                 
                    removeCard(id_card);
                    
                }, 
                error: function(xhr,textStatus,error){ 
                    Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.statusText
                        });
                },
                complete : function(data) {
                } 
            });
    }
    function finalizar(who) {
        Swal.fire({
        title: 'Deseja confirma o recebimento da coleta?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: `recebido`,
        cancelButtonColor: '#d33',
        cancelButtonText: `cancelar`,
        }).then((result) => {
            if (result.value) {
                id_collection = $(who).attr("collection");
                id_card = $($(who).attr("card"));
                var id_resp = $(who).attr("collectionresponde")
                var targeturl = '<?=$this->request->getAttribute('base')?>/collection-orders/finalizar/';    
                var csrfToken = $("#csrfToken").val();

                $.ajax({ 
                    type: 'POST', 
                    url: targeturl,
                    headers: { 'X-XSRF-TOKEN' : csrfToken},
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                    },
                    data: {
                        "_csrfToken": getCookie("_ga"),
                        "id_collection": id_collection
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data){                 
                        removeCard(id_card);
                        
                    }, 
                    error: function(xhr,textStatus,error){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.statusText
                        });
                    },
                    complete : function(data) {
                    } 
                });
            } 
        })
            
    }
    function previous(who) {
        $(who).carousel('prev');
    }

    function next(who) {
        $(who).carousel('next');
    }

</script>

