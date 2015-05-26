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
<?php

require ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'header_internas.php');
$proyectos=$usuario->listarProyectos($usuario);

    
?>
<h2 class="titulo_home_login home_login_subtitulo2">Eliminar Proyecto de Simulaci&oacute;n</h2>     
<h3 class="titulo_home_login home_login_subtitulo3">Seleccione el proyecto que desea eliminar</h3> 
<?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'mensajes_notificacion.php'); ?>
<div id="contenido_internas">
    <div id="tabla_interna">
        <table id="tablas">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descrpci&oacute;n</th>
                    <th>Fecha de Creaci&oacute;n</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proyectos as $proy ){ ?>
                <tr>
                    <td><?php echo $proy->nombre; ?></td>
                    <td><?php echo $proy->descripcion; ?></td>
                    <td>
                    <?php 
                    $unaFechaCreacion = new DateTime($proy->fechacreacion);
                    echo $unaFechaCreacion->format('d-m-Y H:i:s');
                    ?>
                    </td>
                    <td><input type="button" value="Eliminar" name="eliminar" onClick="confirma_eliminar_proyecto(<?php echo "'" . $proy->id . "'" ?>); return false;"/></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>   
</div>
<?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'footer.php'); ?>    
</body>
</html>