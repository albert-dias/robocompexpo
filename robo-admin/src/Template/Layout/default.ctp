<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?= $this->element('Layout/_head') ?>
    </head>
    <body>
        <?= $this->element('Layout/_menu') ?>
                 <div class="wrapper">
                    <div class="container-fluid">
                        <?= $this->fetch('content') ?>
                    </div>
                </div>
                <?= $this->element('Layout/_footer') ?>
        <?= $this->element('Layout/_scripts') ?>
    </body>
</html>