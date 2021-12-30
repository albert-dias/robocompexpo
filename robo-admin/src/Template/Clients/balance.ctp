<?php
$general = [
    'label'       => 'Saldo em conta',
    'label_s'     => 'Editar saldo',
    'actual'      => 'Editar saldo',
    'breadcrumbs' => [
        [
            'label' => 'Saldo',
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
                <h4 class="mt-0 header-title">Editar saldo</h4>
                <p class="sub-title">Preencha o formulário e clique em salvar.</p>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div>  
                <?= $this->Form->create($client, ['type' => "file"]) ?>

                <div class="form-group row">
                    <label for="name-text-input" class="col-sm-2 col-form-label">Saldo R$<span class="required"></span></label>
                    <div class="col-sm-10">
                    <?= $this->Form->control('value', ['value' => $client->balance,'label' => false, 'class' => "form-control", 'type' => "numeric"]) ?>
                    </div>
                </div>

                <div class="form-group m-b-0">
                    <?= $this->Form->button(__('Salvar'), ['class' => "btn btn-primary waves-effect waves-light"]) ?>
                    <?= $this->Html->link('Cancelar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary waves-effect m-l-5']) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>           