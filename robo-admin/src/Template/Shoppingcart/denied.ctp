<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h4>Serviços Negados</h4>
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
                            <th class="align-left">ID do carrinho</th>
                            <th>Cliente</th>
                            <th>Técnico</th>
                            <th>Serviço</th>
                            <th>Preço</th>
                            <th>Dia do Serviço</th>
                            <th>Horário</th>
                            <th>Status do Técnico</th>
                            <th>Status do Cliente</th>
                        </tr>
                    </thead>

                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php for($i=0; $i < count($denied); $i++) { ?>
                            <tr>
                                <td><?= $denied[$i]->id?></td>
                                <td><?= $denied[$i]->id_cart?></td>
                                <td><?= $cliente[$i]?></td>
                                <td><?= $tecnico[$i]?></td>
                                <td><?= $denied[$i]->service?></td>
                                <td><?= $denied[$i]->price?></td>
                                <td><?= $horario[$i]?></td>
                                <td class="text-danger"><?= $denied[$i]->status?></td>
                                <td><?= $denied[$i]->status_cliente?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>