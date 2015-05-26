<?php
//inicia la sesion
session_start();
if (($_SESSION['Usuario'] == null))
{
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/login/controlador/logout.class.php');
}
require ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'Usuario.class.php');
$usuario=  unserialize($_SESSION['Usuario']);
?>

<?php 
require ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'header.php');
?>
</head>

<body>
<?php require ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'header_internas.php'); ?>
    <h2 class="titulo_home_login home_login_subtitulo2">Modificaci&oacute;n de Datos de Perfil</h2>
    <h3 class="titulo_home_login home_login_subtitulo3">Complete el formulario para modifcar los datos del perfil</h3>    
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'mensajes_notificacion.php'); ?>
    <form action="/modulos/usuarios/controlador/usuarios.class.php" method="POST">
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
            </div>
            <div class="lbl_parametro">                
            </div>
        </div>     
        <div class="inps_login">
            <div class="txt_parametro" >
                <input type="text" name="nombre-usuario" value="<?php echo $usuario->getNombre(); ?>" size="16" autofocus required>
            </div>
            <div class="txt_parametro" >
                 <input type="email" name="email" value="<?php echo $usuario->getEmail(); ?>" size="22" required>
            </div>
            <div class="txt_parametro" >
                <input type="password" name="password" value="" required>
            </div>
            <div class="txt_parametro" >
                <input type="password" name="password-confirmar" value="" required>
            </div>
            <div class="txt_parametro" >
                <label>(*) Campos obligatorios</label>
            </div>    
            <div class="txt_parametro" >
                <input type="submit" value="Modificar datos de perfil" name="modificar-usuario" />
            </div>
        </div>                
    </form>
<?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'footer.php'); ?>    
</body>
</html>
