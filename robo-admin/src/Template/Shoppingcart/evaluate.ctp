<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h4>Serviços Avaliados</h4>
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
                            <td class="align-left">ID do carrinho</td>
                            <td>Cliente</td>
                            <td>Técnico</td>
                            <td>Serviço</td>
                            <td>Preço</td>
                            <td>Dia marcado</td>
                            <td>Horário</td>
                            <td>Status do técnico</td>
                            <td>Status do cliente</td>
                            <td>Avaliação do técnico</td>
                            <td>Avaliação do cliente</td>
                        </tr>
                    </thead>

                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php for($i=0; $i< count($evaluate); $i++) {?>
                            <tr>
                                <td><?= $evaluate[$i]->id_cart?></td>
                                <td><?= $cliente[$i]?></td>
                                <td><?= $tecnico[$i]?></td>
                                <td><?= $evaluate[$i]->service?></td>
                                <td><b>R$</b><?= $evaluate[$i]->price?></td>
                                <td><?= $horario[$i]?></td>
                                <td><?= $evaluate[$i]->horario?></td>

                                <?php if($evaluate[$i]->status === 'avaliado') {?>
                                    <td><?= $evaluate[$i]->status?></td>
                                <?php } else if($evaluate[$i]->status === 'finalizado') {?>
                                    <td class="text-warning"><?= $evaluate[$i]->status?></td>
                                <?php } else{?>
                                    <td class="text-danger"><?= $evaluate[$i]->status?></td>
                                <?php }?>

                                <?php if ($evaluate[$i]->status_cliente === 'avaliado') {?>
                                    <td><?= $evaluate[$i]->status_cliente?></td>
                                <?php } else if ($evaluate[$i]->status_cliente === 'avaliado') {?>
                                    <td class="text-warning"><?= $evaluate[$i]->status_cliente?></td>
                                <?php } else{?>
                                    <td class="text-danger"><?= $evaluate[$i]->status_cliente?></td>
                                <?php }?>
                                
                                <td><?= $evaluate[$i]->avaliation?></td>
                                <td><?= $evaluate[$i]->avaliation_client?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>