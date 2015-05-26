<?php
//mantiene la sesion para obtener los datos del usuario
session_start();

//muestra mensajes de error en php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

//instancia el controlador
$proyectos=new proyectos();

if (isset($_POST["crear-proyecto"]))
{
    $nombre=$_POST["nombre-proyecto"];
    $descripcion=$_POST["descripcion"]; 
    $proyectos->validarNombreProyectoCreacion($nombre);
    $proyectos->crearProyecto($nombre, $descripcion);        

}else if (isset ($_GET["cargar-datos-proy"]))
{
    $proyecto_id=$_GET["proyecto_id"];
    $proyectos->enviarDatosProyecto($proyecto_id);
    

}else if (isset ($_POST["modificar-proyecto"]))
{
    $proyecto_id=$_POST["proyecto_id"];
    $nombre=$_POST["nombre-proyecto"];
    $descripcion=$_POST["descripcion"]; 
    $proyectos->validarNombreProyectoModificacion($nombre,$proyecto_id);
    $proyectos->modificarProyecto($proyecto_id,$nombre,$descripcion);
       
}else if ( isset ($_GET["eliminar-proyecto"]) )
{
    $proyecto_id=$_GET["proyecto_id"];
    $proyectos->eliminarProyecto($proyecto_id);
    
}else{
    //retorna la modificacion del usuario
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/simulacion/vistas/simulacion_wsn.php?err='.urlencode('url no econtrada'));
    break;
}      

class proyectos
{

    public function crearProyecto($nombre, $descripcion)
    {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'Usuario.class.php');
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'ProyectoSimulacion.class.php');
        $usuario=unserialize($_SESSION['Usuario']);
        $proyecto_simulacion=new ProyectoSimulacion();
        $proyecto=$proyecto_simulacion->crearProyecto($usuario, $nombre, $descripcion);
        if($proyecto == null)
        {
            //error interno al persistir proyecto
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/proyectos/vistas/crear_proyecto_simulacion.php?err='.urlencode('Error al crear el Proyecto'));
            break;
        }else{
            //ok proyecto creado
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/proyectos/vistas/crear_proyecto_simulacion.php?ok='.urlencode('Proyecto creado correctamente'));
            break;
        }
    
    }
    
    public function listarProyectos()
    {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'Usuario.class.php');
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'ProyectoSimulacion.class.php');
        $usuario=unserialize($_SESSION['Usuario']);
        $proyectos=$usuario->listarProyectos($usuario);
        
        print_r($proyectos);
        exit;
    }
    
    public function validarNombreProyectoCreacion($unNombre)
    {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'Usuario.class.php');
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'ProyectoSimulacion.class.php');
        $usuario=unserialize($_SESSION['Usuario']);
        $proyecto_simulacion=new ProyectoSimulacion();
        $existeNombreProyecto=$proyecto_simulacion->buscarProyectoPorNombre($unNombre, $usuario->getId());
        if($existeNombreProyecto == null)
        {
            return false;        
            
        }else{
        header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/proyectos/vistas/crear_proyecto_simulacion.php?err='.urlencode('El nombre de proyecto ya existe'));        
        break;
        break;
        }
        
        
            
    }
    public function validarNombreProyectoModificacion($unNombre,$proyecto_id)
    {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'Usuario.class.php');
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'ProyectoSimulacion.class.php');
        $usuario=unserialize($_SESSION['Usuario']);
        $proyecto_simulacion=new ProyectoSimulacion();
        $existeNombreProyecto=$proyecto_simulacion->buscarProyectoPorNombre($unNombre, $usuario->getId());                        
        
        if($existeNombreProyecto==null)
        {
            return false;
        }    
        if( ( ($existeNombreProyecto->id) === ($proyecto_id) ) ){
            return false;
        }  else {
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/proyectos/vistas/modificar_proyecto_simulacion.php?err='.urlencode('El nombre de proyecto ya existe'));                    
            break;
        }
    }
    
    public function enviarDatosProyecto($proyecto_id)
    {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'ProyectoSimulacion.class.php');
        $proyecto=new ProyectoSimulacion();
        $unProyecto=$proyecto->buscarProyectoPorId($proyecto_id);
        if ($unProyecto!=null){
            $unProyecto->nombre;
            $unProyecto->descripcion;
            echo json_encode(array("nombre" => $unProyecto->nombre , "descripcion" => $unProyecto->descripcion));
        }
    }
    
    public function modificarProyecto($proyecto_id,$nombre,$descripcion)
    {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'ProyectoSimulacion.class.php');
        $proyecto=new ProyectoSimulacion();
        $resul=$proyecto->modificarProyecto($proyecto_id,$nombre,$descripcion);
        if($resul == null)
        {
            //error interno al modificar proyecto
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/proyectos/vistas/modificar_proyecto_simulacion.php?err='.urlencode('Error al modificar el Proyecto'));
        }else{
            //ok proyecto creado
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/proyectos/vistas/modificar_proyecto_simulacion.php?ok='.urlencode('Proyecto modificado correctamente'));
        }
        
    }
    
    public function eliminarProyecto($proyecto_id)
    {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'ProyectoSimulacion.class.php');
        $proyecto=new ProyectoSimulacion();
        $proyecto_eliminado=$proyecto->eliminarProyecto($proyecto_id);
        if($proyecto_eliminado==true)
        {
            //ok proyecto creado
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/proyectos/vistas/eliminar_proyecto_simulacion.php?ok='.urlencode('Proyecto eliminado correctamente'));
            
        }else{
            //error interno al eliminar el proyecto
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/proyectos/vistas/eliminar_proyecto_simulacion.php?err='.urlencode('Error al modificar el Proyecto'));
        }
    }

}
?>