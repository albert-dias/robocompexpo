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
            <hr>
            <div class="table-rep-plugin">
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