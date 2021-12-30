<?php
$general = [
    'label'       => 'Ranking de Prestadores',
    'label_s'     => 'Ranking',
    'actual'      => 'Ranking',
    'breadcrumbs' => [
        [
            'label' => 'Ranking de Prestadores',
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
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?= $this->Flash->render() ?>
    </div>
</div>  
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Ranking de prestadores</h4>
                <hr>
                <?= $this->Form->create(null, ['type' => 'post']) ?>
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-xl-4 m-b-30">
                        <?= $this->Form->control('date_start_search_orders', ['label' => false, 'placeholder' => "Data Inicial", 'class' => "form-control", 'type' => "text", "autocomplete"=>"off"]) ?>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-4 m-b-30">
                        <?= $this->Form->control('date_end_search_orders', ['label' => false, 'placeholder' => "Data Fim", 'class' => "form-control", 'type' => "text", "autocomplete"=>"off"]) ?>
                    </div>
                    <div class="col-sm-3 col-md-2 col-xl-2 m-b-30">
                        <?= $this->Form->button(__('<i class="fa fa-search"></i> Filtrar'), ['class' => "btn btn-info btn-block"]) ?>
                    </div>
                    <div class="col-sm-3 col-md-2 col-xl-2 m-b-30">
                        <?= $this->Html->link('Limpar', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-secondary btn-block']) ?>
                    </div>
                </div>
                <hr>
                <?= $this->Form->end(); ?>
                <div class="table-rep-plugin">
                    <div class="table-responsive b-0" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table  table-striped">
                       <thead>
                        <tr>                            
                            <th data-priority="1">ID</th>
                            <th data-priority="1">Prestador</th>
                            <th data-priority="1">Quantidade</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($providers as $provider): ?>
                              <tr>
                                  <td><?= $provider->providers_id ?></td>
                                  <td><?= $provider->name ?></td>
                                  <td><?= $provider->count ?></td>
                              </tr>
                          <?php endforeach; ?>

                      </tbody>

                    </table>
                  </div>
                 </div>
                    
                    <div class="box-footer clearfix">

                    </div>
                  </div>
                </div>
              </div>
            </div>