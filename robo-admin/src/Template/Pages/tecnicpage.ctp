<?php
    $user = $this->request->session()->read('Auth.User');
?>

<div/>

<div class="row">
    <div class="col-sm-6 col-xl-3">
        <a style="cursor: pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/pages/inprogress" target="_blanck">
            <div class="card">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="fas fa-history bg-primary text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Em Andamento:</h5>
                    </div>
                    <div class="progress mt-4" style="height:4px;"></div>
                    <p class="mt-2 mb-0">
                        Número de serviços: <span class="font-weight-bolder"><?=$count_status->andamento?></span>
                    </p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a style="cursor: pointer;" onclick="modalCollection(this)" src="<?=$this->request->getAttribute('base')?>/pages/finished" target="_blanck">
            <div class="card">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="fas fa-th-list bg-primary text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Serviços Finalizados:</h5>
                    </div>
                    <h3 class="mt-4"><?=$ativos?></h3>
                    <div class="progress mt-4" style="height:4px;"></div>
                    <p class="mt-2 mb-0">
                        Número de serviços: <span class="font-weight-bolder"><?=$count_status->finish?></span>
                    </p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Configurações da tela do modal -->
<div class="modal fade text-left" id="modalcolletion" tabindex="-1" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header  white" style="background: #156875;">
                <h4 style="text-align:center;width: 100%;" class="modal-title" id="modallabel">
                    <?=$this->Html->link(
						$this->Html->image('https://grupoecomp.corpstek.com.br/robo-admin/webroot/assets/images/logo.png', [
							'class'=>'brand-logo',
							'width'=>'250px'
						]),
                        "#",
						['class'=> 'navbar-brand','escape'=>false])?>
                    <br>
                    <span style="font-size:18px; color:white">
                        <?php
                            $empresas = $session['company'];
                            echo $empresas['name'];
                        ?>
                    </span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">
					<i class="fa fa-times"></i> Sair
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Redireciona o modal que foi clicado para abrir -->
<script>
    function modalCollection(who){
        $('.modal-body').html('<div style="text-align: center"><i class="fa fa-refresh fa-spin" /></div>');

        $('#modalcolletion').modal('show').find('.modal-body').load($(who).attr('src'), function(responseText, textStatus, req){
            if(textStatus == "error") {
                alert('Sua consulta retornou um número muito grande de registros. Tente um período menor.');
                $('a[data-dismiss="modal"]').click();
            }
        });
        $('#loading').hide();

        $('button[data-dismiss="modal"]').on('click', function(e){
            $('.modal-body').html("");
        });
    }
</script>