<?php
$general = [
    'label'       => 'Pagamento',
    'label_s'     => 'Visualizar',
    'actual'      => 'visualizar pagamento',
    'breadcrumbs' => [
        [
            'label' => 'Listar pagamentos',
            'link'  => ['action' => 'index']
        ]
    ]
];

$PAYS = [
    'cartao' => 'Cartão',
    'dinheiro' => 'Dinheiro',
    'boleto' => 'Boleto'
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
                <h4 class="mt-0 header-title">Visualizar pagamento</h4>
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
                                    <td>Ordem de serviço</td>
                                    <td><?= $payment->service_orders_id ?></td>
                                </tr>
                                <tr>                         
                                    <td>Ordem de serviço descrição</td>
                                    <td><?= $payment->service_order->description?></td>
                                </tr>
                                <tr>                         
                                    <td>Ordem de serviço categoria</td>
                                    <td><?= $payment->service_order->category->name ?></td>
                                </tr>
                                <tr>                         
                                    <td>Ordem de serviço subcategoria</td>
                                    <td><?= $payment->service_order->subcategory->name ?></td>
                                </tr>
                                <tr>                         
                                    <td>Ordem de serviço prestador</td>
                                    <td><?= $payment->service_order->provider->person->name ?> | <?= $payment->service_order->provider->person->cpf ?> </td>
                                </tr>
                                <tr>                         
                                    <td>Ordem de serviço cliente</td>
                                    <td><?= $payment->service_order->client->person->name ?> | <?= $payment->service_order->client->person->cpf ?> </td>
                                </tr>
                                <tr>                         
                                    <td>Tipo de pagamento</td>
                                    <td><?= $PAYS[$payment->type_payment]?></td>
                                </tr>
                                <tr>                         
                                <td>Data de pagamento</td>
                                    <td><?= $payment->date_pay ?></td>
                                </tr>                    
                                <tr>                         
                                <td>Valor do pagamento</td>
                                    <td><?= $payment->value ?></td>
                                </tr>
                                <td>Valor do prestador</td>
                                    <td><?= $payment->providers_value ?></td>
                                </tr>
                                <td>Valor transferido ao prestador</td>
                                    <td><?= $payment->providers_transfer ? 'Sim' : 'Não' ?></td>
                                </tr>                        
                            <tr>                         
                                <td>Criado em</td>
                                <td><?= $payment->created ?></td>
                            </tr>
                            <tr>                         
                                <td>Modificado em</td>
                                <td><?= $payment->modified ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-0">
                                <?= $this->Html->link('Editar', ['action' => 'edit', $payment->id], ['escape' => false, 'class' => 'btn btn-primary waves-effect waves-light']) ?>
                                <?= $this->Html->link('Cancelar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary waves-effect m-l-5']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>              
