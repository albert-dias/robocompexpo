<style>
    .grandient{
            background: rgb(18,119,143);
            background: linear-gradient(90deg, rgba(18,119,143,1) 8%, rgba(40,45,65,1) 63%);
            opacity: 0.7;
            
        }
    @media only screen and (max-width: 600px) {
        .grandient{
            margin-left: 0rem!important;
            
        }
        #card-1{
            display: contents !important;
        }
        
    }
    .grandient h2{
        color:white;
    }
    .grandient:hover{
        opacity: 1;
    }

</style>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4>Quem é você? </h4>
                <br>
                <div id="card-1" class="row col-12 d-flex justify-content-center">
                    <div class="col-xl-4 p-0 col-12" id="cliente" onclick="mudar(this)">
                        <div class="p-5 ml-4 border bg-light text-center grandient" style="border-radius:10px">
                            <h2 class="typetext" for="i1"><i class="fas fa-user"></i> Cliente</h2>
                        </div>
                    </div>
                    <div class="col-xl-4 p-0 col-12" id="tecnico" onclick="mudar(this)">
                        <div class="p-5 ml-4 border bg-light text-center grandient" style="border-radius:10px">
                            <h2 class="typetext" for="i1"><i class="fas fa-laptop"></i> Empresa de TI</h2>
                        </div>
                    </div>
                    <!-- <div class="col-xl-4 p-0 col-12" id="cliente" onclick="mudar(this)" >
                        <div class="p-5 ml-4 border bg-light text-center grandient" style="border-radius:10px;">
                            <h2 class="typetext" for="i1"><i class="fas fa-user"></i> cliente de Resíduo</h2>
                        </div>
                    </div> -->
                    <!-- <div  class="col-xl-4 p-0 col-12" id="coletor" onclick="mudar(this)">
                        <div class="ml-4 border bg-light text-center grandient" style="border-radius:10px;padding: 4rem!important;">
                            <h2 class="typetext" for="i2"><i class="fas fa-recycle"></i> Coletor</h2>
                        </div>
                    </div> -->
                    <!-- <div  class="col-xl-4 p-0 col-12" id="reciclador" onclick="mudar(this)">
                        <div class="ml-4 border bg-light text-center grandient" style="border-radius:10px;padding: 4rem!important;">
                            <h2 class="typetext" for="i2"><i class="fas fa-recycle"></i> Reciclador</h2>
                        </div>
                    </div> -->
                </div>
                <div class="row col-12 d-flex justify-content-center">
                    <div class="col-xl-4 p-0 col-12" >
                        <div class="p-3  text-center ">
                            <img src="<?=$this->request->getAttribute('webroot')?>webroot/assets/images/coletor.png" alt="">
                            <h4>Cliente</h4>
                            <ul class="text-center">
                                <li>Encontre técnicos em sua Região</li>
                                <!-- <li>Doar e ajudar catadores a ganha com seus Resíduos</li> -->
                                <br>
                                <li>Pesquise pelo melhor preço</li>
                                <!-- <li>Apoie a Sustentabilidade</li> -->
                                <br>
                                <li>Colabore com o pequeno empresário</li>
                                <!-- <li>Ganhe dinheiro com seus Resíduos</li> -->
                                <br>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 p-0 col-12" >
                        <div class="p-3  text-center ">
                            <img src="<?=$this->request->getAttribute('webroot')?>webroot/assets/images/robo130.png" alt="">
                            <h4>Empresa de TI</h4>
                            <ul>
                                <li>Ofereça seus serviços através da plataforma</li>
                                <!-- <li>Encontre coletas em sua Região</li> -->
                                <br>
                                <li>Crie seu próprio horário de trabalho</li>
                                <!-- <li>Acessa a resíduos de diversos tipos</li> -->
                                <br>
                                <li>Faça sucesso através do seu próprio esforço</li>
                                <!-- <li>Colabore com a Sustentabilidade</li> -->
                                <br>
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="col-xl-4 p-0 col-12" >
                        <div class="p-3  text-center ">
                            <img src="<?=$this->request->getAttribute('webroot')?>webroot/assets/images/reciclador.png" alt="">
                            <h4>Reciclador</h4>
                            <ul>
                                <li>Encontre resíduos automaticamente</li>
                                <br>
                                <li>Aprimore sua Logística</li>
                                <br>
                                <li>Aprimore sua Gestão</li>
                                <br>
                                <li>Colabore com a Sustentabilidade</li>
                                <br>
                            </ul>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function mudar(who){
    if($(who).attr("id") == "cliente"){
        $(who).children().css("opacity",1)
        $(who).children().css("box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $(who).children().css("-webkit-box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $(who).children().css("-moz-box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $("#vender").children().css("opacity",0.7)
        $("#vender").children().css("box-shadow","none")
        window.open('<?=$this->request->getAttribute('base')?>/newuser/cliente',"_self")
    }
    if($(who).attr("id") == "tecnico" || $(who).attr("id") == "tecnico"){
        $(who).children().css("opacity",1)
        $(who).children().css("box-shadow"," 0px 0px 17px 0px rgba(50, 170, 57, 1)")
        $("#doar").children().css("opacity",0.7)
        $("#doar").children().css("box-shadow","none")
        window.open('<?=$this->request->getAttribute('base')?>/newuser/tecnico',"_self")
    }
}
</script>