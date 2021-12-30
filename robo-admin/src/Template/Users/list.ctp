<?php
$general = [
    'label'       => 'Usuários',
    'label_s'     => 'Criar novo usuário',
    'actual'      => 'Listar usuários',
    'breadcrumbs' => []
];

echo $this->element('Layout/_content_header', [
    'title'       => $general['label'],
    'small_title' => $general['label_s'],
    'actual'      => $general['actual'],
    'breadcrumbs' => $general['breadcrumbs'],
]);
use Cake\Routing\Router;
?>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?= $this->Flash->render() ?>
    </div>
</div>  
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">Lista de usuários</h4>
                <hr>

                
                <div class="row" style="margin-bottom: -25px">
                   
                   
                    <div class=" col-xl-12 m-b-30">
                        <div class="input-group input-group-sm mb-3">
                            
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tipo de usuário</span>
                            </div>
                            <?= $this->Form->control('users_types_id', ['options' => $usersTypes, 'empty' => 'Selecione', 'label' => false, 'class' => 'custom-select']) ?>
                            <div class="input-group-prepend">
                                <span class="input-group-text">Planos</span>
                            </div>
                            <?= $this->Form->control('plan_id', ['options' => $plans, 'empty' => 'Selecione', 'label' => false, 'class' => 'custom-select']) ?>
                        </div>
                    </div>

                    
                    
                </div>
                <hr>
               
                <div class="table-rep-plugin">
                    <div class="table-responsive b-0">
                        <table id="datatable_user_list" class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">Image</th>
                                    <th class="align-middle">ID</th>
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                    <th>Plano</th>
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

   <div class="modal modalDEl fade bs-example-modal-center" id="ConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                   
                    <h4 class="modal-title" id="myModalLabel">Deletar Registro</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja remover este registro?
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
<script>
    
    $(document).ready(function() {
        
        var table2 = $("#datatable_user_list").DataTable({
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
            url:"<?=$this->request->getAttribute('base')?>/users/listJson/<?=$tipo?>"
            ,headers: {
                'X-XSRF-TOKEN': $("#csrfToken").val()
            },beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
            },
            data: function ( d ) {
                d._csrfToken = getCookie("_ga");
                d.users_types_id = $("#users-types-id").val()
                d.plan_id = $("#plan-id").val()
                
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
                    json.data.map(function (user) {
                        user.image = '<img src="'+user.image+'" alt="" class="thumb-md rounded-circle mr-2" onerror="<?=$this->request->getAttribute('webroot')?>/webroot/assets/images/sem-fotos.png">'
                        user.option = '<div class="btn-group"><a href="<?=$this->request->getAttribute('base')?>/users/edit/'+user.id+'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a><a href="<?=$this->request->getAttribute('base')?>/users/view/'+user.id+'" class="btn btn-info btn-sm"><i class="fas fa-search-plus"></i></a> <a href="<?=$this->request->getAttribute('base')?>/users/upload/'+user.id+'" class="btn btn-success btn-sm"><i class="fas fa-file-image"></i></a><a href="#" data-toggle="modal" data-target="#ConfirmDelete" data-action="<?=$this->request->getAttribute('base')?>/users/delete/'+user.id+'" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a></div>'
                    })
                }else{
                    json = $.parseJSON('{"draw":0,"recordsTotal":0,"recordsFiltered":0,"data":[]}');
                }
                
                return JSON.stringify( json ); // return JSON string
            }
        }
        ,columns: [
        {
            data:"image"
        }
        ,{
            data: "id"
            
        },
        {
            data: "name"
        },
        {
            data:"type"
        }
        ,{
            data:"title"
        }
        ,{
            data: "option"
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
        $("#users-types-id").change(function () {
            filtroDT(table2)
        })
        $("#plan-id").change(function () {
            filtroDT(table2)
        })
    });

    function filtroDT(table2) {
   
        table2.ajax.reload();
  
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