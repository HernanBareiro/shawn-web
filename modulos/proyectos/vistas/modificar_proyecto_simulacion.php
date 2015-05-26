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
<h2 class="titulo_home_login home_login_subtitulo2">Modificar Proyecto de Simulaci&oacute;n</h2>    
<h3 class="titulo_home_login home_login_subtitulo3">Seleccione el proyecto que desea modificar y complete los datos del formulario</h3> 
<?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'mensajes_notificacion.php'); ?>
<div id="contenido_internas">
    <div id="tabla_interna">
        <table id="tablas">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descrpci&oacute;n</th>
                    <th>Fecha de Creaci&oacute;n</th>
                    <th>Acci&oacute;n</th>
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
                    <td><input type="button" value="Modificar" name="modificar" onClick="cargar_datos_modif_proy(<?php echo "'" . $proy->id . "'" ?>); return false;"/></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>  

    <div id="formulario_interna">
        <form action="/modulos/proyectos/controlador/proyectos.class.php" method="POST">    
                <div class="lbls_internas">
                    <div class="lbl_parametro">
                        <label>Nombre del proyecto*</label>
                    </div>
                    <div class="lbl_parametro">
                        <label>Descripci&oacute;n</label>
                    </div>
                    <div class="lbl_parametro"></div>
                    <div class="lbl_parametro"></div> 
                </div>
                <div class="inps_internas">
                    <div class="txt_parametro">
                        <input id="txt_nom_proy" type="text" name="nombre-proyecto" value="" size="15" autofocus required>
                        <input id="txt_proyecto_id" type="hidden" name="proyecto_id" value="">
                    </div>  
                    <div class="txt_parametro">
                        <textarea id="txa_descrip" name="descripcion" rows="4" cols="20">
                        </textarea>
                    </div>
                    <div class="txt_parametro">
                       <label class="">(*) Campos obligatorios</label>
                    </div>
                    <div class="txt_parametro">
                        <input type="submit" value="Modificar Proyecto" name="modificar-proyecto" />
                    </div>    
                </div>    
        </form>
    </div>     
</div>    
<?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'footer.php'); ?>    
</body>
</html>
