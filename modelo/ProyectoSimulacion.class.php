<?php

/**
 * Clase ProyectoSimulacion: gestiona los Proyectos de Simulacion
 * @author Bareiro, Santiago Hernan
 */

//importa la clase persistente
require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'ORM'.DIRECTORY_SEPARATOR.'redbeam.php');

class ProyectoSimulacion
{   
    //atributos
    private $id;
    private $nombre;
    private $descripcion;
    private $fechacreacion;
    private $path;
    private $usuario;
    
    //metodos
    public function crearProyecto($usuario, $nombre, $descripcion)
   {
        try{
        //obtiene el usuario de la base
        $unUsuario = R::load( 'usuario' , $usuario->getId() );
        //crea el objeto persistente del proyecto
        $proyecto = R::dispense( 'proyecto' );
        //asigna los valores del proyecto nuevo
        $proyecto->nombre=$nombre.$usuario->getId();
        $proyecto->descripcion=$descripcion;
        $proyecto->fechacreacion= R::isoDateTime();
        //arma el path del proyecto
        $path_shawn_legacyapps=$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'shawn'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'legacyapps'.DIRECTORY_SEPARATOR;
        $path_fuentes_proyecto=$path_shawn_legacyapps.$nombre.$usuario->getId();
        $proyecto->path=$path_fuentes_proyecto;
        //asigna al usuario los proyectos relacion 1-usuario N-proyectos
        $unUsuario->ownProyectoList[] = $proyecto;
        $this->copiaRecursivaDirectorio($path_shawn_legacyapps.'simple_app', $path_fuentes_proyecto);        
        //guarda usuarios y proyectos
        R::store( $unUsuario );
        //renombra los archivos copidado por defecto del proyecto simple_app
        $this->renombrarArchivos($path_fuentes_proyecto, $nombre.$usuario->getId());
        $this->buscarReemplazarTextoProy($path_fuentes_proyecto,$proyecto->nombre);
        
        }catch(Exception $e){
            return null;
        }                
        
        return $proyecto;
   }
    public function buscarProyectoPorNombre($unNombre, $usuario_id)
    {
        $unNombre=$unNombre.$usuario_id;
        $proyecto = R::findOne('proyecto', 'nombre =:nombre AND usuario_id =:usuario_id', array('nombre' => $unNombre, 'usuario_id' => $usuario_id));
        if($proyecto==null){
            return null;
        }else{
            return $proyecto;
        }
        
    }
    
    public function buscarProyectoPorId($proyecto_id)
    {
        return R::load('proyecto', $proyecto_id);
        
    }
    
    public function modificarProyecto($proyecto_id,$nombre,$descripcion)
    {
        try{
        //obtiene el proyecto de la db    
        $proyecto=R::load('proyecto', $proyecto_id);
        //asigna los valores modificados al proyecto
        $nombre_proyecto_nuevo=$nombre.$proyecto->usuario_id; 
        $path_anterior_proyecto=$proyecto->path;
        $proyecto->nombre=$nombre_proyecto_nuevo;
        $proyecto->descripcion=$descripcion;
        //arma el path nuevo del proyecto
        $path_shawn_legacyapps=$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'shawn'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'legacyapps'.DIRECTORY_SEPARATOR;
        $path_fuentes_proyecto=$path_shawn_legacyapps.$nombre_proyecto_nuevo;
        $proyecto->path=$path_fuentes_proyecto;
        //persiste el proyecto
        R::store($proyecto);   
        //renombra los archivos del proyecto con los datos modificados
        $this->renombrarArchivos($path_anterior_proyecto,$nombre_proyecto_nuevo);
        }catch(Exception $e){
            return null;
        }                
        
        return $proyecto;        
        
    }

    public function eliminarProyecto($proyecto_id)
    {
        try{
        $proyecto=R::load('proyecto', $proyecto_id);    
        $path=$proyecto->path;
        R::trash($proyecto);        
        //elimina los archivos del proyecto
        $this->eliminarDirectorio($path);
        }catch(Exception $e){
            return false;
        }
        return true;
    }
    public function getId(){return $this->id;}
    public function getNombre(){return $this->nombre;}
    public function getFechaCreacion(){return $this->fechacreacion;}
    public function getPath(){return $this->path;}
    public function getUsuario(){return $this->usuario;}
    
    public function setId($unId)
    {
        $this->id=$unId;        
    }
    public function setNombre($unNombre)
    {
        $this->nombre=$unNombre;
    }
    
    public function setDescripcion($unaDescripcion)
    {
        $this->descripcion=$unaDescripcion;
    }
    
    public function setFechaCreacion($unaFechaCreacion)
    {
        $this->fechacreacion=$unaFechaCreacion;
        
    }

    public function setPath($unPath)
    {
        $this->path=$unPath;
    }
    
    public function setUsuario($unUsuario)
    {
        $this->usuario=$unUsuario;        
    }
    
    /**
     * Copia el directorio completo de origen en destion.
     * Si destino no existe un destion se crea
     * @param string $src origen
     * @param string $dst destion
     */
    function copiaRecursivaDirectorio($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                $this->copiaRecursivaDirectorio($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
    }
    
    /**
     * Renombra los archivos cuando se modifica el nombre del proyecto
     * @param type $path Path al proyecto de simulacion
     * @param type $nombre_archivo_nuevo Nombre nuevo para el proyecto
     */
    public function renombrarArchivos($path, $nombre_archivo_nuevo)
    {        
        
        $arr_archivos  = scandir($path);
        
        foreach ($arr_archivos as $nombre_archivo)
        {
            if ('init.cpp' == (strstr($nombre_archivo, 'init.cpp')) )
            {
                rename( ($path.DIRECTORY_SEPARATOR.$nombre_archivo),($path.DIRECTORY_SEPARATOR.$nombre_archivo_nuevo.'_init.cpp') );
            }

            if ('init.h' == (strstr($nombre_archivo, 'init.h')) )
            {
                rename( ($path.DIRECTORY_SEPARATOR.$nombre_archivo),($path.DIRECTORY_SEPARATOR.$nombre_archivo_nuevo.'_init.h') );        
            }

            if ('message.cpp' == (strstr($nombre_archivo, 'message.cpp')) ){
                rename( ($path.DIRECTORY_SEPARATOR.$nombre_archivo),($path.DIRECTORY_SEPARATOR.$nombre_archivo_nuevo.'_message.cpp') );
            }

            if ('message.h' == (strstr($nombre_archivo, 'message.h')) )
            {
                rename( ($path.DIRECTORY_SEPARATOR.$nombre_archivo),($path.DIRECTORY_SEPARATOR.$nombre_archivo_nuevo.'_message.h') );              
            }

            if ('processor.cpp' == (strstr($nombre_archivo, 'processor.cpp')) )
            {
                rename( ($path.DIRECTORY_SEPARATOR.$nombre_archivo),($path.DIRECTORY_SEPARATOR.$nombre_archivo_nuevo.'_processor.cpp') );    
            }

            if ('processor.h' == (strstr($nombre_archivo, 'processor.h')) )
            {
               rename( ($path.DIRECTORY_SEPARATOR.$nombre_archivo),($path.DIRECTORY_SEPARATOR.$nombre_archivo_nuevo.'_processor.h') );    
            }

            if ('processor_factory.cpp' == (strstr($nombre_archivo, 'processor_factory.cpp')) )
            {
                rename( ($path.DIRECTORY_SEPARATOR.$nombre_archivo),($path.DIRECTORY_SEPARATOR.$nombre_archivo_nuevo.'_processor_factory.cpp') );    
            }

            if ('processor_factory.h' == (strstr($nombre_archivo, 'processor_factory.h')) )
            {
                rename( ($path.DIRECTORY_SEPARATOR.$nombre_archivo),($path.DIRECTORY_SEPARATOR.$nombre_archivo_nuevo.'_processor_factory.h') );    
            }
    
        }

        //renombra la carpeta raiz del proyecto
        $path_shawn_legacyapps=$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'shawn'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'legacyapps'.DIRECTORY_SEPARATOR;
        rename($path, $path_shawn_legacyapps.$nombre_archivo_nuevo);
   
    
    }
    
    /**
     * Elimina del disco el directorio indicado como parametro
     * @param type $src Directorio que se requiere eliminar
     */
    function eliminarDirectorio($src) 
    {        
        $dir = opendir($src);
        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' )) { 
                if ( is_dir($src . '/' . $file) ) { 
                    $this->eliminarDirectorio($src . '/' . $file); 
                } 
                else { 
                    unlink($src . '/' . $file); 
                } 
            } 
        } 
        rmdir($src);
        closedir($dir); 
    }
    /**
     * Busca y reemplaza en los archivos de un proyecto las secciones de codigo
     * necesarias para configurar correctamente un proyecto nuevo.
     * @param type $path Path a los archivos del proyecto
     * @param type $proyecto_nombre Nombre del proyecto
     */
    function buscarReemplazarTextoProy($path, $proyecto_nombre)
    {
        $arr_archivos  = scandir($path);
        
        $descriptorspec = array(
        0 => array("pipe", "r"), // stdin
        1 => array("pipe", "w"), // stdout
        2 => array("pipe", "w") // stderr
        );
        
        $i=0;
        while ($i<3){
            foreach ($arr_archivos as $nombre_archivo) {
                if ('init.cpp' == (strstr($nombre_archivo, 'init.cpp')) )
                {                                                
                    $comando1='find ' . $path .'/'. $proyecto_nombre.'_init.cpp -type f -exec sed -i -e '."'". 's/SIMPLE_APP/'.strtoupper($proyecto_nombre).'/g'."'".' {} \;';                
                    $comando2='find ' . $path .'/'. $proyecto_nombre.'_init.cpp -type f -exec sed -i -e '."'". 's/simple_app/'.$proyecto_nombre.'/g'."'".' {} \;';
                    $comando3='find ' . $path .'/'. $proyecto_nombre.'_init.cpp -type f -exec sed -i -e '."'". 's/SimpleApp/'.$proyecto_nombre.'/g'."'".' {} \;';

                    $process1=proc_open($comando1, $descriptorspec, $pipes1);
                    $process2=proc_open($comando2, $descriptorspec, $pipes2);
                    $process3=proc_open($comando3, $descriptorspec, $pipes3);                

                    // find ./ -type f -exec sed -i -e 's/apple/orange/g' {} \;
                }

                if ('init.h' == (strstr($nombre_archivo, 'init.h')) )
                {

                    $comando4='find ' . $path .'/'. $proyecto_nombre.'_init.h -type f -exec sed -i -e '."'". 's/SIMPLE_APP/'.strtoupper($proyecto_nombre).'/g'."'".' {} \;';
                    $comando5='find ' . $path .'/'. $proyecto_nombre.'_init.h -type f -exec sed -i -e '."'". 's/simple_app/'.$proyecto_nombre.'/g'."'".' {} \;';

                    $process4=proc_open($comando4, $descriptorspec, $pipes4);
                    $process5=proc_open($comando5, $descriptorspec, $pipes5);

                }

                if ('message.cpp' == (strstr($nombre_archivo, 'message.cpp')) )
                {
                    $comando6='find ' . $path .'/'. $proyecto_nombre.'_message.cpp -type f -exec sed -i -e '."'". 's/simple_app/'.$proyecto_nombre.'/g'."'".' {} \;';
                    $comando7='find ' . $path .'/'. $proyecto_nombre.'_message.cpp -type f -exec sed -i -e '."'". 's/SIMPLE_APP/'.strtoupper($proyecto_nombre).'/g'."'".' {} \;';
                    $comando8='find ' . $path .'/'. $proyecto_nombre.'_message.cpp -type f -exec sed -i -e '."'". 's/SimpleApp/'.$proyecto_nombre.'/g'."'".' {} \;';

                    $process6=proc_open($comando6, $descriptorspec, $pipes6);
                    $process7=proc_open($comando7, $descriptorspec, $pipes7);
                    $process8=proc_open($comando8, $descriptorspec, $pipes8);
                }

                if ('message.h' == (strstr($nombre_archivo, 'message.h')) )
                {
                    $comando9='find ' . $path .'/'. $proyecto_nombre.'_message.h -type f -exec sed -i -e '."'". 's/simple_app/'.$proyecto_nombre.'/g'."'".' {} \;';
                    $comando10='find ' . $path .'/'. $proyecto_nombre.'_message.h -type f -exec sed -i -e '."'". 's/SIMPLE_APP/'.strtoupper($proyecto_nombre).'/g'."'".' {} \;';                
                    $comando11='find ' . $path .'/'. $proyecto_nombre.'_message.h -type f -exec sed -i -e '."'". 's/SimpleApp/'.$proyecto_nombre.'/g'."'".' {} \;';

                    $process9=proc_open($comando9, $descriptorspec, $pipes9);
                    $process10=proc_open($comando10, $descriptorspec, $pipes10);
                    $process11=proc_open($comando11, $descriptorspec, $pipes11);                    

                }

                if ('processor.cpp' == (strstr($nombre_archivo, 'processor.cpp')) )
                {
                    $comando12='find ' . $path .'/'. $proyecto_nombre.'_processor.cpp -type f -exec sed -i -e '."'". 's/simple_app/'.$proyecto_nombre.'/g'."'".' {} \;';
                    $comando13='find ' . $path .'/'. $proyecto_nombre.'_processor.cpp -type f -exec sed -i -e '."'". 's/SIMPLE_APP/'.strtoupper($proyecto_nombre).'/g'."'".' {} \;';                                
                    $comando14='find ' . $path .'/'. $proyecto_nombre.'_processor.cpp -type f -exec sed -i -e '."'". 's/SimpleApp/'.$proyecto_nombre.'/g'."'".' {} \;';

                    $process12=proc_open($comando12, $descriptorspec, $pipes12);
                    $process13=proc_open($comando13, $descriptorspec, $pipes13);
                    $process14=proc_open($comando14, $descriptorspec, $pipes14);

                }

                if ('processor.h' == (strstr($nombre_archivo, 'processor.h')) )
                {

                    $comando15='find ' . $path .'/'. $proyecto_nombre.'_processor.h -type f -exec sed -i -e '."'". 's/simple_app/'.$proyecto_nombre.'/g'."'".' {} \;';
                    $comando16='find ' . $path .'/'. $proyecto_nombre.'_processor.h -type f -exec sed -i -e '."'". 's/SIMPLE_APP/'.strtoupper($proyecto_nombre).'/g'."'".' {} \;';                
                    $comando17='find ' . $path .'/'. $proyecto_nombre.'_processor.h -type f -exec sed -i -e '."'". 's/SimpleApp/'.$proyecto_nombre.'/g'."'".' {} \;';

                    $process15=proc_open($comando15, $descriptorspec, $pipes15);
                    $process16=proc_open($comando16, $descriptorspec, $pipes16);
                    $process17=proc_open($comando17, $descriptorspec, $pipes17);
                }     

                if ('processor_factory.cpp' == (strstr($nombre_archivo, 'processor_factory.cpp')) )
                {                
                    $comando18='find ' . $path .'/'. $proyecto_nombre.'_processor_factory.cpp -type f -exec sed -i -e '."'". 's/simple_app/'.$proyecto_nombre.'/g'."'".' {} \;';
                    $comando19='find ' . $path .'/'. $proyecto_nombre.'_processor_factory.cpp -type f -exec sed -i -e '."'". 's/SIMPLE_APP/'.strtoupper($proyecto_nombre).'/g'."'".' {} \;';                
                    $comando20='find ' . $path .'/'. $proyecto_nombre.'_processor_factory.cpp -type f -exec sed -i -e '."'". 's/SimpleApp/'.$proyecto_nombre.'/g'."'".' {} \;';

                    $process18=proc_open($comando18, $descriptorspec, $pipes18);
                    $process19=proc_open($comando19, $descriptorspec, $pipes19);
                    $process20=proc_open($comando20, $descriptorspec, $pipes20);
                }

                if ('processor_factory.h' == (strstr($nombre_archivo, 'processor_factory.h')) )
                {

                    $comando21='find ' . $path .'/'. $proyecto_nombre.'_processor_factory.h -type f -exec sed -i -e '."'". 's/simple_app/'.$proyecto_nombre.'/g'."'".' {} \;';
                    $comando22='find ' . $path .'/'. $proyecto_nombre.'_processor_factory.h -type f -exec sed -i -e '."'". 's/SIMPLE_APP/'.strtoupper($proyecto_nombre).'/g'."'".' {} \;';                
                    $comando23='find ' . $path .'/'. $proyecto_nombre.'_processor_factory.h -type f -exec sed -i -e '."'". 's/SimpleApp/'.$proyecto_nombre.'/g'."'".' {} \;';

                    $process21=proc_open($comando21, $descriptorspec, $pipes21);
                    $process22=proc_open($comando22, $descriptorspec, $pipes22);
                    $process23=proc_open($comando23, $descriptorspec, $pipes23);

                }

                if ('module.cmake' == (strstr($nombre_archivo, 'module.cmake')) )
                {
                    $comando24='find ' . $path .'/module.cmake -type f -exec sed -i -e '."'". 's/SIMPLE_APP/'.strtoupper($proyecto_nombre).'/g'."'".' {} \;';                
                    $process24=proc_open($comando24, $descriptorspec, $pipes24);

                }

                if ('simpleapp.conf' == (strstr($nombre_archivo, 'simpleapp.conf')) )
                {
                    $comando25='find ' . $path .'/simpleapp.conf -type f -exec sed -i -e '."'". 's/simple_app/'.$proyecto_nombre.'/g'."'".' {} \;';                

                    $process25=proc_open($comando25, $descriptorspec, $pipes25);

                }

            }//del foreach
        
            $this->cerrarProceso($process1);
            $this->cerrarProceso($process2);
            $this->cerrarProceso($process3);
            $this->cerrarProceso($process4);
            $this->cerrarProceso($process5);
            $this->cerrarProceso($process6);
            $this->cerrarProceso($process7);
            $this->cerrarProceso($process8);
            $this->cerrarProceso($process9);
            $this->cerrarProceso($process10);
            $this->cerrarProceso($process11);
            $this->cerrarProceso($process12);
            $this->cerrarProceso($process13);
            $this->cerrarProceso($process14);
            $this->cerrarProceso($process15);
            $this->cerrarProceso($process16);
            $this->cerrarProceso($process17);
            $this->cerrarProceso($process18);
            $this->cerrarProceso($process19);
            $this->cerrarProceso($process20);
            $this->cerrarProceso($process21);
            $this->cerrarProceso($process22);
            $this->cerrarProceso($process23);
            $this->cerrarProceso($process24);   
            $this->cerrarProceso($process25);  
        
        $i++;
        }                          
                
    }
    
    /**
     * Duerme la ejecucion esperando la finalizacion de un proceso para su cierre
     * @param type $process
     */
    public function cerrarProceso($process)
    {
        $status = proc_get_status($process);    
        while ($status["running"] == true )
        {
          sleep(1);          
          $status = proc_get_status($process);          
        }        
        proc_close($process);
        
    }

}    

?>
