<div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Painel Principal</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="#"><?= $session['company']['name'] ?></a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
                <div class="row align-items-xl-end">
                <div class="col-sm-8">
                       
                    </div>
                   <div class="col-sm-4 float-right">
                        <?= $this->Form->create()?>
                            <b>Período</b>
                                <div class=' input-group'>
                                    <input name="periodo" type='text' class="form-control shawCalRanges" value="<?=$datainicio.' - '.$datafim?>" />
                                    <button class="btn btn-primary" type="submit"  >Filtrar</button>
                                    <button class="btn btn-primary" type="button" onclick="window.open('./','_self')">Limpa filtro</button>
                                </div>
                        <?= $this->Form->end()?>
                        
                   </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12" >
                    <div class="card" style="">
                        <div class="card-heading p-4">
                            <h4>Quanto você está pagando hoje ?</h4>
                        </div>
                        <div class="card-body row" id="pricestoke">
                        <?php foreach ($users_categories as $categorie) { ?>
                            <div class="col-md-6 col-sm-5 col-xl-4" categorie="<?=$categorie->id?>">
                                <div class="row">
                                    <div class="form-group d-flex align-items-center">
                                        <div class="col-sm-5">
                                                <img height="47px" width="47px" src="<?=$this->request->getAttribute('webroot')?>webroot/<?=$categorie->url_icon?>" alt="">
                                            <p class="text-break"> 
                                               <?=$categorie->name ?>
                                            </p>
                                        </div>
                                        <div class="col-sm-3 mb-3">
                                            <label for="exampleInputEmail1">Preço/KG</label>
                                            <input type="text" class="form-control price" value="<?=$categorie->price != 0.00 ? $categorie->price:null ?>">
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <label for="exampleInputEmail1">Estoque em KG</label>
                                            <input type="text" class="form-control stock" value="<?=$categorie->stock != 000 ? $categorie->stock:null ?>">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                    <?php  }?>
                        </div>
                        <div class="card-footer" style="background-color:white">
                            <button type="button" class="btn btn-primary btn-lg btn-block" onclick="pricestokeUpdate()">Atualizar valores</button>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-xl-12 row">               
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-heading p-4">
                                <div class="mini-stat-icon float-right">
                                    <i class="mdi mdi-briefcase-check bg-success text-white"></i>
                                </div>
                                <div>
                                    <h5 class="font-16">Resíduos Gerados (KG)</h5>
                                </div>
                                <h3 class="mt-4 text-right">- KG</h3>
                                <div class="progress mt-4" style="height: 4px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 88%" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="text-muted mt-2 mb-0">Recolhido<span class="float-right">*</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-heading p-4">
                                <div class="mini-stat-icon float-right">
                                    <i class="mdi mdi-briefcase-check bg-success text-white"></i>
                                </div>
                                <div>
                                    <h5 class="font-16">Resíduos Gerados (R$)</h5>
                                </div>
                                <h3 class="mt-4 text-right">R$ - </h3>
                                <div class="progress mt-4" style="height: 4px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 88%" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="text-muted mt-2 mb-0">Em relação a Meta<span class="float-right">*</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-heading p-4">
                                <div class="mini-stat-icon float-right">
                                    <i class="mdi mdi-tag-text-outline bg-warning text-white"></i>
                                </div>
                                <div>
                                    <h5 class="font-16">Ticket médio (KG)</h5>
                                </div>
                                <h3 class="mt-4 text-right">- KG</h3>
                                <div class="progress mt-4" style="height: 4px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 68%" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="text-muted mt-2 mb-0">Em relação a Meta<span class="float-right">*</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-heading p-4">
                                <div class="mini-stat-icon float-right">
                                    <i class="mdi mdi-tag-text-outline bg-warning text-white"></i>
                                </div>
                                <div>
                                    <h5 class="font-16">Ticket médio (R$)</h5>
                                </div>
                                <h3 class="mt-4 text-right">R$ -</h3>
                                <div class="progress mt-4" style="height: 4px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 68%" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="text-muted mt-2 mb-0">Em relação a Meta<span class="float-right">*</span></p>
                            </div>
                        </div>
                    </div>
               </div>  -->
            </div>
            <!-- end row -->

           
            <!-- START ROW -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">Status das últimas solicitações de coleta</h4>
                            <div>
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Status</span>
                                    </div>
                                        <select class="custom-select" name="status" id="status">
                                            <option value=""  selected>Selecione..</option>
                                            <?php foreach ($status_bd_co as $value) {?>
                                                <option value="<?=$value->status?>"><?=$value->status?></option>
                                            <?php }?>
                                        </select>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Respostas</span>
                                    </div>
                                        <select class="custom-select" name="resposta" id="resposta">
                                            <option value=""  selected>Selecione..</option>
                                            <?php foreach ($status_bd_respo as $value) {?>
                                                <option value="<?=$value->status?>"><?=$value->status?></option>
                                            <?php }?>
                                            
                                        </select>
                                </div>
                               
                            </div>
                            <div class="table-responsive" style=" ">
                                <table class="table table-hover  datatable">
                                    <thead>
                                        <tr>
                                            <th>O.C.</th>
                                            <th>Gerador</th>
                                            <th>Status</th>
                                            <th>Tipo | Sacolas</th>
                                            <th>Resposta</th>
                                            <th>Localização</th>
                                            <th >Data</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!-- END ROW -->
            <div id="collection-orders">
            </div>
            <input id="csrfToken" type="hidden" value="<?= $this->request->getParam('_csrfToken') ?>">
<script>
setTimeout(function() {
    
    var f = "DD/MM/Y";
		$('.shawCalRanges').daterangepicker({
			ranges: {
				'Hoje': [moment().format(f), moment().format(f)],
				'Ontem': [moment().subtract(1, 'days').format(f), moment().subtract(1, 'days').format(f)],
				'Últimos 7 dias': [moment().subtract(6, 'days').format(f), moment().format(f)],
				'Próximos 7 dias': [moment().format(f), moment().add(6, 'days').format(f)],
				'Esse mês': [moment().startOf('month').format(f), moment().endOf('month').format(f)],
				'Mês passado': [moment().subtract(1, 'month').startOf('month').format(f), moment().subtract(1, 'month').endOf('month').format(f)]
			},
			locale: {
				format: 'DD/MM/YYYY',
				applyLabel: "Ok",
				cancelLabel: 'Cancelar',
				startLabel: 'Início',
				endLabel: 'Fim',
				customRangeLabel: 'Período',
				daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex','Sáb'],
				monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
				firstDay: 1
			},
			 alwaysShowCalendars: true,
		});
    
}, 3000);

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
$(document).ready(function() {
    $(".price").mask("#.##0,00", {reverse: true});
    $(".stock").mask("###", {reverse: true});
    collectionOrdersView()
    var table = $(".datatable").DataTable({
        "order": [[ 0, "desc" ]],
        responsive: false,
        retrieve: false,
        paging : true,
        scroll : false,
        searching: true,
        fixedHeader: {
          header: true,
          footer: false
        },
        processing: true,
        serverSide: true,
        ajax: { 
            url:"<?=$this->request->getAttribute('base')?>/Pages/listajsondatatabletColetor/"
            ,headers: {
                'X-XSRF-TOKEN': $("#csrfToken").val()
            },beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
            },
            data: function ( d ) {
                d._csrfToken = getCookie("_ga");
                d.status = $("#status").val();
                d.resposta = $("#resposta").val();
            }
            ,type: 'POST'
            ,dataFilter: function(d){
            
                let json = JSON.parse(d).json;
                //nao mexa
                json = JSON.parse(json);
                if(json != null){
                    json.recordsTotal = json.recordsTotal;
                    json.recordsFiltered = json.recordsFiltered;
                    json.data = json.data;
                    json.data.map(function(oc){
                        //ordem de coleta
                        if(oc.status_ordes == 'cancelada'){
                            oc.status_ordes  = "<span class='badge badge-danger'>"+ capitalize(oc.status_ordes) +"</span>"
                        }
                        if(oc.status_ordes == 'finalizada'){
                            oc.status_ordes  = "<span class='badge badge-success'>"+ capitalize(oc.status_ordes) +"</span>"
                        }
                        if(oc.status_ordes == 'pendente'){
                            oc.status_ordes  = "<span class='badge badge-warning'>"+ capitalize(oc.status_ordes) +"</span>"
                        }
                        if(oc.status_ordes == 'agendada'){
                            oc.status_ordes  = "<span class='badge badge-info'>"+ capitalize(oc.status_ordes) +"</span>"
                        }
                        if(oc.status_ordes == 'coletada'){
                            if(oc.status_respo == 'aceita'){
                                oc.status_ordes  = "<span class='badge badge-primary'>"+oc.status_ordes+" ("+oc.modified+") </span>"
                            }else{
                                oc.status_ordes  = "<span class='badge badge-primary'>"+oc.status_ordes+"</span>"
                            } 
                        }
                        //respota
                        if(oc.status_respo == 'pendente'){
                            oc.status_respo  = "<span class='badge badge-warning'>"+capitalize(oc.status_respo)+"</span>"
                        }
                        if(oc.status_respo == 'aceita'){
                            oc.status_respo  = "<span class='badge badge-success'>"+capitalize(oc.status_respo)+"</span>"
                        }
                        if(oc.status_respo == 'negada'){
                            oc.status_respo  = "<span class='badge badge-danger'>"+capitalize(oc.status_respo)+"</span>"
                        }
                    });
                }else{
                    json = $.parseJSON('{"draw":0,"recordsTotal":0,"recordsFiltered":0,"data":[]}');
                }
                
                return JSON.stringify( json ); // return JSON string
            }
        },createdRow: function (row, data, dataIndex) {
            $(row).attr('onclick',"modalCollection(this)");
            $(row).attr('src',"<?=$this->request->getAttribute('base')?>/collection-orders/view/"+data.id_orders);
            $(row).attr('data-target',"#modalcollection");
            $(row).attr('target',"_BLANK");
            $(row).css("cursor","pointer")
        }
        ,columns: [{
            data: "id_orders"
            
        },
        {
            data: "gerador"
        },
        {
            data:"status_ordes"
        }
        ,{
            data:"quantity_garbage_bags"
        }
        ,
        {
            data:"status_respo"
        },
        {
            data:"endereco"
        },
        {
            data:"data"
        }     
        ],
        language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json",
                decimal: ",",
                thousands: "."
            },
            buttons: [
                {
                  extend: 'copy',
                  text: 'Copiar'
                },
                {
                  extend: 'print',
                  text: 'Imprimir',
                  messageTop: 'Relatório: ',
                },
                {
                  extend: 'excel',
                  text: 'Excel',
                  messageTop: 'Relatório:',
                },
                {
                  extend: 'pdf',
                  text: 'PDF',
                  messageTop: 'Relatório: ',
                }
            ],
            dom: 'Bfrtip'
    });
    
    $('#status').change(function () {
        filtroDT(table);
    });
    $('#resposta').change(function () {
        filtroDT(table);
    });
});
function filtroDT(table) {
   
   table.ajax.reload();
  
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

   const capitalize = str => {
	if (typeof str !== 'string') {
		return '';
	}
	return str.charAt(0).toUpperCase() + str.substr(1);
}
async function pricestokeUpdate(){
    var pricestoke = [];
    $("#pricestoke").children().each(function(idx,val){
        if($(this).find(".price").val() != "" && $(this).find(".stock").val() != ""){
            pricestoke.push({id:$(this).attr("categorie"),price:$(this).find(".price").val(),stock:$(this).find(".stock").val()})
            $(this).find(".price").removeClass("is-invalid")
            $(this).find(".stock").removeClass("is-invalid")
        }else{
            $(this).find(".price").addClass("is-invalid")
            $(this).find(".stock").addClass("is-invalid")
            pricestoke.length = 0;
            return false;
        }
    })
    
    if(pricestoke.length != 0){
        $.ajax({
                url:"<?=$this->request->getAttribute('base')?>/pages/pricestokeUpdate"
                ,type:"POST"
                ,headers: {
                    'X-XSRF-TOKEN': $("#csrfToken").val()
                },beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
                }
                ,data:{
                    "pricestoke":pricestoke
                },
                dataType: 'json'

            }).done(function (data) {
                Swal.fire({
                icon: 'success',
                title: "atualizado com sucesso"
            });
            }).fail(function (xhr,textStatus,error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: xhr.statusText
                });
            })
    }else{
        await Swal.fire({
            icon: 'error',
            title: "Você precisa preencher tudo!"
        });
    }
}
function collectionOrdersView() {
    $.ajax({
            url:"<?=$this->request->getAttribute('base')?>/collection-orders"
            ,type:"POST"
            ,headers: {
                'X-XSRF-TOKEN': $("#csrfToken").val()
            },beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
            }
            ,
            dataType: 'html'

        }).done(function (data) {
            $("#collection-orders").html(data)
        }).fail(function (xhr,textStatus,error) {
            Swal.fire({
                icon: 'error',
                 title: 'Oops...',
                text: xhr.statusText
            });
        })
}
</script>

<div class="modal fade text-left" id="modalcollection" tabindex="-1" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header  white" style="background: #009975;">
					<h4 style="text-align:center;width: 100%;" class="modal-title" id="modallabel">
						<?=$this->Html->link(
						$this->Html->image('#', [
							'class'=>'brand-logo',
							'width'=>'250px'
						]),
						"#",
						['class'=> 'navbar-brand','escape'=>false])?>
						<br>
						<span style="font-size:12px">
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