
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
             <?= $this->Flash->render() ?>
             <?= $this->Form->create() ?>
              <h1>Login</h1>
              <div>
                <?= $this->Form->input('email', ['type' => 'text', 'class' => 'form-control', 'placeholder' => 'Email', 'label' => false]) ?>
              </div>
              <div>
                 <?= $this->Form->input('password', ['class' => 'form-control', 'placeholder' => 'Senha', 'label' => false]) ?>
              </div>
              <div>
                <?= $this->Form->submit('Entrar', ['class' => 'btn btn-default submit']) ?>
                <a class="reset_pass" href="#">Esqueceu sua senha?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Novo no site?
                  <a href="#signup" class="to_register"> Criar Conta</a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-bug"></i> CodeTop</h1>
                  <p>©2018. License LBL A.</p>
                </div>
              </div>
            <?= $this->Form->end() ?>
          </section>
        </div>
      </div>
    </div>