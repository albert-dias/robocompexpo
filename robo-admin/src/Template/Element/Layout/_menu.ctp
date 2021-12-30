<?php 
if(!($this->request->params['controller'] == "Users" && in_array($this->request->params['action'],array("newpassword","newuser","termopriv","addcliente","addtecnico")))){?>
<div class="header-bg">
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">

                    <!-- Logo-->
                    <div>
                    <?=$this->Html->link('<span class="logo-light">'.$this->Html->image('/assets/images/logo.png', ['alt' => 'logo', 'width="120"']).'</span>', ['controller' => 'Pages', 'action' => 'redirecttype'], ['escape' => false, 'class'=>"logo"]) ?>
<!--                        <a href="index.html" class="logo">
                            <span class="logo-light">
                                    <i class="mdi mdi-camera-control"></i> <?= $session['company']['name'] ?>
                            </span>
                        </a>-->
                    </div>
                    
<!--                    <a href="/nv2019/pages"><span class="logo-light"><i class="mdi mdi-camera-control"></i>NDS</span></a>-->
                    
                    <!-- End Logo-->

                    <div class="menu-extras topbar-custom navbar p-0">
                        <ul class="navbar-right ml-auto list-inline float-right mb-0">
                            <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                                <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                                    <i id="buttonFullScreen" class="mdi mdi-arrow-expand-all noti-icon"></i>
                                </a>
                            </li>
                            

                            <li class="dropdown notification-list list-inline-item d-md-inline-block" >
                                <div class="dropdown notification-list nav-pro-img"  >
                                    <a class="dropdown-toggle nav-link arrow-none nav-user" id="menu-dropdown" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                                       
                                    <span class="fa-layers fa-fw">
                                            <i class="far fa-bell fa-lg"></i>
                                            <span id="count-notification" class="fa-layers-counter" style="padding: 2px;text-align: center;">0</span>
                                        </span>
                                    </a>
                                    <div style="width: max-content;right: -141%;" id="notifications" class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="menu-dropdown">
                                        <!-- item-->
                                        <a id="inicial" class="dropdown-item text-center" href="#"><i class="fas fa-spinner fa-spin"></i></a>
                                        
                                        
                                        <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-wallet"></i> Carteira</a> -->
                                        <!-- <a class="dropdown-item d-block" href="#"> Configurações</a> -->
                                        <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline"></i> Lock screen</a> -->
                                        

<!--                                        <a class="dropdown-item text-danger" href="#"><i class="mdi mdi-power text-danger"></i> Logout</a>-->
                                    </div>
                                </div>
                            </li>
                            <audio id="song-notification">
                                <source src="<?=$this->request->getAttribute('webroot')?>/webroot/assets/songs/notification.ogg" type="audio/ogg">
                                <source src="<?=$this->request->getAttribute('webroot')?>/webroot/assets/songs/notification.mp3" type="audio/mpeg">
                                <source src="<?=$this->request->getAttribute('webroot')?>/webroot/assets/songs/notification.m4r" type="audio/m4r">
                                Your browser does not support the audio element.
                            </audio>
                            <input id="csrfToken" type="hidden" value="<?= $this->request->getParam('_csrfToken') ?>">
                                        <script>
                                        var count = null;
                                            $(document).ready(function (e) {
                                                
                                                var last_id = null;
                                                $.ajax({
                                                    url:"<?=$this->request->getAttribute('base')?>/notification/all.json"
                                                    ,type:"POST"
                                                    ,headers: {
                                                        'X-XSRF-TOKEN': $("#csrfToken").val()
                                    
                                                    },beforeSend: function (xhr) {
                                                        xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
                                                    }
                                                    ,data:{
                                                        "_csrfToken": getCookie("_ga"),
                                                        "_method":"POST"
                                                    }
                                                    ,dataType: 'json'
                                                    ,async: false

                                                }).done(function (data) {
                                                     
                                                    if(data.notification.length != 0){

                                                        $("#notifications").html("");
                                                        data.notification.map(function (no) {
                                                            
                                                            no.created = new Date(no.created);
                                                            last_id = no.id
                                                            if(no.is_read){
                                                                $("#notifications").prepend(`
                                                                <a onclick="openLink(this)" style="opacity:0.5;" notification="`+no.id+`" class="p-0 dropdown-item text-center" href="#" src="<?=$this->request->getAttribute('base')?>/`+no.link+`">
                                                                    <div  class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                                                                        <div class="toast-header">
                                                                            <span class="mb-1"></span>
                                                                            <strong class="mr-auto" id="title">`+no.title+`</strong>
                                                                            <small class="ml-1" id="time">`+no.created.toLocaleDateString('en-GB',{  day: 'numeric', month: 'numeric',hour:"2-digit",minute:"2-digit"})+`</small>
                            
                                                                        </div>
                                                                        <div id="post" class="toast-body col-12 text-truncate">
                                                                            `+no.post+`
                                                                        </div>
                                                                    </div>
                                                                </a>`);
                                                            }else{
                                                                count++;
                                                                $("#notifications").prepend(`
                                                                <a onclick="openLink(this)" notification="`+no.id+`" class="p-0 dropdown-item text-center" href="#" src="<?=$this->request->getAttribute('base')?>/`+no.link+`">
                                                                    <div  class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                                                                        <div class="toast-header">
                                                                            <span class="mb-1"><i class="fa fa-circle" style="color:yellow" aria-hidden="true"></i></span>
                                                                            <strong class="mr-auto" id="title">`+no.title+`</strong>
                                                                            <small class="ml-1" id="time">`+no.created.toLocaleDateString('en-GB',{  day: 'numeric', month: 'numeric',hour:"2-digit",minute:"2-digit"})+`</small>
                            
                                                                        </div>
                                                                        <div id="post" class="toast-body col-12 text-truncate">
                                                                            `+no.post+`
                                                                        </div>
                                                                    </div>
                                                                </a>`);
                                                                $("#count-notification").html(count)
                                                                
                                                            }
                                                        })
                                                    }else{
                                                        $("#notifications").html("");
                                                        $("#notifications").prepend(`
                                                                
                                                                    <div id="not-notification"  class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                                                                        <div class="toast-header">
                                                                            
                                                                            <strong class="mr-auto" id="title">Sem notificação</strong>
                                                                            <small class="ml-1" id="time"></small>
                            
                                                                        </div>
                                                                        <div id="post" class="toast-body col-12 text-truncate">
                                                                            
                                                                        </div>
                                                                    </div>
                                                                `);
                                                    }
                                                }).fail(function (xhr,textStatus,error) {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Oops...',
                                                        text: xhr.statusText
                                                    });
                                                })
                        

                                                setInterval(() => {
                                                    $.ajax({
                                                        url:"<?=$this->request->getAttribute('base')?>/notification/.json"
                                                        ,type:"POST"
                                                        ,headers: {
                                                            'X-XSRF-TOKEN': $("#csrfToken").val()
                                        
                                                        },beforeSend: function (xhr) {
                                                            xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
                                                        }
                                                        ,data:{
                                                            "_csrfToken": getCookie("_ga"),
                                                            "_method":"POST",
                                                            "last_id":last_id
                                                        }
                                                        ,dataType: 'json'
                                                        ,async: false

                                                    }).done(function (data) {
                                                        
                                                        data.notification.map(function (no) {
                                                            $("#not-notification").hide();
                                                            
                                                            no.created = new Date(no.created);
                                                           if(no.id > 0){
                                                            last_id = no.id
                                                           }
                                                            if(no.is_read){
                                                                $("#notifications").prepend(`
                                                                <a onclick="openLink(this)" style="opacity:0.5;" notification="`+no.id+`" class="p-0 dropdown-item text-center" href="#" src="<?=$this->request->getAttribute('base')?>/`+no.link+`">
                                                                    <div  class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                                                                        <div class="toast-header">
                                                                            <span class="mb-1"><i class="fa fa-circle" style="color:yellow" aria-hidden="true"></i></span>
                                                                            <strong class="mr-auto" id="title">`+no.title+`</strong>
                                                                            <small class="ml-1" id="time">`+no.created.toLocaleDateString('en-GB',{  day: 'numeric', month: 'numeric',hour:"2-digit",minute:"2-digit"})+`</small>
                            
                                                                        </div>
                                                                        <div id="post" class="toast-body col-12 text-truncate">
                                                                            `+no.post+`
                                                                        </div>
                                                                    </div>
                                                                </a>`);
                                                            }else{
                                                                count++
                                                                
                                                                $("#notifications").prepend(`
                                                                <a onclick="openLink(this)" notification="`+no.id+`" class="p-0 dropdown-item text-center" href="#" src="<?=$this->request->getAttribute('base')?>/`+no.link+`">
                                                                    <div  class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                                                                        <div class="toast-header">
                                                                            <span class="mb-1"><i class="fa fa-circle" style="color:yellow" aria-hidden="true"></i></span>
                                                                            <strong class="mr-auto" id="title">`+no.title+`</strong>
                                                                            <small class="ml-1" id="time">`+no.created.toLocaleDateString('en-GB',{  day: 'numeric', month: 'numeric',hour:"2-digit",minute:"2-digit"})+`</small>
                            
                                                                        </div>
                                                                        <div id="post" class="toast-body col-12 text-truncate">
                                                                            `+no.post+`
                                                                        </div>
                                                                    </div>
                                                                </a>`);
                                                                $("#count-notification").html(count)
                                                                var song = document.getElementById("song-notification");
                                                                song.play();
                                                            }

                                                        })
                                                        
                                                    }).fail(async function (jqXHR, textStatus, errorThrown ) {
                                                        if(jqXHR.status == 500){
                                                            await  Swal.fire(
                                                            'Sessão expirada',
                                                            'click no botão para volta para login',
                                                            'error'
                                                            )
                                                            window.location.href = "<?=$this->request->getAttribute('base')?>/users/login"
                                                        }
                                                    })
                                                }, 10000);
                                                $("#notifications a").click(function (e) {
                                                    
                                                    
                                                })
                                            })
                                            
                                            function openLink(who) {
                                                var notification = who;
                                                    var id = $(notification).attr("notification")
                                                    var link = $(notification).attr("src")
                                                    $.ajax({
                                                        url:"<?=$this->request->getAttribute('base')?>/notification/read"
                                                        ,type:"POST"
                                                        ,headers: {
                                                            'X-XSRF-TOKEN': $("#csrfToken").val()
                                        
                                                        },beforeSend: function (xhr) {
                                                            xhr.setRequestHeader('X-CSRF-Token', $("#csrfToken").val());
                                                        }
                                                        ,data:{
                                                            "_csrfToken": getCookie("_ga"),
                                                            "_method":"POST",
                                                            "id":id
                                                        }
                                                        ,dataType: 'json'
                                                        ,async: true

                                                    }).done(function (data) {
                                                        window.open(link,"_self")
                                                    }).fail(function (xhr,textStatus,error) {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Oops...',
                                                            text: xhr.statusText
                                                        });
                                                    })
                                            }

                                            function getCookie(cname) {
                                                var name = cname + "=";
                                                var decodedCookie = decodeURIComponent(document.cookie);
                                                var ca = decodedCookie.split(';');
                                                for(var i = 0; i <ca.length; i++) {
                                                    var c = ca[i];
                                                    while (c.charAt(0) == ' ') {
                                                    c = c.substring(1);
                                                    }
                                                    if (c.indexOf(name) == 0) {
                                                    return c.substring(name.length, c.length);
                                                    }
                                                }
                                                return "";
                                            }
                                        </script>
                            <li class="dropdown notification-list list-inline-item">
                            
                                <div class="dropdown notification-list nav-pro-img">
                                    <a class="dropdown-toggle nav-link arrow-none nav-user" id="notification-button" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                                        <!-- <img src="<?= $session['image'] ? $session['image'] : "/codetop/img/user.png" ?>" alt="" class="rounded-circle"> --><?php if(strlen($this->request->session()->read('Auth.User.name')) > 8){echo substr($this->request->session()->read('Auth.User.name'),0,9)."...";}else{ echo $this->request->session()->read('Auth.User.name');}?>  
                                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="menu-dropdown">
                                        <!-- item-->
                                        <a class="dropdown-item" href="<?=$this->request->getAttribute("base")?>/pages/users/<?=$this->request->session()->read('Auth.User.id')?>"><i class="mdi mdi-account-circle"></i> Perfil</a>
                                       
                                        <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-wallet"></i> Carteira</a> -->
                                        <!-- <a class="dropdown-item d-block" href="#"> Configurações</a> -->
                                        <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline"></i> Lock screen</a> -->
                                        <div class="dropdown-divider"></div>
                                         <?= $this->Html->link('<i class="mdi mdi-power text-danger"></i> Sair', ['controller' => 'Users', 'action' => 'logout'], ['escape'=>false,'class' => 'dropdown-item text-danger']) ?>

<!--                                        <a class="dropdown-item text-danger" href="#"><i class="mdi mdi-power text-danger"></i> Logout</a>-->
                                    </div>
                                </div>
                            </li>

                            <li class="menu-item dropdown notification-list mb-1 list-inline-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>

                        </ul>

                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div>
                <!-- end container -->
            </div>
            <!-- end topbar-main -->

            <!-- MENU Start -->
            <div class="navbar-custom">
                <div class="container-fluid">

                    <div id="navigation" style="top: 99%;">

                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <!-- Menu Inicial -->
                            <li class="has-submenu">
                                <?=$this->Html->link('<i class="icon-accelerator"></i>Início',
                                 ['controller' => 'Pages','action' => 'redirecttype'], ['escape' => false]) ?>
                            </li>
                            <li class="has-submenu">
                                <?=$this->Html->link('<i class="fas fa-user"></i>Perfil',
                                 ['controller' => 'Pages','action' => 'users'], ['escape' => false]) ?>
                            </li>
                            
                            <!-- Menu de usuários -->
                            
                            <!-- <li> -->
                                <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="fas fa-users-cog"></i>Usuários</a> -->
                                <!-- <ul class="dropdown-menu"> -->
                                    <!-- Submenu de clientes -->
                                    <!-- <li id="submenu" class="fas fa-users"></li><a href="#">Clientes</a> -->
                                    <!-- <br/> -->
                                    <!-- Submenu de técnicos/empresas -->
                                    <!-- <li id="submenu" class="fas fa-wrench"></li><a href="#">Técnicos</a> -->
                                <!-- </ul> -->
                            <!-- </li> -->
                            <!-- Menu de relatórios -->
                            <!-- <li class="has-submenu"> -->
                                <!-- <?=$this->Html->link('<i class="fas fa-file-alt"></i>Relatórios', ['controller' => 'Pages','action' => 'reports'], ['escape' => false]) ?> -->
                            <!-- </li> -->
                            <!-- Menu de TI -->
                            <!-- <li class="has-submenu"> -->
                                <!-- <?=$this->Html->link('<i class="fas fa-bug"></i>TI', ['controller' => 'Pages','action' => 'support'], ['escape' => false]) ?> -->
                            <!-- </li> -->
                            </li>
                        </ul>
                        <!-- End navigation menu -->
                    </div>
                    <!-- end #navigation -->
                </div>
                <!-- end container -->
            </div>
            <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->

    </div>
<?php }else{?>
    <div class="header-bg">
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">

                    <!-- Logo-->
                    <div>
                    <?=$this->Html->link('<span class="logo-light">'.$this->Html->image('/assets/images/logo.png', ['alt' => 'logo', 'width="120"']).'</span>', ['controller' => 'Pages'], ['escape' => false, 'class'=>"logo"]) ?>
<!--                        <a href="index.html" class="logo">
                            <span class="logo-light">
                                    <i class="mdi mdi-camera-control"></i> <?= $session['company']['name'] ?>
                            </span>
                        </a>-->
                    </div>
                    
<!--                    <a href="/nv2019/pages"><span class="logo-light"><i class="mdi mdi-camera-control"></i>NDS</span></a>-->
                    
                    <!-- End Logo-->

                    


                        </ul>

                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div>
                <!-- end container -->
            </div>
            <!-- end topbar-main -->

<?php }?>
<style>
    #submenu {
        padding: 10px;
    }
</style>
<script>
    $aux_option = false
    $("#buttonFullScreen").click(function(e) {
        if($aux_option){
            $("#buttonFullScreen").removeClass('mdi mdi-arrow-collapse-all').addClass('mdi mdi-arrow-expand-all');
            $aux_option = false;
        }
        else{
            $("#buttonFullScreen").removeClass('mdi mdi-arrow-expand-all').addClass('mdi mdi-arrow-collapse-all');
            $aux_option = true;
        }
    })
</script>