<?php 
//muestra mensajes de error en php
//ini_set('display_startup_errors',1);
//ini_set('display_errors',1);
//error_reporting(-1);
?>

<?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'header.php'); ?>
</head>

<body>
    <header id="menu_cabecera"> 
        <h1 class="titulo_home_login"><a class="link_home" href=" <?php echo 'http://'.$_SERVER['SERVER_NAME'].'/modulos/login/vistas/iniciar_sesion.php'?> ">ShawnWEB</a><span> Simulaci&oacute;n de WSN Basada en la Web</span></h1>
    </header>
    <h2 class="titulo_home_login home_login_subtitulo2">Formulario de Inicio de Sesi&oacute;n</h2>
    <h3 class="titulo_home_login home_login_subtitulo3">Complete el formulario con los datos para iniciar sesi&oacute;n o <a href=" <?php echo 'http://'.$_SERVER['SERVER_NAME'].'/modulos/login/vistas/registrar_usuario.php'?> ">puede crear una cuenta</a></h3>
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'mensajes_notificacion.php'); ?>
    <form action="/modulos/login/controlador/login.class.php" method="POST">
        <div class="lbls_login">
            <div class="lbl_parametro">
               <label>Nombre de Usuario</label>
            </div>                      
            <div class="lbl_parametro">
               <label>Contrase&ntilde;a</label>
            </div>
            <div class="lbl_parametro"></div>
        </div>
        <div class="inps_login">
            <div class="txt_parametro" >
                <input type="text" name="nombre-usuario" value="" size="12" autofocus required>
            </div>  
            <div class="txt_parametro" >
                <input type="password" name="password" value="" required>
            </div> 
            <div class="txt_parametro" >
                <input type="submit" value="Iniciar Sesi&oacute;n" name="iniciar-sesion" />
            </div>
        </div>
    </form>
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'footer.php'); ?>
</body>
</html>