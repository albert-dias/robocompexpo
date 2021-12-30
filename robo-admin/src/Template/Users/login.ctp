<?= $this->Form->create(null, ['type' => 'file', 'class'=> "form-horizontal m-t-30"]) ?>
        <div class="form-group">
            <div class="col-12">
                    <label>CPF/CNPJ</label>
                <?= $this->Form->control('cpf', ['label'=>false,'class'=>"form-control", 'required'=>"required", 'type'=>"text", 'placeholder'=>"CPF/CNPJ"])?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-12">
                    <label>Senha</label>
                <?= $this->Form->control('password', ['label'=>false,'class'=>"form-control", 'required'=>"required", 'type'=>"password", 'placeholder'=>"Senha"])?>
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-12">
                <?= $this->Form->button(__('Entrar'), ['class'=>"btn btn-primary btn-block btn-lg waves-effect waves-light",  "style"=>"background-color: #000000; border-color: #000000"]) ?>
            </div>
        </div>
        <div class="form-group text-center">
            <div class="col-12">
                <?= $this->Html->link(__('Esqueci a senha'),['controller' => 'Users', 'action' => 'newpassword'], ['class'=>"btn btn-outline-secondary waves-effect waves-light", "type"=>"button"]) ?>
            </div>
        </div>
        <div class="form-group text-center">
            <div class="col-12">
                <?= $this->Html->link(__('Criar conta'),'/newuser', ['class'=>"btn btn-outline-secondary waves-effect waves-light", "type"=>"button"]) ?>
            </div>
        </div>
<?= $this->Form->end() ?>