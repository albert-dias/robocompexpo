<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?= $this->element('Layout/_head') ?>
    </head>
     <body>

        <!-- Begin page -->
        <div class="accountbg">
            <div class="home-btn d-none d-sm-block">
                    
            </div>
            <div class="wrapper-page">
                    <div class="card card-pages shadow-none">
        
                        <div class="card-body">
                            <div class="text-center m-t-0 m-b-15">
                                    <a href="/" class="logo logo-admin"><?php echo $this->Html->image('/assets/images/logo.png', ['width' => '160']); ?></a>
                            </div>
                            <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?= $this->Flash->render() ?>
                        </div>
                    </div>  
                            <h5 class="font-18 text-center">RoboComp - Área Administrativa</h5>
        
                            <?= $this->fetch('content') ?>
                        </div>
        
                    </div>
                </div>

            <?= $this->element('Layout/_scripts') ?>
        </div>
    </body>
</html>
