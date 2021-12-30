<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h4>Serviços em Espera</h4>
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
                            <!-- <th class="align-middle">ID</th> -->
                            <th class="align-left">ID do carrinho</th>
                            <th>Cliente</th>
                            <th>Técnico</th>
                            <th>Serviço</th>
                            <th>Preço</th>
                            <th>Dia do Serviço</th>
                            <th>Horário</th>
                            <th>Status do técnico</th>
                            <th>Status do cliente</th>
                        </tr>
                    </thead>

                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php for($i=0; $i < count($waiting); $i++) {?>
                            <tr>
                                <!-- <td><?= $waiting[$i]->id?></td> -->
                                <td><?= $waiting[$i]->id_cart?></td>
                                <td><?= $cliente[$i]?></td>
                                <td><?= $tecnico[$i]?></td>
                                <td><?= $waiting[$i]->service?></td>
                                <td><b>R$</b><?= $waiting[$i]->price?></td>
                                <td><?= $horario[$i]?></td>
                                <td><?= $waiting[$i]->horario?></td>
                                <td class="text-warning"><?= $waiting[$i]->status?></td>
                                <td><?= $waiting[$i]->status_cliente?></td>
                                <!-- <td><?= $waiting[$i]->workday?></td> -->
                                <!-- <td><?= $waiting[$i]->avaliation?></td> -->
                                <!-- <td><?= $waiting[$i]->avaliation_client?></td> -->
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>