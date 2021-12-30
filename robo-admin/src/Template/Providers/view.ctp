<?php
$general = [
    'label'       => 'Prestadores',
    'label_s'     => 'Visualizar',
    'actual'      => 'visualizar prestador',
    'breadcrumbs' => [
        [
            'label' => 'Listar prestadores',
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
                <h4 class="mt-0 header-title">Visualizar prestador</h4>
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
                                    <td><?= $provider->id ?></td>
                                </tr>

                                <tr>
                                    <td>Nome</td>
                                    <td><?= $provider->person->name ?></td>
                                </tr>
                                <tr>
                                    <td>CPF</td>
                                    <td><?= $provider->person->cpf ?></td>
                                </tr>
                                <tr>
                                    <td>RG</td>
                                    <td><?= $provider->person->rg ?></td>
                                </tr>

                                <tr>
                                    <td>Instituição RG</td>
                                    <td><?= $provider->person->institution_rg ?></td>
                                </tr>

                                <tr>
                                    <td>Email</td>
                                    <td><?= $provider->person->email ?></td>
                                </tr>


                                <tr>
                                    <td>Telefone</td>
                                    <td><?= $provider->person->number_contact ?></td>
                                </tr>

                                <tr>
                                    <td>Endereço</td>
                                    <td><?= $provider->person->address ?></td>
                                </tr>

                                <tr>
                                    <td>Número</td>
                                    <td><?= $provider->person->number ?></td>
                                </tr>

                                <tr>
                                    <td>Bairro</td>
                                    <td><?= $provider->person->district ?></td>
                                </tr>

                                <tr>
                                    <td>Cidade</td>
                                    <td><?= $provider->person->city ?></td>
                                </tr>

                                <tr>
                                    <td>Estado</td>
                                    <td><?= $provider->person->state ?></td>
                                </tr>

                                <tr>
                                    <td>CEP</td>
                                    <td><?= $provider->person->cep ?></td>
                                </tr>

                                <td>Ativo?</td>
                                <td><?= $provider->active ? 'Sim' : 'Não' ?></td>
                                </tr>
                                <tr>
                                    <td>Vendedor ID</td>
                                    <td><?= $provider->seller_id ?></td>
                                </tr>
                                <tr>
                                    <td>Criado em</td>
                                    <td><?= $provider->created ?></td>
                                </tr>
                                <tr>
                                    <td>Modificado em</td>
                                    <td><?= $provider->modified ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="ln_solid"></div>
                        <div class="col-12">
                            <h5 class="m-t-20 m-b-30">Imagens</h5>
                            <div class="card-deck-wrapper">
                                <div class="card-deck">
                                    <?php foreach ($images as $value) : ?>
                                        <div class="card m-b-30">
                                            <img class="card-img-top img-fluid" src="<?= $value->url ?>" alt="<?= $value->type ?>">
                                            <div class="card-body">
                                                <h4 class="card-title font-16 mt-0"><?= $value->type ?></h4>
                                                <p class="card-text">
                                                    <small class="text-muted"><?= $value->created ?></small>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>



                        <div class="ln_solid"></div>
                        <br>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-0">

                                <?php if ($provider->active) : ?>
                                    <?= $this->Html->link('Desativar', ['action' => 'inactive', $provider->id], ['escape' => false, 'class' => 'btn btn-danger waves-effect waves-light']) ?>
                                <?php else : ?>
                                    <?= $this->Html->link('Ativar', ['action' => 'active', $provider->id], ['escape' => false, 'class' => 'btn btn-primary waves-effect waves-light']) ?>
                                <?php endif; ?>

                                <?= $this->Html->link('Voltar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary waves-effect m-l-5']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>