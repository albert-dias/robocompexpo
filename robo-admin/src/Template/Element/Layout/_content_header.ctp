<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title"><?= isset($title) ? $title : '$title' ?>
        </div>
        <div class="col-sm-6">
            <?php if (isset($breadcrumbs) && count($breadcrumbs) > 0): ?>
                <ol class="breadcrumb float-right">

                    <?php foreach ($breadcrumbs as $breadcrumb): ?>
                        <li class="breadcrumb-item"> <?= $this->Html->link($breadcrumb['label'], $breadcrumb['link']); ?></li>
                    <?php endforeach; ?>
                    <li class="breadcrumb-item active"><?= isset($actual) ? $actual : '$actual' ?></li>

                </ol>
            <?php else: ?> 
                <ol class="breadcrumb float-right">
                    <?= $this->Html->link('<i class="fa fa-plus"></i> '.$small_title, ['action' => 'add'], ['class' => 'float-right', 'escape' => false]) ?>
                </ol>                  
            <?php endif; ?> 
        </div>
    </div>
</div>