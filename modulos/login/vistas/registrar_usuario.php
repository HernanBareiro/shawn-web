<?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'header.php'); ?>
</head>

<body>
    <header id="menu_cabecera"> 
        <h1 class="titulo_home_login"><a class="link_home" href=" <?php echo 'http://'.$_SERVER['SERVER_NAME'].'/modulos/login/vistas/iniciar_sesion.php'?> ">ShawnWEB</a><span> Simulaci&oacute;n de WSN Basada en la Web</span></h1>
    </header>
    <h2 class="titulo_home_login home_login_subtitulo2">Registro de Usuarios</h2>
    <h3 class="titulo_home_login home_login_subtitulo3">Complete el formulario para crear una cuenta de usuario e iniciar sesi&oacute;n</h3>    
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'mensajes_notificacion.php'); ?>
     <form action="/modulos/login/controlador/login.class.php" method="POST">
        <div class="lbls_login">
            <div class="lbl_parametro">
               <label>Nombre de Usuario*</label>
            </div>
            <div class="lbl_parametro">
               <label>E-mail*</label>
            </div>
            <div class="lbl_parametro">
               <label>Contrase&ntilde;a*</label>
            </div>
            <div class="lbl_parametro">
               <label>Repetir Contrase&ntilde;a*</label>
            </div>
            <div class="lbl_parametro">
               <label></label>
            </div>
        </div>
        <div class="inps_login">            
            <div class="txt_parametro" >
                <input type="text" name="nombre-usuario" value="" size="16" autofocus required>
            </div>  
            <div class="txt_parametro" >
                <input type="email" name="email" value="" size="22" required>
            </div> 
            <div class="txt_parametro" >
                 <input type="password" name="password" value="" required>
            </div>
            <div class="txt_parametro" >
               <input type="password" name="password-confirmar" value="" required>
            </div>
            <div class="txt_parametro" >
               <label>(*)Campos obligatorios</label>
            </div>
            <div class="txt_parametro" >
              <input type="submit" value="Crear Cuenta de Usuario" name="registrar-usuario" />
            </div>            
       </div>        
    </form>
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'footer.php'); ?>
</body>
</html>
    
    