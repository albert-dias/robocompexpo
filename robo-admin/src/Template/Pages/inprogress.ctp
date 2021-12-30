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
                <table id="table-rep-plugin" class="table table-hover">
                    <!-- Cabeçalho da tabela -->
                    <thead>
                        <tr>
                            <th class="align-left">ID</th>
                            <th>Serviço</th>
                            <th>Preço</th>
                            <th>Dia</th>
                            <th>Horário</th>
                        </tr>
                    </thead>

                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php for($i=0; $i < count($services); $i++) {?>
                            <tr>
                                <td><?= $services[$i]->id?></td>
                                <td><?= $services[$i]->service?></td>
                                <td><?= $services[$i]->price?></td>
                                <td><?= $services[$i]->dia?></td>
                                <td><?= $services[$i]->horario?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>