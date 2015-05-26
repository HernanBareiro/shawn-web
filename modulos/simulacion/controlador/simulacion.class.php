<?php
//mantiene la sesion para obtener los datos del usuario
session_start();

//muestra mensajes de error en php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

//instancia el controlador
$simulacion=new simulacion();

if (isset($_GET["cargar-archivo-conf"]))
{
    $proyecto_id=$_GET["proyecto_id"];    
    $dom_select_archivo_conf_id=$_GET["dom_select_archivo_conf_id"];
    $simulacion->obtenerArchivosConf($proyecto_id, $dom_select_archivo_conf_id);    

} else if(isset($_GET["cargar-param-arch-conf"])){
    $nombre_arch_conf=$_GET["nombre_arch_conf"];
    $proyecto_id=$_GET["proyecto_id"];
    $simulacion->cargarParamArchConf($proyecto_id, $nombre_arch_conf);
    
} else if(isset($_GET["guardar-param-arch-conf"])){
   
    $nombre_arch_conf=$_GET["nombre_arch_conf"];
    $proyecto_id=$_GET["proyecto_id"];
    
    $count=$_GET["count"];
    $count_anterior=$_GET["count_anterior"];
    
    $range=$_GET["range"];
    $range_anterior=$_GET["range_anterior"];
    
    $rect_world_width=$_GET["rect_world_width"];
    $rect_world_width_anterior=$_GET["rect_world_width_anterior"];
    
    $rect_world_height=$_GET["rect_world_height"];
    $rect_world_height_anterior=$_GET["rect_world_height_anterior"];
    
    $seed=$_GET["seed"];
    $seed_anterior=$_GET["seed_anterior"];
    
    $max_iterations=$_GET["max_iterations"];
    $max_iterations_anterior=$_GET["max_iterations_anterior"];
    
    $edge_model=$_GET["edge_model"];
    $edge_model_anterior=$_GET["edge_model_anterior"];
    
    $comm_model=$_GET["comm_model"];
    $comm_model_anterior=$_GET["comm_model_anterior"];
            
    $transm_model=$_GET["transm_model"];
    $transm_model_anterior=$_GET["transm_model_anterior"];        
            
    $simulacion->guardarParamArchConf($proyecto_id, $nombre_arch_conf,
            $count,$range,$rect_world_width,$rect_world_height,
            $seed,$max_iterations,$count_anterior,$range_anterior,$rect_world_width_anterior,
            $rect_world_height_anterior,$seed_anterior,$max_iterations_anterior, $edge_model, $edge_model_anterior,
            $comm_model, $comm_model_anterior, $transm_model, $transm_model_anterior);
    
} else if(isset($_GET["compilar"])){
    $proyecto_id=$_GET["proyecto_id"];
    $simulacion->compilarProyecto($proyecto_id); 
} else if(isset($_GET["ejecutar"])){
    $proyecto_id=$_GET["proyecto_id"];
    $nombre_arch_conf=$_GET["nombre_arch_conf"];
    $simulacion->ejecutarProyecto($proyecto_id,$nombre_arch_conf);
} else if(isset($_GET["descargar-proyecto"])){
    $proyecto_id=$_GET["proyecto_id"];
    $simulacion->descargarProyecto($proyecto_id);        
} else if(isset($_GET["visualizar-proyecto"])){
    $proyecto_id=$_GET["proyecto_id"];
    $simulacion->visualizarProyecto($proyecto_id);        
}
class simulacion
{
    public function compilarProyecto($proyecto_id)
    {
        
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'SalidaSimulacion.class.php');   
        $salida_simulacion=new SalidaSimulacion();
        $salida_simulacion->compilarProyecto($proyecto_id);
        
    }
    
    public function ejecutarProyecto($proyecto_id, $nombre_arch_conf)
    {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'SalidaSimulacion.class.php');   
        $salida_simulacion=new SalidaSimulacion();
        $salida_simulacion->ejecutarProyecto($proyecto_id, $nombre_arch_conf);
        
    }


    public function obtenerArchivosConf($proyecto_id, $dom_select_archivo_conf_id)
    {
     $nombres_archivos_conf=array();
     require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'ControlSimulacion.class.php');   
     $control_simulacion=new ControlSimulacion();
     $nombres_archivos_conf=$control_simulacion->obtenerArchivosConf($proyecto_id);    
     $select_option='<select id="'.$dom_select_archivo_conf_id.'" onChange="cargarParamArchConf(); return false;">
                        <option selected disabled>Seleccione un Archivo</option>';
     foreach ($nombres_archivos_conf as $nombre_archivo){
         $select_option.='<option>'.$nombre_archivo.'</option>';
     }       
            
     $select_option.='</select>';
     echo $select_option;     
    }
    
    public function cargarParamArchConf($proyecto_id, $nombre_arch_conf)
    {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'ControlSimulacion.class.php');   
        $control_simulacion=new ControlSimulacion();
        $parametros_control=$control_simulacion->obtenerParamArchivoConf($proyecto_id, $nombre_arch_conf);        
        echo json_encode($parametros_control);                 
    }
    
    public function guardarParamArchConf($proyecto_id, $nombre_arch_conf,
            $count,$range,$rect_world_width,$rect_world_height,
            $seed,$max_iterations,$count_anterior,$range_anterior,$rect_world_width_anterior,
            $rect_world_height_anterior,$seed_anterior,$max_iterations_anterior, $edge_model, $edge_model_anterior,
            $comm_model, $comm_model_anterior, $transm_model, $transm_model_anterior)
    {
        $resul=false;
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'ControlSimulacion.class.php');   
        $control_simulacion=new ControlSimulacion();
        $resul=$control_simulacion->guardarParamArchConf($proyecto_id, $nombre_arch_conf,
            $count,$range,$rect_world_width,$rect_world_height,
            $seed,$max_iterations,$count_anterior,$range_anterior,$rect_world_width_anterior,
            $rect_world_height_anterior,$seed_anterior,$max_iterations_anterior, $edge_model, $edge_model_anterior,
            $comm_model, $comm_model_anterior, $transm_model, $transm_model_anterior);
        if($resul==true)
        {
            echo json_encode(array("resul"=>true));            
        }else{
            echo json_encode(array("resul"=>false));
        }
    }
    
    public function descargarProyecto($proyecto_id)
    {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'SalidaSimulacion.class.php');   
        $salida_simulacion=new SalidaSimulacion();
        $salida_simulacion->descargarProyecto($proyecto_id);
        
    }
    
    public function visualizarProyecto($proyecto_id)
    {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'SalidaSimulacion.class.php');                   
        $salida_simulacion=new SalidaSimulacion();
        $salida_simulacion->visualizarProyecto($proyecto_id);
    }       
    
}

?>