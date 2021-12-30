

<style>
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: white;
        display:none;
    }
</style>

<div class="loader bd-highlight align-items-center " style="color:#004938">
<i class="fas fa-recycle fa-spin fa-7x m-auto p-2 bd-highlight"></i>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Coletas</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>  Criar nova coleta', ['controller'=>'pages','action' => 'index'], ['class' => 'float-right', 'escape' => false]) ?>
                    </ol>                  
                </div>
            </div>
        </div>
    </div>
</div>  
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">Lista de Coletas</h4>
                <hr>
                
                <div class="table-rep-plugin">
                    <div class="table-responsive b-0" data-pattern="priority-columns">
                        <table id="collection" class="table  table-striped">
                       <thead>
                        <tr>                            
                            <th>ID</th>
                            <th>Endereço</th>
                            <th>Categorias</th>
                            <th>Status</th>
                            <th>Data da solitação</th>
                            <th>Qt. de respostas</th>
                            <th>Opções</th>
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
            </div>
            <input id="csrfToken" type="hidden" value="<?= $this->request->getParam('_csrfToken') ?>">
 <!-- Modal cancelada -->
    <div class="modal fade bs-example-modal-center" id="ConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                   
                    <h4 class="modal-title" id="myModalLabel">Cancelar solicitação de coleta</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja cancelar essa coletar?
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <?php
                        echo $this->Form->postLink(
                             'Confirmar',
                                array('action' => 'delete'),
                                array('class' => 'btn btn-danger active'),
                                false
                             );
                            ?>
                </div>
            </div>
        </div>
    </div>
 <!-- Modal coletada -->
    <div class="modal fade bs-example-modal-center" id="Confirmcoletada" tabindex="-1" role="dialog" aria-labelledby="coletada" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                   
                    <h4 class="modal-title" id="myModalLabel">O coletor/reciclador coletou o seu resíduo?</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja finalizar essa coletar?
                    <p class="text-muted">Após confimar você não pode desfazer a ação</p>
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <?php
                        echo $this->Form->postLink(
                             'Sim',
                                array('action' => 'finalizar'),
                                array('class' => 'btn btn-success active'),
                                false
                             );
                            ?>
                </div>
            </div>
        </div>
    </div>

<script>
        $(".loader").fadeIn("fast");
        $(".loader").addClass("d-flex");
    $(document).ready(function() {
        $('#Confirmcoletada').on('show.bs.modal', function (e) {
            $(this).find('form').attr('action', $(e.relatedTarget).attr('data-action'));
        });
        
    var table = $("#colletion").DataTable({
        "order": [[ 0, "desc" ],[5,"desc"]],
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
            url:"<?=$this->request->getAttribute('base')?>/collection/indexJson/"
            ,headers: {
                'X-XSRF-TOKEN': $("#csrfToken").val()
            },beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
                
            },
            data: function ( d ) {
                d._csrfToken = getCookie("_ga");
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
                    json.data.map(function(co){
                        if(co.status !== 'cancelada'){
                            co.option = '<div class="btn-group"><a href="<?=$this->request->getAttribute('base')?>/collection/view/'+co.id+'" class="btn btn-info btn-sm"><i class="fas fa-search-plus"></i></a><a href="#" data-toggle="modal" data-target="#ConfirmDelete" data-action="<?=$this->request->getAttribute('base')?>/collection/delete/'+co.id+'" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a></div>'
                        }
                        if(co.status == 'cancelada'){
                            co.status  = "<span class='badge badge-danger'>"+ capitalize(co.status) +"</span>"
                        }
                        if(co.status == 'coletada'){
                            co.status  = "<span class='badge badge-success'>"+ capitalize(co.status) +"</span>"
                            co.option = '<div class="btn-group"><a href="<?=$this->request->getAttribute('base')?>/collection/view/'+co.id+'" class="btn btn-info btn-sm"><i class="fas fa-search-plus"></i></a></div>'
                        }
                        if(co.status == 'pendente'){
                            co.status  = "<span class='badge badge-warning'>"+ capitalize(co.status) +"</span>"
                        }
                        if(co.status == 'agendada'){
                            co.status  = "<span class='badge badge-info'>"+ capitalize(co.status) +"</span>"
                            co.option = '<div class="btn-group"><a href="<?=$this->request->getAttribute('base')?>/collection/view/'+co.id+'" class="btn btn-info btn-sm"><i class="fas fa-search-plus"></i></a><a href="#" data-toggle="modal" data-target="#Confirmcoletada" data-action="<?=$this->request->getAttribute('base')?>/collection/finalizar/'+co.id+'" class="btn btn-success btn-sm"><i class="fas fa-check"></i></a></div>'
                        }
                        
                        co.categories = co.categories.join('')
                        
                        

                    });
                    
                }else{
                    json = $.parseJSON('{"draw":0,"recordsTotal":0,"recordsFiltered":0,"data":[]}');
                }
                $(".loader").fadeOut("slow");
                $(".loader").removeClass("d-flex");
                return JSON.stringify( json ); // return JSON string
            }
        }
        ,columns: [{
            data: "id"
            
        },
        {
            data: "address"
        },
        {
            data:"categories"
        }
        ,{
            data:"status"
        }
        ,{
            data:"data",
            className:"text-right"
            
        }
        ,{
            data:"resposta",
            className:"text-right"
        }
        ,
        {
            data:"option"
        }    
        ],
        language: {
                url: "<?=$this->request->getAttribute('webroot')?>/webroot/assets/js/datatables_language.json",
                decimal: ",",
                thousands: ".",
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
</script>