<?php

/**
 * Description of ControSimulacion
 *
 * @author hernix
 */


//importa la clase persistente
require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'ORM'.DIRECTORY_SEPARATOR.'redbeam.php');

class ControlSimulacion
{
    
    private $count=0;
    private $range=0;
    private $width=0; 
    private $height=0; 
    private $seed=0;
    private $maxIterations=0; 
    
    private $nombreArchivoConf="";
    private $proyecto=null;
    
    public function insertarParametro()
    {
        return $resultado=true;
        
    }
    
    public function buscarParametro($parametro="")
    {
        return $posicion=0;
    }
    
    public function getCount()
    {
        $this->count;
    }
    public function getRange()
    {
        $this->range;
    }
    
    
    public function getWidth()
    {
        $this->width;
    }
    
    public function getHeight()
    {
        $this->height;
    }
    
    public function getSeed()
    {
        $this->seed;
    }
    
    public function getMaxIterations()
    {
        $this->maxIterations;
    }
    
    public function getNombreArchivoConf()
    {
        $this->nombreArchivoConf;
    }
    
    public function getProyecto()
    {
        $this->proyecto;
    }
    
    
     public function setCount($unCount=0)
    {
        $this->count=$unCount;
    }
    public function setRange($unRange=0)
    {
        $this->range=$unRange;
    }
      
    public function setWidth($unWidth=0)
    {
        $this->width=$unWidth;
    }
    
    public function setHeight($unHeight=0)
    {
        $this->height=$unHeight;
    }
    
    public function setSeed($unSeed=0)
    {
        $this->seed=$unSeed;
    }
    
    public function setMaxIterations($maxIterations=0)
    {
        $this->maxIterations=$maxIterations;
    }
    
    public function setNombreArchivoConf($unNombreArchivoConf="")
    {
        $this->nombreArchivoConf=$unNombreArchivoConf;
    }
    
    public function setProyecto($unProyecto=null)
    {
        $this->proyecto=$unProyecto;
    }
    
    public function obtenerArchivosConf($proyecto_id)
    {
        //obtiene el proyecto de la db    
        $proyecto=R::load('proyecto', $proyecto_id);
        $path=$proyecto->path;
        $arr_archivos  = scandir($path);
        $nombres_archivos_conf=array();
        foreach ($arr_archivos as $nombre_archivo)
        {
            if ('.conf' == (strstr($nombre_archivo, '.conf')) )
            {
                $nombres_archivos_conf[]=$nombre_archivo;
            }
            
        }
        
        return $nombres_archivos_conf;        
    }
    
    /**
     * Obtiene los parametros ingresados en un archivo de configuracion .conf de un determinado proyecto
     * @param type $nombre_arch_conf nombre del archivo de donde se desea obtener los parametros
     */
    public function obtenerParamArchivoConf($proyecto_id, $nombre_arch_conf)
    {
        $arr_parametros=array();
        $proyecto=R::load('proyecto', $proyecto_id);
        $path=$proyecto->path; 
        $arch_conf = fopen($path.DIRECTORY_SEPARATOR.$nombre_arch_conf, "r+") or die("Unable to open file!");
        
        $count_buscar="count=";
        $range_buscar="range=";
        $rect_world_width_buscar="width=";
        $rect_world_height_buscar="height=";
        $seed_buscar="seed=";
        $max_iterations_buscar="max_iterations=";
        $edge_model_buscar="edge_model=";
        $comm_model_buscar="comm_model=";
        $transm_model_buscar="transm_model=";
        
        $arr_parametros["count"]="";   
        $arr_parametros["range"]=""; 
        $arr_parametros["rect_world_width"]=""; 
        $arr_parametros["rect_world_height"]="";
        $arr_parametros["seed"]="";
        $arr_parametros["max_iterations"]="";
        $arr_parametros["edge_model"]="0";
        $arr_parametros["comm_model"]="0";
        $arr_parametros["transm_model"]="0";
                
        while(!feof($arch_conf)) 
        {            
            $linea=fgets($arch_conf);
            
            //reemplaza el final de linea por un espacio en blanco para realizar la busqueda de parametros
            $linea=str_replace(PHP_EOL, " ", $linea);
            //echo $linea . '<br>';
            $count=$this->obtenerStringParametro($linea, $count_buscar, " ");
            if($count <> "")
            {
                $arr_parametros["count"]=$count;            
            }
            
            $range=$this->obtenerStringParametro($linea, $range_buscar, " ");
            
            if($range <> "")
            { 
              $arr_parametros["range"]=$range;              
            }
                        
            $rect_world_width=$this->obtenerStringParametro($linea, $rect_world_width_buscar, " ");
            if($rect_world_width <> "")
            {
             $arr_parametros["rect_world_width"]=$rect_world_width;             
            }
            
            $rect_world_height=$this->obtenerStringParametro($linea, $rect_world_height_buscar, " ");
            if($rect_world_height <> ""){
                $arr_parametros["rect_world_height"]=$rect_world_height;
            }
            
            $seed=$this->obtenerStringParametro($linea, $seed_buscar, " ");
            if($seed <> "")
            {
                $arr_parametros["seed"]=$seed;                
            }
            
            $max_iterations=$this->obtenerStringParametro($linea, $max_iterations_buscar, " ");
            if($max_iterations <> "")
            {
                $arr_parametros["max_iterations"]=$max_iterations;
            }
            
            $edge_model=$this->obtenerStringParametro($linea, $edge_model_buscar, " ");
            
            if($edge_model <> "")
            {
                $arr_parametros["edge_model"]=$edge_model;
            }
            
            $comm_model=$this->obtenerStringParametro($linea, $comm_model_buscar, " ");
            
            if($comm_model <> "")
            {
                $arr_parametros["comm_model"]=$comm_model;
            }
            
            $transm_model=$this->obtenerStringParametro($linea, $transm_model_buscar, " ");
            
            if($transm_model <> "")
            {
                $arr_parametros["transm_model"]=$transm_model;
            }            
          
        }
        
        fclose($arch_conf);        
        
        return $arr_parametros;                
    }
    
    function obtenerStringParametro($string, $start, $end)
    {
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }
    
    public function guardarParamArchConf($proyecto_id, $nombre_arch_conf,
            $count,$range,$rect_world_width,$rect_world_height,
            $seed,$max_iterations,$count_anterior,$range_anterior,$rect_world_width_anterior,
            $rect_world_height_anterior,$seed_anterior,$max_iterations_anterior, $edge_model, $edge_model_anterior,
            $comm_model, $comm_model_anterior, $transm_model, $transm_model_anterior)
    {
        $count_buscar="count=".$count_anterior;
        $range_buscar="range=".$range_anterior;
        $rect_world_width_buscar="width=".$rect_world_width_anterior;
        $rect_world_height_buscar="height=".$rect_world_height_anterior;
        $seed_buscar="seed=".$seed_anterior;
        $max_iterations_buscar="max_iterations=".$max_iterations_anterior;
        $edge_model_buscar="edge_model=".$edge_model_anterior;
        $comm_model_buscar="comm_model=".$comm_model_anterior;
        $transm_model_buscar="transm_model=".$transm_model_anterior;
        
        try{
        
        $arr_parametros=array();
        $proyecto=R::load('proyecto', $proyecto_id);
        $path=$proyecto->path; 
        $source=$path.DIRECTORY_SEPARATOR.$nombre_arch_conf;
        $descriptorspec = array(
        0 => array("pipe", "r"), // stdin
        1 => array("pipe", "w"), // stdout
        2 => array("pipe", "w") // stderr
        );
        $i=0;
            while ($i<4)
            {
                $comando1='find ' .$source.' -type f -exec sed -i -e '."'". 's/'.$count_buscar.'/count='.$count.'/g'."'".' {} \;';                
                $comando2='find ' .$source.' -type f -exec sed -i -e '."'". 's/'.$range_buscar.'/range='.$range.'/g'."'".' {} \;';    
                $comando3='find ' .$source.' -type f -exec sed -i -e '."'". 's/'.$rect_world_width_buscar.'/width='.$rect_world_width.'/g'."'".' {} \;';
                $comando4='find ' .$source.' -type f -exec sed -i -e '."'". 's/'.$rect_world_height_buscar.'/height='.$rect_world_height.'/g'."'".' {} \;';
                $comando5='find ' .$source.' -type f -exec sed -i -e '."'". 's/'.$seed_buscar.'/seed='.$seed.'/g'."'".' {} \;';
                $comando6='find ' .$source.' -type f -exec sed -i -e '."'". 's/'.$max_iterations_buscar.'/max_iterations='.$max_iterations.'/g'."'".' {} \;';
                $comando7='find ' .$source.' -type f -exec sed -i -e '."'". 's/'.$edge_model_buscar.'/edge_model='.$edge_model.'/g'."'".' {} \;';
                $comando8='find ' .$source.' -type f -exec sed -i -e '."'". 's/'.$comm_model_buscar.'/comm_model='.$comm_model.'/g'."'".' {} \;';
                $comando9='find ' .$source.' -type f -exec sed -i -e '."'". 's/'.$transm_model_buscar.'/transm_model='.$transm_model.'/g'."'".' {} \;';
                
                
                $process1=proc_open($comando1, $descriptorspec, $pipes1);
                $process2=proc_open($comando2, $descriptorspec, $pipes2);
                $process3=proc_open($comando3, $descriptorspec, $pipes3);
                $process4=proc_open($comando4, $descriptorspec, $pipes4);
                $process5=proc_open($comando5, $descriptorspec, $pipes5);
                $process6=proc_open($comando6, $descriptorspec, $pipes6);
                $process7=proc_open($comando7, $descriptorspec, $pipes7);
                $process8=proc_open($comando8, $descriptorspec, $pipes8);
                $process9=proc_open($comando9, $descriptorspec, $pipes9);
                
                $i++;

                // find ./ -type f -exec sed -i -e 's/apple/orange/g' {} \;                            
            }
            
            $this->cerrarProceso($process1);
            $this->cerrarProceso($process2);
            $this->cerrarProceso($process3);
            $this->cerrarProceso($process4);
            $this->cerrarProceso($process5);
            $this->cerrarProceso($process6);
            $this->cerrarProceso($process7);
            $this->cerrarProceso($process8);
            $this->cerrarProceso($process9);
        
        }catch(Exception $e){
            return false;
        }
        return true;
                       
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