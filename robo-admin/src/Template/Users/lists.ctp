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
            <!-- <div class="card-body">

                <h4 class="mt-0 header-title">Lista de usuários</h4>
                <hr>
                 Filtros 
                 <div class="row" style="margin-bottom: -25px">                   
                    <div class=" col-xl-12 m-b-30">
                        <div class="input-group input-group-sm mb-3">
                            
                             Filtro de tipo de usuário 
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tipo de usuário</span>
                            </div>
                            <select name="typeuser" id="typeuser" style="margin-right: 20px">
                                <option value="" selected>Selecione</option>
                                <?php for($i = 2; $i < count($usersTypes); $i++){?>
                                <option value="<?= $usersTypes[$i]->type ?>"><?= $usersTypes[$i]->type ?></option>
                                <?php }?>
                            </select>

                             Filtro de planos 
                            <div class="input-group-prepend">
                                <span class="input-group-text">Planos</span>
                            </div>
                            <select name="plansuser" id="plansuser" style="margin-right: 20px">
                                <option value="" selected>Selecione</option>
                                <?php for($i = 0; $i < count($plans); $i++){?>
                                <option value="<?= $plans[$i]->title ?>"><?= $plans[$i]->title ?></option>
                                <?php }?>
                            </select>

                             Filtro de ativação de cadastro 
                            <div class="input-group-prepend">
                                <span class="input-group-text">Cadastro</span>
                            </div>
                            <select name="activeuser" id="activeuser">
                                <option value="" selected>Selecione</option>
                                <option value="1">Ativado</option>
                                <option value="0">Inativado</option>
                            </select>
                        </div>
                    </div> 
                </div> -->
                <hr>
                <div class="table-rep-plugin">
                    <div class="table-responsive b-0">
                        <table id="datatable_user_list" class="table table-hover">
                        
                        <!-- Cabeçalho da tabela -->
                            <thead>
                                <tr>
                                    <th class="align-middle">ID</th>
                                    <th class="align-left">Nome</th>
                                    <th>Tipo</th>
                                    <th>Plano</th>
                                    <th>Status do cadastro</th>
                                </tr>
                            </thead>

                            <!-- Corpo da tabela -->
                            <tbody>
                                <?php for($i=0; $i < count($users); $i++) {?>
                                    <tr>
                                        <td><?= $users[$i]->id ?></td>
                                        <td><?= $users[$i]->name ?></td>
                                        <td><?= ($users[$i]->users_types_id === '5') ? 'Cliente' : 'EmpresaTI' ?></td>
                                        <td><?= ($users[$i]->plan_id === '0') ? 'Free' : 'Pro' ?></td>
                                        <td><?= ($users[$i]->active === '1') ? 'Ativado' : 'Precisa ativar' ?></td>
                                    </tr>
                                <?php }?>
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
        $("#typeuser").change(()=>{
            var typeuser = $("#typeuser").val();
            console.log(typeuser);
        });
    });
</script>