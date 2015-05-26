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
    <h2 class="titulo_home_login home_login_subtitulo2">Crear Proyecto de Simulaci&oacute;n</h2>
    <h3 class="titulo_home_login home_login_subtitulo3">Complete el formulario con los datos para crear un Proyecto de Simulaci&oacute;n</h3>    
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'mensajes_notificacion.php'); ?>
    <form action="/modulos/proyectos/controlador/proyectos.class.php" method="POST">
        
            <div class="lbls_login">
                <div class="lbl_parametro">
                    <label class="">Nombre del proyecto*</label>
                </div>
                <div class="lbl_parametro">
                    <label class="">Descripci&oacute;n</label>
                </div>
                <div class="lbl_parametro"></div>
                <div class="lbl_parametro"></div> 
            </div>
            <div class="inps_login">
                <div class="txt_parametro" >
                    <input type="text" name="nombre-proyecto" value="" size="15" autofocus required>
                </div>  
                <div class="txt_parametro" >
                    <textarea name="descripcion" rows="4" cols="20">
                    </textarea>
                </div>
                <div class="txt_parametro" >
                   <label class="">(*) Campos obligatorios</label>
                </div>
                <div class="txt_parametro" >
                    <input type="submit" value="Crear Proyecto" name="crear-proyecto" />
                </div>    
            </div>           
    </form>
<?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'footer.php'); ?>    
</body>
</html>
