<?php
$general = [
    'label'       => 'Clientes',
    'label_s'     => 'Visualizar',
    'actual'      => 'visualizar cliente',
    'breadcrumbs' => [
        [
            'label' => 'Listar clientes',
            'link'  => ['action' => 'index']
        ]
    ]
];

echo $this->element('Layout/_content_header', [
    'title'       => $general['label'],
    'small_title' => $general['label_s'],
    'actual'      => $general['actual'],
    'breadcrumbs' => $general['breadcrumbs'],
]);
?>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Visualizar cliente</h4>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div>
                <div class="x_content">
                    <br />
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
                                    <td>ID</td>
                                    <td><?= $client->id ?></td>
                                </tr>

                                <tr>
                                    <td>Nome</td>
                                    <td><?= $client->person->name ?></td>
                                </tr>
                                <tr>
                                    <td>CPF</td>
                                    <td><?= $client->person->cpf ?></td>
                                </tr>
                                <tr>
                                    <td>RG</td>
                                    <td><?= $client->person->rg ?></td>
                                </tr>

                                <tr>
                                    <td>Instituição RG</td>
                                    <td><?= $client->person->institution_rg ?></td>
                                </tr>

                                <tr>
                                    <td>Email</td>
                                    <td><?= $client->person->email ?></td>
                                </tr>


                                <tr>
                                    <td>Telefone</td>
                                    <td><?= $client->person->number_contact ?></td>
                                </tr>

                                <tr>
                                    <td>Endereço</td>
                                    <td><?= $client->person->address ?></td>
                                </tr>

                                <tr>
                                    <td>Número</td>
                                    <td><?= $client->person->number ?></td>
                                </tr>

                                <tr>
                                    <td>Bairro</td>
                                    <td><?= $client->person->district ?></td>
                                </tr>

                                <tr>
                                    <td>Cidade</td>
                                    <td><?= $client->person->city ?></td>
                                </tr>

                                <tr>
                                    <td>Estado</td>
                                    <td><?= $client->person->state ?></td>
                                </tr>

                                <tr>
                                    <td>CEP</td>
                                    <td><?= $client->person->cep ?></td>
                                </tr>

                                <td>Ativo?</td>
                                <td><?= $client->active ? 'Sim' : 'Não' ?></td>
                                </tr>
                                <tr>
                                    <td>Token</td>
                                    <td><?= $client->person->billabong ?></td>
                                </tr>
                                <tr>
                                    <td>Criado em</td>
                                    <td><?= $client->created ?></td>
                                </tr>
                                <tr>
                                    <td>Modificado em</td>
                                    <td><?= $client->modified ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-0">
                                 <?= $this->Html->link('Voltar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary waves-effect m-l-5']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>