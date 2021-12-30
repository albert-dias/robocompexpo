<!-- Morris chart -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin="">
</script>

<?php
    $user = $this->request->session()->read('Auth.User');
?>

<div/>

<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-heading p-4">
                <div class="mini-stat-icon float-right">
                    <i class="fas fa-users bg-primary text-white"></i>
                </div>
                <div>
                    <h5 class="font-16">Usuários Ativos</h5>
                </div>
                <a style="cursor:pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/users/total" target="_blanck">
                    <h3 class="mt-4"><?=$ativos?></h3>
                </a>
                <div class="progress mt-4" style="height:4px;"></div>
                    <p class="mt-2 mb-0">
                        <a style="cursor: pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/users/activetecnic" target="_blanck">
                            Técnicos: <span class="font-weight-bolder"><?=$tecnico?></span>
                        </a>
                        <span class="float-right">
                            <a style="cursor: pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/users/activeclient" target="_blanck">
                                Clientes: <span class="font-weight-bolder"><?=$cliente?></span>
                            </a>
                        </span>
                    </p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-heading p-4">
                <div class="mini-stat-icon float-right">
                    <i class="fas fa-users bg-warning text-white"></i>
                </div>
                <div>
                    <h5 class="font-16">Usuários Inativos</h5>
                </div>
                <h3 class="mt-4"><?=$inativos?></h3>
                <div class="progress mt-4" style="height:4px"></div>
                <p class="mt-2 mb-0">
                    <a style="cursor: pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/users/inactivetecnic">
                        Técnicos: <span class="font-weight-bolder"><?=$tecnicoinativo?></span>
                    </a>
                    <span class="float-right">
                        <a style="cursor: pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/users/inactiveclient">
                            Clientes: <span class="font-weight-bolder"><?=$clienteinativo?></span>
                        </a>
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

    <!-- Filtros do mapa -->
<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-30">
            <div class="card-body row">
                <div class="col-6">
                    <button type="button" class="btn btn-danger btn-lg btn-block" id="markertecnico">Técnicos</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-info btn-lg btn-block" id="markercliente">Clientes</button>
                </div>
                <div class="col-12 mt-2">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Mapa -->
<div id="mapid" style="height: 350px;"></div>
    <h3>Processos</h3>

<!-- Cards dos status do carrinho -->
<div class="row">
    <!-- Card do status 'NO CARRINHO' -->
    <div class="col-sm-6 col-xl-3">
        <a style="cursor: pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/shoppingcart/carrinho" target="_blanck"> 
            <div class="card">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="fas fa-shopping-cart bg-info  text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">No carrinho</h5>
                    </div>
                    <h3 class="mt-4"><?=$count_processos->Carrinho?></h3>
                    <div class="progress mt-4" style="height: 4px;">
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- Card do status 'EM ESPERA' -->
    <div class="col-sm-6 col-xl-3">
        <a style="cursor: pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/shoppingcart/waiting" target="_blanck">
            <div class="card">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="fas fa-clock bg-warning  text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Em espera</h5>
                    </div>
                    <h3 class="mt-4"><?=$count_processos->Em_espera?></h3>
                    <div class="progress mt-4" style="height: 4px;">
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- Card do status 'EM ANDAMENTO -->
    <div class="col-sm-6 col-xl-3">
        <a style="cursor: pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/shoppingcart/ongoing" target="_blanck">
            <div class="card">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="fas fa-business-time bg-secondary  text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Em andamento</h5>
                    </div>
                    <h3 class="mt-4"><?=$count_processos->Andamento?></h3>
                    <div class="progress mt-4" style="height: 4px;">
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- Card do status 'FINALIZADO' -->
    <div class="col-sm-6 col-xl-3">
        <a style="cursor:pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/shoppingcart/finished" target="_blanck">
            <div class="card">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="fas fa-check bg-success  text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Finalizados</h5>
                    </div>
                    <h3 class="mt-4"><?=$count_processos->Finalizado + $count_processos->FinalizadoTec + $count_processos->FinalizadoCliente?></h3>
                    <div class="progress mt-4" style="height: 4px;">
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- Card do status 'AVALIADO' -->
    <div class="col-sm-6 col-xl-3">
        <a style="cursor:pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/shoppingcart/evaluate" target="_blanck">
            <div class="card">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="fas fa-clipboard-check bg-success  text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Avaliados</h5>
                    </div>
                    <h3 class="mt-4"><?=$count_processos->Avaliado + $count_processos->AvaliadoTec + $count_processos->AvaliadoCliente?></h3>
                    <div class="progress mt-4" style="height: 4px;">
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- Card do status 'NEGADO' -->
    <div class="col-sm-6 col-xl-3">
        <a style="cursor:pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/shoppingcart/denied" target="_blanck">
            <div class="card">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="fas fa-times bg-danger text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Negados</h5>
                    </div>
                    <h3 class="mt-4"><?=$count_processos->Negado?></h3>
                    <div class="progress mt-4" style="height: 4px;">
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Gráfico de acumulado nos últimos 12 meses -->
<div class="row">
    <div class="col-sm-6 col-xl-6">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title mb-4">Cadastro de usuários acumulado (últimos 12 meses)</h4>
                <div id="chartYear" style="height: 250px"></div>
            </div>
        </div>
    </div>
    <!-- Gráfico de cadastros do período escolhido -->
    <div class="col-sm-6 col-xl-6">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title mb-4">Cadastro de usuários no período (Mês vigente)</h4>
                <div id="chartMonth" style="height: 250px"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="modalcolletion" tabindex="-1" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header  white" style="background: #156875;">
                <h4 style="text-align:center;width: 100%;" class="modal-title" id="modallabel">
                    <?=$this->Html->link(
						$this->Html->image('https://grupoecomp.corpstek.com.br/robo-admin/webroot/assets/images/logo.png', [
							'class'=>'brand-logo',
							'width'=>'250px'
						]),
                        "#",
						['class'=> 'navbar-brand','escape'=>false])?>
                    <br>
                    <span style="font-size:18px; color:white">
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

<style>
    .mbox {
        display: inline-block;
        width: 10px;
        height: 10px;
        margin: 10px 55px 10px 25px;
        padding-left: 4px;
    }
</style>

<script>
    // gráficos do ano acumulado (12 meses)
    var chart = new Morris.Line({
                    element: 'chartYear',
                    resize: true,
                    parseTime: false,
                    data: [<?=$cout_people_month_json?>],
                    xkey: 'mes',
                    ykeys: ['tecnico','cliente','total'],
                    labels: ['<span style="color: #0b62a4; font-weight: bold">cliente</span>',
                             '<span style="color: #7a92a3; font-weight: bold">tecnico</span>',
                             '<span style="color: #4da74d; font-weight: bold">total</span>'],
                });
 
    // gráficos do mês acumulado (+- 30 dias)
    var config = {
        element: 'chartMonth',
        data: [<?=$cout_people_day_json?>],
        resize: true,
        xkey: 'dia',
        ykeys: ['tecnico','cliente'],
        labels: ['<span style="color: #03A4A9; font-weight: bold">tecnico</span>',
                 '<span style="color: #282D41; font-weight: bold">cliente</span>'],
        pointFillColors:['#ffffff'],
        pointStrokeColors: ['black'],
        barColors:['#03a4a9','#282d41'],
        stacked: true,
    }
    Morris.Bar(config);

    var mymap = L.map('mapid').setView([-5.8299216,-35.2236593], 13);
    var t = 0;
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mymap);

    var local_user = [];
    var markers_cliente = [];
    var markers_tecnico = [];

    local_user = <?=json_encode($local)?>;
    local_user = JSON.parse(local_user);

    local_user.forEach(function (loc) {
        if(loc.usertype === '5') {
            var clientIcon = L.icon({
                iconUrl: '<?=$this->request->getAttribute('webroot')?>assets/vendors/leaflet/images/marker-icon-blue.png'
            });
            var aux = L.marker([loc.latitude, loc.longitude], {icon:clientIcon}).addTo(mymap)
            .bindPopup( '<span class="font-weight-bold">Nome: </span>' + loc.name +
                        '<br/><span class="font-weight-bold">Endereço: </span>' + loc.address + ', <span class="font-weight-bold">' + loc.number + 
                        '</span></b><br/><span class="font-weight-bold">Bairro: </span>' + loc.district);
            markers_cliente.push(aux);
        } else if(loc.usertype === '6') {
            var tecnicoIcon = L.icon({
                iconUrl: '<?=$this->request->getAttribute('webroot')?>assets/vendors/leaflet/images/marker-icon-red.png'
            });
            var aux = L.marker([loc.latitude, loc.longitude], {icon:tecnicoIcon}).addTo(mymap)
            .bindPopup( '<span class="font-weight-bold">Nome: </span>' + loc.name +
                        '<br/><span class="font-weight-bold">Endereço: </span>' + loc.address + ', <span class="font-weight-bold">' + loc.number + 
                        '</span></b><br/><span class="font-weight-bold">Bairro: </span>' + loc.district);
            markers_tecnico.push(aux);
        }
    });

    var aux_option_tecnico = true;
    var aux_option_cliente = true;

    // Código que altera a cor do botão de filtro de técnico do mapa
    $("#markertecnico").click(function(e) {
        if(aux_option_tecnico){
            markers_tecnico.forEach(function(ge) {
                ge.setOpacity(0);
            });
            aux_option_tecnico = false;
            $("#markertecnico").removeClass('btn-danger').addClass('btn-secondary');
        }
        else{
            markers_tecnico.forEach(function(ge) {
                ge.setOpacity(1);
            });
            aux_option_tecnico = true;
            $("#markertecnico").removeClass('btn-secondary').addClass('btn-danger');
        }
    });

    // Código que altera a cor do botão de filtro de cliente do mapa
    $("#markercliente").click(function(e) {
        if(aux_option_cliente){
            markers_cliente.forEach(function(ge) {
                ge.setOpacity(0);
            });
            aux_option_cliente = false;
            $("#markercliente").removeClass('btn-info').addClass('btn-secondary');
        }
        else{
            markers_cliente.forEach(function(ge) {
                ge.setOpacity(1);
            });
            aux_option_cliente = true;
            $("#markercliente").removeClass('btn-secondary').addClass('btn-info');
        }
    });

    function modalCollection(who){
        $('.modal-body').html('<div style="text-align: center"><i class="fa fa-refresh fa-spin" /></div>');

        $('#modalcolletion').modal('show').find('.modal-body').load($(who).attr('src'), function(responseText, textStatus, req){
            if(textStatus     == "error") {
                alert('Sua consulta retornou um número muito grande de registros. Tente um período menor.');
                $('a[data-dismiss="modal"]').click();
            }
        });
        $('#loading').hide();

        $('button[data-dismiss="modal"]').on('click', function(e){
            $('.modal-body').html("");
        });
    }
</script>