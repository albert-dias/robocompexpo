<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h4>Serviços Finalizados</h4>
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
                        </tr>
                    </thead>

                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php for($i=0; $i< count($finished); $i++) {?>
                            <tr>
                                <td><?= $finished[$i]->id_cart?></td>
                                <td><?= $cliente[$i]?></td>
                                <td><?= $tecnico[$i]?></td>
                                <td><?= $finished[$i]->service?></td>
                                <td><b>R$</b><?= $finished[$i]->price?></td>
                                <td><?= $horario[$i]?></td>
                                <td><?= $finished[$i]->horario?></td>

                                <?php if($finished[$i]->status === 'finalizado') {?>
                                    <td><?= $finished[$i]->status?></td>
                                <?php } else if($finished[$i]->status === 'aceito') {?>
                                    <td class="text-danger"><?= $finished[$i]->status?></td>
                                <?php } else{?>
                                    <td class="text-success"><?= $finished[$i]->status?></td>
                                <?php }?>

                                <?php if ($finished[$i]->status_cliente === 'finalizado') {?>
                                    <td><?= $finished[$i]->status_cliente?></td>
                                <?php } else if ($finished[$i]->status_cliente === 'aceito') {?>
                                    <td class="text-danger"><?= $finished[$i]->status_cliente?></td>
                                <?php } else{?>
                                    <td class="text-success"><?= $finished[$i]->status_cliente?></td>
                                <?php }?>
                                
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>