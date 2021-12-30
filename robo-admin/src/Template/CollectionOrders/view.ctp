<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<div class="card">
  <div class="card-header">
    Coleta - <?=$collection_orders->collection_orders_id?>
  </div>
  <div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="col-12">
                <h5>Gerador: </h5>
                <span><label>Nome: </label>&nbsp;<?= $collection_orders->status_respo == "aceita" || $collection_orders->status_respo == "recebido" ? $gerador->nome :'  <i class="fas fa-lock"></i>'?></span></br>
                <span><label>Contato:</label>  <span class="maskphone"><?= $collection_orders->status_respo == "aceita" || $collection_orders->status_respo == "recebido" ? '<a target="_blank"  href="https://api.whatsapp.com/send?phone=+55'.$gerador->contato.'" class="btn btn-success"><i class="fab fa-whatsapp"></i> Whatsapp</a> '.$this->TophoneBR($gerador->contato) : "****".substr($this->TophoneBR($gerador->contato),11)?></span></span>
                <h5>Coleta: </h5>
                <span> <label> Tipo:</label>  <?=$collection_orders->type == 0 ? 'Doação': 'Venda'?></span></br>
                <span><label>Status:</label> <?=$collection_orders->status?></span></br>
                <span><label>Quantidade:</label> <?=intval($collection_orders->quantity_garbage_bags)?></span></br>
                <span><label>Categoria:</label> <?=$collection_orders->materiais ?></span></br>
                <span><label>Comentário:</label> <span class="text-justify"><?=$collection_orders->comments?></span></span></br>
                <span><label>Período de preferência:</label> <?=$collection_orders->period?></span></br>
                <span><label>Endereço:</label> <?= $collection_orders->status_respo == "aceita" || $collection_orders->status_respo == "recebido"  ? $collection_orders->address.", ".$collection_orders->number ." - ".$collection_orders->district .".". $collection_orders->city ."/".$collection_orders->state : $collection_orders->district .". ". $collection_orders->city."/". $collection_orders->state ?>  </span></br>
                
            </div>
            <div class="col-12 mt-2">
                <?php if($collection_orders->status_respo == "recebido"){?>
                        <div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Que resíduos vieram nessa coleta ?</h4>
                            <?= $this->Form->create(null, ['type' => "file","id"=>"formcollection","url"=>"/collection-orders/addStock/".$collection_orders->collection_orders_id]) ?>
                                    <div class="allcoletas">
                                    <?php if($collection_orders->stock == null){?>
                                        <div class="form-group row" id="coleta1">
                                            <div class="col-5">
                                                <label for="materiais1">Resíduo</label>
                                                <select class="form-control" required id="materiais1" name="categorie[]">
                                                    <option value="-1" selected disabled>Tipo de resíduo</option>
                                                    <?php foreach($users_all_categories_query as $categories){ ?>
                                                    <option value="<?=$categories->id?>"><?=$categories->name?></option>
                                                    <?php }?>
                                                </select>
                                                
                                            </div>
                                            <div class="col-5">
                                                <label for="quantidade1">Quantidade/KG</label>
                                                <input type="text" class="form-control" id="quantidade1" name="stock[]" required>
                                            </div>
                                            <div class="col-2 mt-3 mb-1 d-flex align-items-end">
                                                <button onclick="removerMaterial('#coleta1')" class="btn btn-danger"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div><div class="form-group row" id="coleta1">
                                            <div class="col-5">
                                                <label for="materiais1">Resíduo</label>
                                                <select class="form-control" required id="materiais1" name="categorie[]">
                                                    <option value="-1" selected disabled>Tipo de resíduo</option>
                                                    <?php foreach($users_all_categories_query as $categories){ ?>
                                                    <option value="<?=$categories->id?>"><?=$categories->name?></option>
                                                    <?php }?>
                                                </select>
                                                
                                            </div>
                                            <div class="col-5">
                                                <label for="quantidade1">Quantidade/KG</label>
                                                <input type="text" class="form-control" id="quantidade1" name="stock[]" required>
                                            </div>
                                            <div class="col-2 mt-3 mb-1 d-flex align-items-end">
                                                <button onclick="removerMaterial('#coleta1')" class="btn btn-danger"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    <?php }else{?>
                                        <?php foreach ($collection_orders->stock as $value) {?>
                                        
                                        <div class="form-group row" id="coleta1">
                                            <div class="col-5">
                                                <label for="materiais1">Resíduo</label>
                                                <select class="form-control" required id="materiais1" name="categorie[]">
                                                    <option value="-1" selected disabled>Tipo de resíduo</option>
                                                    <?php foreach($users_all_categories_query as $categories){ ?>
                                                        <option value="<?=$categories->id?>" <?=$value->categorie_id ==$categories->id ? "selected":null  ?>><?=$categories->name?></option>
                                                    <?php }?>
                                                </select>
                                                
                                            </div>
                                            <div class="col-5">
                                                <label for="quantidade1">Quantidade/KG</label>
                                                <input type="text" class="form-control" id="quantidade1" name="stock[]" required value="<?=$value->stock?>">
                                            </div>
                                            <div class="col-2 mt-3 mb-1 d-flex align-items-end">
                                                <button type="button" onclick="removerMaterial('#coleta1')" class="btn btn-danger"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                        <?php }?>

                                    <?php }?>
                                    </div>
                                <button type="button" class="btn btn-primary" onclick="adicionarMateriais()">Adicionar</button>
                                <br>
                                <input type="checkbox" class="mt-3" checked name="email"> Enviar e-mail com resumo da coleta!
                                <?= $this->Form->button(__('Salvar'), ['class' => "mt-3 btn btn-success btn-lg btn-block",'id'=>"salva-coletado"]) ?>
                                <?= $this->Form->end() ?>
                            </div>

                        </div>
                <?php }?>
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
            <div id="map" style="width:100%; height:300px"></div>
					<a target="_blank" class="form-control btn btn-primary"
					href="https://www.google.com/maps?saddr=My+Location&daddr=<?= $collection_orders->status_respo == "aceita" || $collection_orders->status_respo == "recebido"  ? $collection_orders->address.", ".$collection_orders->number ." - ".$collection_orders->district .".". $collection_orders->city ."/".$collection_orders->state : $collection_orders->district .". ". $collection_orders->city."/". $collection_orders->state ?>">
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
<script>
    $(document).ready(function () {
    
    $("input[name='stock[]']").mask("#,##0.00", {reverse: true})

    function iniciar() {
        var muxiCoordinates = [<?=$collection_orders->latitude?>, <?=$collection_orders->longitude?>];
        var initialZoomLevel = 13;
        <?php if($collection_orders->status_respo == "aceita" || $collection_orders->status_respo == "recebido" ) {?>
        var maxZoom = 18;
        <?php }else{?>
        var maxZoom = 13;
        <?php }?>

        // create a map in the "map" div, set the view to a given place and zoom
        var map = L.map('map',{maxZoom:maxZoom}).setView(muxiCoordinates, initialZoomLevel);

        // add an OpenStreetMap tile layer
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; Contribuidores do <a href="http://osm.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var muxiMarkerMessage = "Local da coleta!";

        
        <?php if($collection_orders->status_respo == "aceita" || $collection_orders->status_respo == "recebido" ) {?>
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

    <?php }else{?>
        L.circle(muxiCoordinates, {
          color: "red",
          fillColor: "#f03",
          fillOpacity: 0.5,
          radius: 500.0
      }).addTo(map)
        .bindPopup(muxiMarkerMessage);
        <?php } ?>
    }
    setTimeout(function() {
        iniciar();
    }, 200);
    $('#salva-coletado').on('click', function(e){
        $(this).attr("disabled", true);
        e.preventDefault();
        console.log($(this).attr("disabled"))
        var url = $('#formcollection').attr("action");
        enviar(url)
    });
    
});
var countColeta = 1;
    function adicionarMateriais(who) {
        countColeta++;
        $(".allcoletas").append(`<div class="form-group row" id="coleta`+countColeta+`">
                                    <div class="col-5">
                                        <label for="materiais`+countColeta+`">Resíduo</label>
                                        <select required class="form-control" id="materiais1" name="categorie[]">
                                                <option value="-1" selected disabled>Selecione um resíduo</option>
                                                <?php foreach($users_all_categories_query as $categories){ ?>
                                                <option value="<?=$categories->id?>"><?=$categories->name?></option>
                                                <?php }?>
                                            </select>
                                    </div>
                                    <div class="col-5">
                                        <label for="quantidade`+countColeta+`">Quantidade/KG</label>
                                        <input required type="text" class="form-control" id="quantidade`+countColeta+`" name="stock[]">
                                    </div>
                                    <div class="col-2 d-flex align-items-end">
                                        <button onclick="removerMaterial('#coleta`+countColeta+`')" class="btn btn-danger"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>`)
    }
    function removerMaterial(idMaterial) {
        $(".allcoletas").find(idMaterial).html(" ")
        
    }

    

    function enviar(url) {
        var fd = new FormData($("#formcollection")[0]);

        $.ajax({
            url:url
            ,type:"POST"
            ,headers: {
                'X-XSRF-TOKEN': $("#csrfToken").val()
            },beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
            }
            ,data:fd,
            contentType: false,
            processData: false,
            cache: false,
            mimeType: "multipart/form-data",
            dataType: 'json'

        }).done(function (data) {
            Swal.fire({
                            icon: 'success',
                            title: 'Parabéns',
                            text: data.mensagem
                        });
            $("#salva-coletado").attr("disabled", false);
        }).fail(function (erro) {
            Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: erro.mensagem
                        });
            $("#salva-coletado").attr("disabled", false);
        })
    }


</script>