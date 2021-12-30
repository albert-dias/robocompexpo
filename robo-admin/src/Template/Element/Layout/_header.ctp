        <div class="left_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?= $session['image'] ? $session['image'] : "/codetop/img/user.png" ?>" alt=""><?=$this->request->session()->read('Auth.User.name')?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li>
                        <?= $this->Html->link('Sair', ['controller' => 'Users', 'action' => 'logout','class' => 'fa fa-sign-out pull-right']) ?>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
