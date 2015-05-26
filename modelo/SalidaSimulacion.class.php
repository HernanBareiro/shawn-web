<?php
//muestra mensajes de error en php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

//importa la clase persistente
require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'ORM'.DIRECTORY_SEPARATOR.'redbeam.php');
class SalidaSimulacion 
{
    private $proyecto;
    
    public function getProyecto()
    {
        return $this->proyecto;        
    }
    
    public function setProyecto($unProyecto)
    {
        $this->proyecto=$unProyecto;
    }
    
    public function compilarProyecto($proyecto_id)
    {
        $descriptorspec = array(
        0 => array("pipe", "r"), // stdin
        1 => array("pipe", "w"), // stdout
        2 => array("pipe", "w") // stderr
        );
        try{
        $proyecto=R::load('proyecto', $proyecto_id);
        $path=$proyecto->path;
        $nombre_proyecto=$proyecto->nombre;
        
        //ver si hace falta poner el moduloStatus ON...
        /*
         $comando1='find ' . $path .'/module.cmake -type f -exec sed -i -e '."'". 's/moduleStatus OFF/moduleStatus ON/g'."'".' {} \;';
        */
        $path_shawn_src=$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'shawn'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR;
        $comando1='find ' . $path_shawn_src .'ShawnWebUserAppCfg.cmake -type f -exec sed -i -e '."'". 's/\(USER_MODULE_NAME *.*\)/USER_MODULE_NAME '.$nombre_proyecto.'\)/g'."'".' {} \;';
       
        $process1=  proc_open($comando1, $descriptorspec, $pipes1);
        $this->cerrarProceso($process1);                
        
        //comando 2
        $path_shawn_buildfiles=$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'shawn'.DIRECTORY_SEPARATOR.'buildfiles'.DIRECTORY_SEPARATOR;        
        $process2=proc_open('cd '.$path_shawn_buildfiles.'&& cmake ../src', $descriptorspec, $pipes2);        
        
        while (!feof($pipes2[1])) {
            foreach($pipes2 as $key =>$pipe) {                
                
                while (($line = fgets($pipe)) !== false) {
                print("<br>" . $line); 
                }
            }           
        }
        $this->cerrarProceso($process2);                        

        //compilacion final
        $process3=proc_open('cd '.$path_shawn_buildfiles.'&& make', $descriptorspec, $pipes3);        
        
        while (!feof($pipes3[1])) {
            foreach($pipes3 as $key =>$pipe) {
                                
                while (($line = fgets($pipe)) !== false) {
                print("<br>" . $line); 
                }                               
            }
        }
        $this->cerrarProceso($process3);
        }catch(Exception $e){
            return false;
        }  
        return true;
    }
    
    public function ejecutarProyecto($proyecto_id, $nombre_arch_conf)
    {
        $descriptorspec = array(
        0 => array("pipe", "r"), // stdin
        1 => array("pipe", "w"), // stdout
        2 => array("pipe", "w") // stderr
        );
        try{
        $proyecto=R::load('proyecto', $proyecto_id);
        $path=$proyecto->path;
        $nombre_proyecto=$proyecto->nombre;
        //comando 1
        //$process=proc_open('cd /home/hernix/sensores/shawn/shawn/buildfiles/&& ./shawn -f helloworld.conf', $descriptorspec, $pipes);
       
        $path_shawn_proy_buildfiles=$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'shawn'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'legacyapps'.DIRECTORY_SEPARATOR.$nombre_proyecto.DIRECTORY_SEPARATOR.'build_files'.DIRECTORY_SEPARATOR;        
        $process2=proc_open('cd '.$path_shawn_proy_buildfiles.'&& ./shawn_web_'.$nombre_proyecto.' -f ../'.$nombre_arch_conf, $descriptorspec, $pipes2);        
        
        while (!feof($pipes2[1])) {
            foreach($pipes2 as $key =>$pipe) {                                
                while (($line = fgets($pipe)) !== false) {
                print("<br>" . $line); 
                }
            }           
        }
        $this->cerrarProceso($process2);
        
        }catch(Exception $e){
            return false;
        }  
        return true;
              
    }
    
    
    
    public function descargarProyecto($proyecto_id)
    {
        
        $proyecto=R::load('proyecto', $proyecto_id);
        $path=$proyecto->path;
        $proyecto_nombre=$proyecto->nombre;
                
        $fecha_sistema_hs_min_seg=date("-d_m_Y-H_i_s"); 
        $nombre_archivo_zip=$proyecto_nombre.$fecha_sistema_hs_min_seg.'.zip';
        $destino_archivo_comprimido=$path.DIRECTORY_SEPARATOR.$nombre_archivo_zip;
        
        $this->comprimirDirectorio($path,$destino_archivo_comprimido);      
        
        if(file_exists($destino_archivo_comprimido)){
        // genera descarga del archivo
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="'.$nombre_archivo_zip.'"');
        @readfile($destino_archivo_comprimido) or die("problem occurs.");
        // eliminar el archivo zip generado
        unlink($destino_archivo_comprimido);
        }
        
    }
    
    public function comprimirDirectorio($source, $destination){
        
        if (!extension_loaded('zip') || !file_exists($source)) {            
        return false;        
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {           
            return false;
        }

        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source) === true)
        {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file)
            {                
                $file = str_replace('\\', '/', $file);

                // Ignora carpetas "." y ".."
                if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                    continue;

                $file = realpath($file);

                if (is_dir($file) === true)
                {                    
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                }
                else if (is_file($file) === true)
                {                    
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));                    
                }
            }
        }
        else if (is_file($source) === true)
        {           
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        //retorna true si crea el archivo zip
        return $zip->close();                
        
    }
    
    public function visualizarProyecto($proyecto_id)
    {
        $proyecto=R::load('proyecto', $proyecto_id);
        $path=$proyecto->path;
        $path_build_files=$path.DIRECTORY_SEPARATOR."build_files";
        $arr_archivos  = scandir($path_build_files);
        $archivo_pdf_visualizar="";
        
        foreach ($arr_archivos as $nombre_archivo)
        {
            if ('.pdf' == (strstr($nombre_archivo, '.pdf')) )
            {
                $archivo_pdf_visualizar=$nombre_archivo;                                
            }
        }
        
        
        $path_archivo_pdf=$path_build_files.DIRECTORY_SEPARATOR.$archivo_pdf_visualizar; 
        
        if(is_file($path_archivo_pdf))
        {
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="' . $archivo_pdf_visualizar . '"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($path_archivo_pdf));
            header('Accept-Ranges: bytes');
            header("Pragma: no-cache");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Expires: 0");
            @readfile($path_archivo_pdf) or die("problem occurs.");                    
        }

        
    }
       
    /**
     * Espera a la finalizacion de un proceso para su cierre
     * @param type $process
     */
    public function cerrarProceso($process)
    {
        $status = proc_get_status($process);        
        while ($status["running"] == true) 
        {        
          sleep(1);          
          $status = proc_get_status($process);          
        }
        
        proc_close($process);
        
    }
    
}
?>