<?php
session_start();
session_destroy();
header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/login/vistas/iniciar_sesion.php');
?>
