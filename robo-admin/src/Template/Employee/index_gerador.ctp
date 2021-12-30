<?php
$general = [
    'label'       => 'Usuários',
    'label_s'     => 'Criar novo usuário',
    'actual'      => 'Listar de usuários',
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

                <h4 class="mt-0 header-title">Lista de Usuários</h4>
                <hr>

                
                <?= $this->Form->end(); ?>
                <div class="table-rep-plugin">
                    <div class="table-responsive b-0" data-pattern="priority-columns">
                        <table id="employee" class="table  table-striped">
                            <thead>
                                <tr>                            
                                    <th>Avatar</th>
                                    <th> Nome </th>
                                    <th>E-mail</th>
                                    <th>Contato</th>
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
    <input id="csrfToken" type="hidden" value="<?= $this->request->getParam('_csrfToken') ?>">
</div>

<!-- Modal -->
<div class="modal fade bs-example-modal-center" id="ConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" id="myModalLabel">Deletar Registro</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja remover este Usuário da sua empresa?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <?php
                echo $this->Form->postLink(
                        'Confirmar', array('action' => 'delete'), array('class' => 'btn btn-danger active'), false
                );
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    var table = $("#employee").DataTable({
        "order": [[ 0, "asc" ]],
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
            url:"<?=$this->request->getAttribute('base')?>/employee/listJson/<?=$list?>"
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
                    json.data.map(function(em){
                        em.image = "<img src='"+em.image+"' width=60 height=40>"
                        em.number_contact = "("+em.number_contact.substring(0,2)+") "+em.number_contact.substring(2,3)+" "+em.number_contact.substring(3,7)+"-"+em.number_contact.substring(7)
                        em.option = '<div class="btn-group"><a href="<?=$this->request->getAttribute('base')?>/employee/edit/'+em.id_user+'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a><a href="<?=$this->request->getAttribute('base')?>/employee/view/'+em.id_user+'" class="btn btn-info btn-sm"><i class="fas fa-search-plus"></i></a><a href="#" data-toggle="modal" data-target="#ConfirmDelete" data-action="<?=$this->request->getAttribute('base')?>/employee/delete/'+em.id_user+'" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a></div>'
                        if(em.islogin == 1){
                            em.option = '<div class="btn-group"><a href="<?=$this->request->getAttribute('base')?>/employee/edit/'+em.id_user+'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a><a href="<?=$this->request->getAttribute('base')?>/employee/view/'+em.id_user+'" class="btn btn-info btn-sm"><i class="fas fa-search-plus"></i></a></div>'
                        }
                    });
                    
                }else{
                    json = $.parseJSON('{"draw":0,"recordsTotal":0,"recordsFiltered":0,"data":[]}');
                }
                
                return JSON.stringify( json ); // return JSON string
            }
        },createdRow: function (row, data, dataIndex) {
            if(data.islogin == 1){
                $(row).css("background-color","#F0F4D3")
            }
        }
        ,columns: [
        {
            data: "image"
        },
        {
            data:"name"
        }
        ,{
            data:"email"
        }
        ,
        {
            data:"number_contact"
        }
        ,{
            data:"option"
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
</script>
