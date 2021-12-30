<?php
    $user = $this->request->session()->read('Auth.User');
?>

<div/>

<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">VISUALIZAR DADOS DO PERFIL</h4>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Campo</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Nome</td>
                                    <td><?= $user['name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Apelido</td>
                                    <td><?= $user['nickname'] ?></td>
                                </tr>
                                <tr>
                                    <td>CPF/CNPJ</td>
                                    <td><?= '***' . substr($cpf, -3)?></td>
                                </tr>
                                <!-- <tr>
                                    <td>RG</td>
                                    <td>***</td>
                                </tr>
                                <tr>
                                    <td>Instituto RG</td>
                                    <td></td>
                                </tr> -->
                                <?php if($tipo !== 6){?>
                                    <tr>
                                        <td>Data de Nascimento</td>
                                        <td><?= $data ?></td>
                                    </tr>
                                <?php }?>
                                <tr>
                                    <td>E-mail</td>
                                    <td><?= $user['email']?></td>
                                </tr>
                                <tr>
                                    <td>Número</td>
                                    <td><?= $number ?></td>
                                </tr>
                                <tr>
                                    <td>CEP</td>
                                    <td><?= $cep?></td>
                                </tr>
                                <tr>
                                    <td>Rua</td>
                                    <td><?= $rua?></td>
                                </tr>
                                <tr>
                                    <td>Número</td>
                                    <td><?= $numero?></td>
                                </tr>
                                <tr>
                                    <td>Bairro</td>
                                    <td><?= $bairro?></td>
                                </tr>
                                <tr>
                                    <td>Cidade</td>
                                    <td><?= $cidade?></td>
                                </tr>
                                <tr>
                                    <td>Estado</td>
                                    <td><?= $estado?></td>
                                </tr>
                                <tr>
                                    <td>Gênero</td>
                                    <td><?= $gender?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>