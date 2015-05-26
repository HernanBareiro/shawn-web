<?php 
//inicia la sesion
session_start();

if (($_SESSION['Usuario'] == null))
{
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/login/controlador/logout.class.php');
}
require ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'Usuario.class.php');

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="keywords" content="Redes de Sensores Remotos, Simulaci&oacute;n Basada en la Web, Simulador Shawn">
        <meta name="keywords" content="Wireless Sensor Networks, Web Based Simulation, Shawn Simulator">
        <meta name="description" content="Simulaci&oacute;n de WSN Basada en Web mediante la utilizaci&oacute;n de Shawn">
        <meta name="author" content="Bareiro, Santiago Hernan">
        <title>ShawnWeb - Simulaci&oacute;n de WSN Basada en la Web</title>
        
        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" media="screen" href="/css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" media="screen" href="/css/elfinder.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="/css/theme.css">
        <link rel="stylesheet" type="text/css" media="screen" href="/css/shawnweb.css">
        
        <!-- jQuery and jQuery UI (REQUIRED) -->
        <!-- jqueryui/1.8.18/themes/smoothness -->
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <!-- jquery/1.7.2 -->
        <script type="text/javascript" src="/js/jquery-ui.min.js"></script>
        <!-- jqueryui/1.8.18 -->
        <script type="text/javascript" src="/js/shawn_web.js"></script>
        <!-- elFinder JS (REQUIRED) -->
        <script type="text/javascript" src="/js/elfinder.min.js"></script>
        <!-- elFinder translation (OPTIONAL) -->
        <script type="text/javascript" src="/js/i18n/elfinder.es.js"></script>
        
        <?php 
        $usuario=unserialize($_SESSION['Usuario']); 
        ?>
       <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript">
                $().ready(function() {
                        var elf = $('#elfinder').elfinder({
                                url : '/php/connector.php',  // connector URL (REQUIRED)
                                customData: { usuario_id : "<?php echo $usuario->getId(); ?>" },
                                lang: 'es',             // language (OPTIONAL)
                                height: 370 
                        }).elfinder('instance');
                });
        </script>
    </head>
	<body>  
            <header id="menu_cabecera"> 
                <h1 class="titulo_home"><a class="link_home" href=" <?php echo 'http://'.$_SERVER['SERVER_NAME'].'/modulos/simulacion/vistas/simulacion_wsn.php'?> ">ShawnWEB</a><span> Simulaci&oacute;n de WSN Basada en la Web</span></h1>
                <nav>
                    <ul>
                      <li><a href="/about">Ayuda</a>
                        <ul>
                            <li><a href="https://github.com/itm/shawn">Shawn Wiki</a></li>
                            <li><a href="http://shawn.sourceforge.net/doc/api/">Shawn API</a></li>
                            <li><a href="/papers">Shawn Papers</a></li>
                        </ul>
                      </li>
                      <li><a href="/about">
                          <?php echo($usuario->getNombre()); ?>                          
                          </a>
                        <ul>
                            <li><a href="/modulos/usuarios/vistas/modificar_datos_perfil.php">Modificar Perfil</a></li>
                            <li><a href="/modulos/login/controlador/logout.class.php">Salir</a></li>                            
                        </ul>
                      </li>
                    </ul>
                </nav> 
            </header>
            <header>
                <ul class="link_tab">
                    <li class="" id="tab_1" onClick="activar_tab('panel_desarrollo', 'tab_1'); return false;">
                        <span>Gesti&oacute;n de archivos</span>
                    </li>
                    <li class="" id="tab_2" onClick="activar_tab('panel_control', 'tab_2'); return false;">
                        <span>Control de Simulaci&oacute;n</span>
                    </li>
                    <li class="" id="tab_3" onClick="activar_tab('salida_compilacion', 'tab_3'); return false;">
                        <span>Compilaci&oacute;n</span>
                    </li>
                    <li class="" id="tab_4" onClick="activar_tab('salida_ejecucion', 'tab_4'); return false;">
                        <span>Ejecuci&oacute;n</span>
                    </li>
                </ul>   
            </header>
            <article id="panel_desarrollo" class="mostrar_ocultar">
                <section id="arbol_archivos">
                    <header>
                         <h3>&Aacute;rbol de gesti&oacute;n archivos de Proyectos de Simulac&iacute;on</h3>
                         <div class="botones_accion">
                             <input type="button" value="Crear Proyecto" name="crear_proyecto" onClick="crear_proyecto(); return false;"/> 
                             <input type="button" value="Modificar Proyecto" name="modificar_proyecto" onClick="modificar_proyecto(); return false;"/> 
                             <input type="button" value="Eliminar Proyecto" name="eliminar_proyecto" onClick="eliminar_proyecto(); return false;"/> 
                         </div>
                    </header>
                    <!-- Element where elFinder will be created (REQUIRED) -->
                    <div id="elfinder"></div>
                    <footer>
                        <div class="btn_mover_tab">
                            <input type="button" value="Siguiente" name="siguiente" onClick="activar_tab('panel_control', 'tab_2'); return false;"/>                            
                        </div>                        
                    </footer>
                </section>
            </article>
            <article id="panel_control" class="mostrar_ocultar">
                <section id="control">
                    <h3>Par&aacute;metros de Control de Simulaci&oacute;n</h3>
                    <div class="botones_accion">
                             <input type="button" value="Guardar" name="guardar_control" onClick="guardar_param_arch_conf(); return false;"/> 
                    </div>
                    <div class="btn_control">
                        <div class="lbls">
                            <div class="lbl_parametro">
                                <label class="">Proyecto de Simulaci&oacute;n</label>
                            </div>
                            <div class="lbl_parametro">
                                <label class="">Archivo de configuraci&oacute;n</label>
                            </div>
                            <div class="lbl_parametro">
                                <label>count:</label>
                            </div>
                            <div class="lbl_parametro">
                                <label>range:</label>
                            </div>
                            <div class="lbl_parametro">
                                <label>width:</label>
                            </div>
                            <div class="lbl_parametro">
                                <label>height:</label>
                            </div>
                            <div class="lbl_parametro">
                                <label>seed:</label>
                            </div>
                            <div class="lbl_parametro">
                                <label>max iterations:</label>
                            </div>
                            <div class="lbl_parametro">
                                <label>Modelo de Borde:</label>
                            </div>
                            <div class="lbl_parametro">
                                <label>Modelo de Comunicaci&oacute;n:</label>
                            </div>
                            <div class="lbl_parametro">
                                <label>Modelo de Transmisi&oacute;n:</label>
                            </div>                            
                        </div>
                        <div class="inps">
                            <div class="txt_parametro" >
                                <select id="control_proy_simul" onChange="cargarArchConf('control_proy_simul', 'archivos_conf_div', 'control_archivo_conf'); return false;">
                                    <option selected disabled>Seleccione un Proyecto</option>
                                    <?php $proyectos=$usuario->listarProyectos($usuario); ?>
                                    <?php foreach ($proyectos as $proy) { ?>
                                    <option id="controlproy_<?php echo $proy->id ?>"><?php echo $proy->nombre ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div id="archivos_conf_div" class="txt_parametro" >
                                <span>-</span>
                            </div>    
                            
                            <div class="txt_parametro">                            
                                <input type="text" id="count" value="" size="15" />
                                <input type="text" id="count_anterior" />                               
                            </div>
                            <div class="txt_parametro">
                                <input type="text" id="range" value="" size="15" />                        
                                <input type="text" id="range_anterior"/>
                            </div>
                            <div class="txt_parametro">
                                <input type="text" id="rect_world_width" value="" size="10" />
                                <input type="text" id="rect_world_width_anterior" />
                            </div>
                            <div class="txt_parametro">
                                <input type="text" id="rect_world_height" value="" size="10" />
                                <input type="text" id="rect_world_height_anterior" />
                            </div>
                            <div class="txt_parametro">
                                <input type="text" id="seed" value="" size="20" />
                                <input type="text" id="seed_anterior" />
                            </div>    
                            <div class="txt_parametro">
                                <input type="text" id="max_iterations" value="" size="15" />
                                <input type="text" id="max_iterations_anterior" />
                            </div>
                            <div class="txt_parametro" >
                                <select id="modelo_borde" disabled="disabled">
                                    <option value="0" selected disabled>Seleccione un Modelo de Borde</option> 
                                    <option value="simple">simple</option>                                    
                                    <option value="list">list</option>
                                    <option value="grid">grid</option>
                                    <option value="fast_list">fast_list</option>                                    
                                </select>
                                <input type="text" id="modelo_borde_anterior"/>
                            </div>
                             <div class="txt_parametro" >
                                <select id="modelo_comunicacion" disabled="disabled">
                                    <option value="0" selected disabled>Seleccione un Modelo de Comunicaci&oacute;n</option> 
                                    <option value="disk_graph">Unit Disk Graph (UDG)</option>                                    
                                    <option value="rim">Radio Irregularity Model (RIM)</option> 
                                    <option value="qudg">Unit Disk Graph (Q-UDG)</option> 
                                    <option value="stochastic">Stochastic</option> 
                                    
                                </select>
                                <input type="text" id="modelo_comunicacion_anterior"/> 
                            </div>
                            <div class="txt_parametro" >
                                <select id="modelo_transmision" disabled="disabled">
                                    <option value="0" selected disabled>Seleccione un Modelo de Transmi&oacute;n</option>                                     
                                    <option value="csma">Csma</option>
                                    <option value="zigbee_csma">Zigbee Csma</option> 
                                    <option value="maca">Maca</option>  
                                    <option value="random_drop">Random Drop</option>
                                    <option value="aloha">Aloha</option>
                                    <option value="slotted_aloha">Slotted Aloha</option>
                                    <option value="traces">Traces</option>
                                    
                                </select>
                                <input type="text" id="modelo_transmision_anterior"/>
                            </div> 
                        </div>    
                    </div>
                    <footer>
                        <div class="btn_mover_tab">
                            <input type="button" value="Anterior" name="anterior" onClick="activar_tab('panel_desarrollo', 'tab_1'); return false;"/>
                            <input type="button" value="Siguiente" name="siguiente" onClick="activar_tab('salida_compilacion', 'tab_3'); return false;"/>                            
                        </div>                        
                    </footer>                    
                </section>
            </article>
            
             <article id="salida_compilacion" class="mostrar_ocultar">
                <section id="compilacion">
                    <header>
                        <h3>Salida de compilaci&oacute;n</h3>
                        <div class="botones_accion">   
                            <select id="compil_proy_simul">                            
                                <option selected disabled>Seleccione un Proyecto</option>
                                <?php foreach ($proyectos as $proy) { ?>
                                    <option id="compilproy_<?php echo $proy->id ?>"><?php echo $proy->nombre ?></option>
                                <?php } ?>
                            </select>                      
                            <input type="button" value="Compilar" name="compilar" onClick="compilar(); return false;"/>                             
                        </div>
                    </header>
                    <textarea id="txa_copilar" rows="23" placeholder="Resultado de la compilaci&oacute;n"></textarea>                                    
                </section>
                <footer>
                    <div class="btn_mover_tab">
                        <input type="button" value="Anterior" name="crear_proyecto" onClick="activar_tab('panel_control', 'tab_2'); return false;"/>                          
                        <input type="button" value="Siguiente" name="siguiente" onClick="activar_tab('salida_ejecucion', 'tab_4'); return false;"/>
                    </div>                        
                </footer>
            </article>
            
            <article id="salida_ejecucion" class="mostrar_ocultar">                
                <section id="ejecucion">
                    <header>    
                        <h3>Salida de ejecuci&oacute;n</h3>
                        <div class="botones_accion">
                            <form action="/modulos/simulacion/controlador/simulacion.class.php" method="GET">
                            <select id="ejec_proy_simul" onChange="cargarArchConf('ejec_proy_simul', 'ejec_span_arch_conf', 'ejec_arch_conf'); return false;">
                                <option selected disabled>Seleccione un Proyecto</option>
                                <?php foreach ($proyectos as $proy) { ?>
                                    <option id="ejecproy_<?php echo $proy->id ?>"><?php echo $proy->nombre ?></option>
                                <?php } ?>
                            </select>
                            <span id="ejec_span_arch_conf"> </span>
                            <input type="button" value="Ejecutar" name="ejecutar" onClick="ejecutar_proyecto(); return false;"/>
                                                        
                                <input id="proyecto_id_ejecucion" type="hidden" value="" name="proyecto_id" />
                                <input type="submit" value="Descargar" name="descargar-proyecto" />                                 
                                <a id="link_salida_pdf" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/modulos/simulacion/controlador/simulacion.class.php" target="_blank">Visualizar</a>                                
                            </form>
                        </div>
                    </header>
                    <textarea id="txa_ejecutar" rows="23" placeholder="Resultado de la simulaci&oacute;n"></textarea>  
                </section>
                <footer>
                    <div class="btn_mover_tab">
                        <input type="button" value="Anterior" name="crear_proyecto" onClick="activar_tab('salida_compilacion', 'tab_3'); return false;"/>                          
                    </div>                        
                </footer>
            </article>
            
            <?php require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'footer.php'); ?>
                    
        </body>
</html>