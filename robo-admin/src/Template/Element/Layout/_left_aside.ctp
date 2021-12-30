<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <?= $this->Html->link('<i class="fa fa-check"></i> <span>SNAD</span>', ['controller' => 'Pages'], ['escape' => false, 'class'=>'site_title']) ?>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?= $session['company']['image'] ? $session['company']['image'] : "/codetop/img/noimage.png" ?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Organização:</span>
                <h2><?= $session['company']['name'] ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Menu Geral</h3>
                <ul class="nav side-menu">
                    <li class="<?= $this->request->params['controller'] == 'Pages' ? 'active' : '' ?>">
                    <a>
                    <i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu" <?= $this->request->params['controller'] == 'Pages' ? 'style="display: block;"' : '' ?>>
                      <li><?=$this->Html->link('<i class="fa fa-bar-chart"></i> Início <span></span>', ['controller' => 'Pages'], ['escape' => false]) ?></li>
                    </ul>
                  </li>
                     <?php foreach ($this->request->session()->read('Config.menu') as $key => $module): ?>

                        <li class="<?= in_array($this->request->params['controller'], $module['controllers']) ? 'active' : '' ?>">
                            <a>
                                <i class="<?= $module['details']['class'] ?>"></i> <?= $key ?><span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu" <?= in_array($this->request->params['controller'], $module['controllers']) ? 'style="display: block;"' : '' ?>>
                                <?php foreach ($module['pages'] as $pages): ?>
                                    <li class="<?= $this->request->params['controller'] == $pages['controller'] ? 'active' : '' ?>">
                                        <?= $this->Html->link($pages['page'], ['controller' => $pages['controller'], 'action' => 'index'], ['escape' => false]) ?>
                                    </li> 
                                <?php endforeach; ?>    
                            </ul>                    
                        <?php endforeach; ?>

                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
<!--        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>-->
        <!-- /menu footer buttons -->
    </div>
</div>

