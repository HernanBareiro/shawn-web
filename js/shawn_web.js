$(document).ready(function() {
    $("#panel_desarrollo").show();
    $("#elfinder").focus();
    $("#tab_1").addClass("tab_selec");
    $("#tab_1 span").addClass("link_selec");
    $("#panel_control").hide();
    $("#salida_compilacion").hide();
    $("#salida_ejecucion").hide();
    
    $(document).ajaxStart(function(){
    $("#wait").css("display","block");    
    });
    
    $(document).ajaxComplete(function(){      
      $("#wait").css("display","none");
    });
    
})

function compilar()
{     
    var select_option_id = $('#compil_proy_simul option:selected').attr('id');   
    var proyecto_id = select_option_id.substr(select_option_id.indexOf("_") + 1);
    var url=('href',location.protocol + '//'+ window.location.host+
             '/modulos/simulacion/controlador/simulacion.class.php?compilar&proyecto_id='+proyecto_id);
    $.ajax({
	url: url,
        type: "get",
        cache: false,
        error: function(){alert ("Error al procesar la solicitud");},
        success: function(data){
        	$("#txa_copilar").empty().append(data);
		}
	});
}


function ejecutar_proyecto()
{ 
    var select_option_id='';
    var proyecto_id;
    select_option_id = $('#ejec_proy_simul option:selected').attr('id');   
    var proyecto_id = select_option_id.substr(select_option_id.indexOf("_") + 1);
    var nombre_arch_conf = $('#ejec_arch_conf').val();
    var url = ('href',location.protocol + '//'+ window.location.host+'/modulos/simulacion/controlador/simulacion.class.php?ejecutar&proyecto_id='+proyecto_id+'&nombre_arch_conf='+nombre_arch_conf);
    
    $.ajax({
	url: url,
        type: "get",
        cache: false,
        error: function(){alert ("Error al procesar la solicitud");},
        success: function(data){
        	$("#txa_ejecutar").empty().append(data);
		}
	});
}

function cargar_datos_modif_proy(proyecto_id)
{
    
    var url = ('href',location.protocol + '//'+ window.location.host+'/modulos/proyectos/controlador/proyectos.class.php?cargar-datos-proy&proyecto_id='+proyecto_id);       
            
    $.ajax({
	url: url,
        type: "get",
        dataType: 'json',
        cache: false,
        error: function(){alert ("Error al procesar la solicitud");},
        success: function(data){
        	$('#txt_nom_proy').val('');
                $('#txt_nom_proy').val(data.nombre);
                $('#txa_descrip').val('');
                $('#txa_descrip').val(data.descripcion);
                $('#txt_proyecto_id').val('');
                $('#txt_proyecto_id').val(proyecto_id);                
		}
	});
}

function confirma_eliminar_proyecto(proyecto_id)
{
    var url = ('href',location.protocol + '//'+ window.location.host+'/modulos/proyectos/controlador/proyectos.class.php?eliminar-proyecto&proyecto_id='+proyecto_id);
    var resultado = confirm("¿Confirma elminiar el proyecto?");
    if (resultado == true) {       
        $.ajax({
	url: url,
        type: "get",
        cache: false,
        error: function(){alert ("Error al procesar la solicitud");},
        success: function(data){
        	location.reload();
		}
	});
        
    } else {
        false;
    }
    
}

function cargarArchConf(dom_select_proy_id, dom_div_archivos_id, dom_select_archivo_conf_id)
{
    var select_option_id='';
    var proyecto_id;
    select_option_id = $('#'+dom_select_proy_id+' option:selected').attr('id');     
    var proyecto_id = select_option_id.substr(select_option_id.indexOf("_") + 1);    
    $('#proyecto_id_ejecucion').val(proyecto_id);
    var url = ('href',location.protocol + '//'+ window.location.host+'/modulos/simulacion/controlador/simulacion.class.php?cargar-archivo-conf&proyecto_id='+proyecto_id+'&dom_select_archivo_conf_id='+dom_select_archivo_conf_id);
    $.ajax({
	url: url,
        type: "get",
        cache: false,
        error: function(){alert ("Error al procesar la solicitud");},
        success: function(data){
        	
                $("#"+dom_div_archivos_id).empty().append(data);
                //carga url para visualizar pdf generados en la salida
                crearUrlVisualizacion(proyecto_id)
                $('#count').val('');
                $('#count_anterior').val('');
                
                $('#range').val('');
                $('#range_anterior').val('');
                
                $('#rect_world_width').val('');
                $('#rect_world_width_anterior').val('');
                
                $('#rect_world_height').val('');
                $('#rect_world_height_anterior').val('');
                
                $('#seed').val('');
                $('#seed_anterior').val('');
                
                $('#max_iterations').val('');
                $('#max_iterations_anterior').val('');
                
                $('#modelo_borde').attr("disabled","true");
                $('#modelo_borde').val('0');
                $('#modelo_borde_anterior').val('');                                
                
                $('#modelo_comunicacion').attr("disabled","true");
                $('#modelo_comunicacion').val('0');
                $('#modelo_comunicacion_anterior').val('');                
                
                $('#modelo_transmision').attr("disabled","true");
                $('#modelo_transmision').val('0');
                $('#modelo_transmision_anterior').val('');
                
		}
	});
    
}

function crearUrlVisualizacion(proyecto_id)
{
    
    var url_pdf = ('href',location.protocol + '//'+ window.location.host+'/modulos/simulacion/controlador/simulacion.class.php?visualizar-proyecto&proyecto_id='+proyecto_id);
    $('#link_salida_pdf').attr("href", url_pdf);       
}

function cargarParamArchConf()
{
    var select_option_id='';
    var proyecto_id;
    select_option_id = $('#control_proy_simul option:selected').attr('id');   
    var proyecto_id = select_option_id.substr(select_option_id.indexOf("_") + 1);
    var nombre_arch_conf = $('#control_archivo_conf').val();
    var url = ('href',location.protocol + '//'+ window.location.host+'/modulos/simulacion/controlador/simulacion.class.php?cargar-param-arch-conf&proyecto_id='+proyecto_id+'&nombre_arch_conf='+nombre_arch_conf);
    $.ajax({
	url: url,
        type: "get",
        dataType: 'json',
        cache: false,
        error: function(){alert ("Error al procesar la solicitud");},
        success: function(data){
        	$('#count').val('');
                $('#count').val(data.count);
                $('#count_anterior').val('');
                $('#count_anterior').val(data.count);
                
                $('#range').val('');
                $('#range').val(data.range);
                $('#range_anterior').val('');
                $('#range_anterior').val(data.range);
                
                $('#rect_world_width').val('');
                $('#rect_world_width').val(data.rect_world_width);
                $('#rect_world_width_anterior').val('');
                $('#rect_world_width_anterior').val(data.rect_world_width);
                
                $('#rect_world_height').val('');
                $('#rect_world_height').val(data.rect_world_height);
                $('#rect_world_height_anterior').val('');
                $('#rect_world_height_anterior').val(data.rect_world_height);
                
                $('#seed').val('');
                $('#seed').val(data.seed);
                $('#seed_anterior').val('');
                $('#seed_anterior').val(data.seed);
                
                $('#max_iterations').val('');
                $('#max_iterations').val(data.max_iterations);
                $('#max_iterations_anterior').val('');
                $('#max_iterations_anterior').val(data.max_iterations);
                
                $('#modelo_borde').removeAttr("disabled");
                $('#modelo_borde').val(data.edge_model);
                $('#modelo_borde_anterior').val('');                
                $('#modelo_borde_anterior').val(data.edge_model);
                
                $('#modelo_comunicacion').removeAttr("disabled");
                $('#modelo_comunicacion').val(data.comm_model);
                $('#modelo_comunicacion_anterior').val('');
                $('#modelo_comunicacion_anterior').val(data.comm_model);
                                 
                $('#modelo_transmision').removeAttr("disabled");
                $('#modelo_transmision').val(data.transm_model);
                $('#modelo_transmision_anterior').val('');
                $('#modelo_transmision_anterior').val(data.transm_model);                                                                                                                                                                              
                
		}
	});
    
    
}

function guardar_param_arch_conf()
{
    var select_option_id='';
    var proyecto_id;
    select_option_id = $('#control_proy_simul option:selected').attr('id');   
    var proyecto_id = select_option_id.substr(select_option_id.indexOf("_") + 1);
    var nombre_arch_conf = $('#control_archivo_conf').val();
    
    var count=$('#count').val();
    var count_anterior=$('#count_anterior').val();
    
    var range=$('#range').val();
    var range_anterior=$('#range_anterior').val();
        
    var rect_world_width=$('#rect_world_width').val();
    var rect_world_width_anterior=$('#rect_world_width_anterior').val();
    
    var rect_world_height=$('#rect_world_height').val();
    var rect_world_height_anterior=$('#rect_world_height_anterior').val();
    
    var seed=$('#seed').val();
    var seed_anterior=$('#seed_anterior').val();
    
    var max_iterations=$('#max_iterations').val();      
    var max_iterations_anterior=$('#max_iterations_anterior').val();      
    
    var edge_model=$('#modelo_borde').val();
    var edge_model_anterior=$('#modelo_borde_anterior').val();
    
    var comm_model=$('#modelo_comunicacion').val();
    var comm_model_anterior=$('#modelo_comunicacion_anterior').val();
    
    var transm_model=$('#modelo_transmision').val();
    var transm_model_anterior=$('#modelo_transmision_anterior').val();
    
    var url=('href',location.protocol + '//'+ window.location.host+
             '/modulos/simulacion/controlador/simulacion.class.php?guardar-param-arch-conf&proyecto_id='+proyecto_id+
             '&nombre_arch_conf='+nombre_arch_conf+"&count="+count+
             "&range="+range+"&rect_world_width="+rect_world_width+"&rect_world_height="+rect_world_height+
             "&seed="+seed+"&max_iterations="+max_iterations+"&count_anterior="+count_anterior+"&range_anterior="+range_anterior+
             "&rect_world_width_anterior="+rect_world_width_anterior+"&rect_world_height_anterior="+rect_world_height_anterior+
             "&seed_anterior="+seed_anterior+"&max_iterations_anterior="+max_iterations_anterior+
             "&edge_model="+edge_model+"&edge_model_anterior="+edge_model_anterior+
             "&comm_model="+comm_model+"&comm_model_anterior="+comm_model_anterior+
             "&transm_model="+transm_model+"&transm_model_anterior="+transm_model_anterior); 

    //alert (url);
     
     $.ajax({
	url: url,
        type: "get",
        dataType: 'json',
        cache: false,
        error: function(){alert ("Error al procesar la solicitud");},
        success: function(data){
                 if(data.resul==true){
                     alert('Parámetros guardados correctamente');
                     $('#count_anterior').val(count);
                     $('#range_anterior').val(range);
                     $('#rect_world_width_anterior').val(rect_world_width);
                     $('#rect_world_height_anterior').val(rect_world_height);
                     $('#seed_anterior').val(seed);
                     $('#max_iterations_anterior').val(max_iterations);
                     $('#modelo_borde_anterior').val(edge_model);
                     $('#modelo_comunicacion_anterior').val(comm_model);
                     $('#modelo_transmision_anterior').val(transm_model);
                     
                    }else{
                        alert("Error al guardar los parámetros");
                        cargarParamArchConf();
                    }
		}
	});
}
    

function visualizar(){
    
    var url = "../ver_pdf.php";   
            
    window.location.href = url;
    
}

function crear_proyecto()
{
    $(location).attr('href',location.protocol + '//'+ window.location.host+'/modulos/proyectos/vistas/crear_proyecto_simulacion.php');
    
}

function eliminar_proyecto()
{
    $(location).attr('href',location.protocol + '//'+ window.location.host+'/modulos/proyectos/vistas/eliminar_proyecto_simulacion.php');    
    
}

function modificar_proyecto()
{
    $(location).attr('href',location.protocol + '//'+ window.location.host+'/modulos/proyectos/vistas/modificar_proyecto_simulacion.php');    
}

function activar_tab(seccion_id, tab_id)
{
    var cantidad_tab = 4;
    
    $(".mostrar_ocultar").hide();
    $("#"+seccion_id).show();
    //$("#"+seccion_id).focus();
    
    for (i = 1; i <= cantidad_tab; i++) {
    $("#tab_"+i).removeClass("tab_selec");
    $("#tab_"+i+" span").removeClass("link_selec");
    }
    
    $("#"+tab_id).addClass("tab_selec");
    $("#"+tab_id+" span").addClass("link_selec");
    
}