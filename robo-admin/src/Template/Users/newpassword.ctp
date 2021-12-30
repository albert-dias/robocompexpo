<div class="card">
<?= $this->Form->create(null, ['type' => 'file', 'class'=> "form-horizontal m-t-30"]) ?>
        <div class="form-group">
            <div class="col-12">
                    <label>Email</label>
                <?= $this->Form->control('email', ['label'=>false,'class'=>"form-control", 'required'=>"required", 'type'=>"text", 'placeholder'=>"Digite o seu e-mail cadastrado"])?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-12">
                    <label>CPF/CNPJ</label>
                <?= $this->Form->control('cpf', ['label'=>false,'class'=>"form-control", 'required'=>"required", 'type'=>"text", 'placeholder'=>"digite o seu CPF cadastrado!"])?>
            </div>
        </div>

       
        <div class="form-group text-center m-t-20">
            <div class="col-12">
                 <?= $this->Form->button(__('Enviar'), ['class'=>"btn btn-primary btn-block btn-lg waves-effect waves-light",  "style"=>"background-color: #000000; border-color: #000000"]) ?>
            </div>
        </div>
        <div class="form-group text-center">
            <div class="col-12">
                 <?= $this->Html->link(__('Voltar'),['controller' => 'Users', 'action' => 'login'], ['class'=>"btn btn-outline-secondary waves-effect waves-light", "type"=>"button"]) ?>
            </div>
        </div>

        <div class="form-group row m-t-30 m-b-0">
<!--            <div class="col-sm-7">
                <a href="#" class="text-muted"><i class="fa fa-lock m-r-5"></i> Esqueceu sua senha?</a>
            </div>
            <div class="col-sm-5 text-right">
                <a href="#" class="text-muted">Criar nova conta</a>
            </div>-->
        </div>
<?= $this->Form->end() ?>

</div>

<script>
    $(document).ready(function(){
        $("#cpf").mask("99.999.999/9999-99");
        $("#cpf").keyup(function () {
            try {
                $("#cpf").unmask();
            } catch (e) {}
            var cpfcnpj = null;
            var tamanho = $("#cpf").val().length;
           
                if(tamanho === 14){
                    //Variavel com valor do campo CPF
                    var cpf= $(this).val();
                    cpfcnpj = cpf;
                    if(!validaCpfCnpj(cpfcnpj)){
                        $("#cpf").val('');
                        Swal.fire({
                            icon: 'error',
                            title: "esse CNPJ não é valido"
                        });
                    }
                    
                }
            $("#cpf").mask("99.999.999/9999-99");    
            // ajustando foco
            var elem = this;
            setTimeout(function(){
                // mudo a posição do seletor
                elem.selectionStart = elem.selectionEnd = 10000;
            }, 0);
            // reaplico o valor para mudar o foco
            var currentValue = $(this).val();
            $(this).val('');
            $(this).val(currentValue);
          })
        
    });
    function validaCpfCnpj(val) {
        if (val.length == 11) {
            var cpf = val.trim();
        
            cpf = cpf.replace(/\./g, '');
            cpf = cpf.replace('-', '');
            cpf = cpf.split('');
            
            var v1 = 0;
            var v2 = 0;
            var aux = false;
            
            for (var i = 1; cpf.length > i; i++) {
                if (cpf[i - 1] != cpf[i]) {
                    aux = true;   
                }
            } 
            
            if (aux == false) {
                return false; 
            } 
            
            for (var i = 0, p = 10; (cpf.length - 2) > i; i++, p--) {
                v1 += cpf[i] * p; 
            } 
            
            v1 = ((v1 * 10) % 11);
            
            if (v1 == 10) {
                v1 = 0; 
            }
            
            if (v1 != cpf[9]) {
                return false; 
            } 
            
            for (var i = 0, p = 11; (cpf.length - 1) > i; i++, p--) {
                v2 += cpf[i] * p; 
            } 
            
            v2 = ((v2 * 10) % 11);
            
            if (v2 == 10) {
                v2 = 0; 
            }
            
            if (v2 != cpf[10]) {
                return false; 
            } else {   
                return true; 
            }
        } else if (val.length == 14) {
            var cnpj = val.trim();
            
            cnpj = cnpj.replace(/\./g, '');
            cnpj = cnpj.replace('-', '');
            cnpj = cnpj.replace('/', ''); 
            cnpj = cnpj.split(''); 
            
            var v1 = 0;
            var v2 = 0;
            var aux = false;
            
            for (var i = 1; cnpj.length > i; i++) { 
                if (cnpj[i - 1] != cnpj[i]) {  
                    aux = true;   
                } 
            } 
            
            if (aux == false) {  
                return false; 
            }
            
            for (var i = 0, p1 = 5, p2 = 13; (cnpj.length - 2) > i; i++, p1--, p2--) {
                if (p1 >= 2) {  
                    v1 += cnpj[i] * p1;  
                } else {  
                    v1 += cnpj[i] * p2;  
                } 
            } 
            
            v1 = (v1 % 11);
            
            if (v1 < 2) { 
                v1 = 0; 
            } else { 
                v1 = (11 - v1); 
            } 
            
            if (v1 != cnpj[12]) {  
                return false; 
            } 
            
            for (var i = 0, p1 = 6, p2 = 14; (cnpj.length - 1) > i; i++, p1--, p2--) { 
                if (p1 >= 2) {  
                    v2 += cnpj[i] * p1;  
                } else {   
                    v2 += cnpj[i] * p2; 
                } 
            }
            
            v2 = (v2 % 11); 
            
            if (v2 < 2) {  
                v2 = 0;
            } else { 
                v2 = (11 - v2); 
            } 
            
            if (v2 != cnpj[13]) {   
                return false; 
            } else {  
                return true; 
            }
        } else {
            return false;
        }
 }
</script>