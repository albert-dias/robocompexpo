<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h4>Serviços em Andamento</h4>
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
                            <th>Dia marcado</th>
                            <th>Horário</th>
                            <th>Status do técnico</th>
                            <th>Status do cliente</th>
                            <!-- <th>Avaliação do Técnico</th> -->
                            <!-- <th>Avaliação do Cliente</th> -->
                        </tr>
                    </thead>

                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php for($i=0; $i < count($ongoing); $i++) {?>
                            <tr>
                                <!-- <td><?= $ongoing[$i]->id?></td> -->
                                <td><?= $ongoing[$i]->id_cart?></td>
                                <td><?= $cliente[$i]?></td>
                                <td><?= $tecnico[$i]?></td>
                                <td><?= $ongoing[$i]->service?></td>
                                <td><b>R$</b><?= $ongoing[$i]->price?></td>
                                <td><?= $horario[$i]?></td>
                                <td><?= $ongoing[$i]->horario?></td>
                                <td><?= $ongoing[$i]->status?></td>
                                <td><?= $ongoing[$i]->status_cliente?></td>
                                <!-- <td><?= $ongoing[$i]->avaliation?></td> -->
                                <!-- <td><?= $ongoing[$i]->avaliation_client?></td> -->
                            </tr>
                        <?php }?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>