<?php
session_start();
error_reporting(0); // Set E_ALL for debuging

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';
require ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'ORM'.DIRECTORY_SEPARATOR.'redbeam.php');
// Required for MySQL storage connector
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeMySQL.class.php';
// Required for FTP connector support
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeFTP.class.php';


/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from  '.' (dot)
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
		:  null;                                    // else elFinder decide it itself
}

    $usuario_id=$_SESSION['usuario_id'];
    $usuario=R::load('usuario', $usuario_id);
    $proyectos=$usuario->ownProyectoList;
    $unPathProyecto='';
    $paths=array();
    $index_arr=0;
    if(count ($proyectos) > 0){ 
        foreach( $proyectos as $proy ) 
        {
            $unPathProyecto=$proy->path;
            //quita parte del path para que tenga formato url
            $unaUrlProyecto=strstr($proy->path,'shawn');
            $paths[$index_arr]=array(
                            'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)			
                            'path'          => $unPathProyecto,			
                            'URL'           => '/'. $unaUrlProyecto,
                            'accessControl' => 'access',             // disable and hide dot starting files (OPTIONAL)
                            'alias'         => $proy->nombre //$unPathProyecto
                    );
            $index_arr++;        
        }
    }
    
    $ruta_aplicacion_ejemplo=$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'/shawn/src/legacyapps/simple_app/';
    $paths[$index_arr]=array(
                        'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)			
                        'path'          => $ruta_aplicacion_ejemplo,
                        'URL'           => '/shawn/src/legacyapps/simple_app',
			'accessControl' => 'access',             // disable and hide dot starting files (OPTIONAL)
                        'copyFrom'=>true,
                        'copyTo'=>false,
                        'uploadOverwrite'=>false,
                        'disabled' => array('rename', 'delete', 'cut'),
                        'defaults' => array('read' => true, 'write' => false),
                        'attributes' => array(
                                            array( // hide readmes
                                                'pattern' => '/\.(cmake|cpp|h|conf|pdf|png|ps)$/i',
                                                'read'   => true,
                                                'write'  => false,
                                                'locked' => true,
                                                'hidden' => false
                                            )
                                        ),
                        'alias'         => 'simple_app2'
        
    );

$opts=array(
    'roots'=>$paths
);

/*$opts = array(
	// 'debug' => true,
	'roots' => array(
		array(
			'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
			//'path'          => '../shawn/src/legacyapps/mi_aplic/',         // path to files (REQUIRED)
                        'path'          => $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'/shawn/src/legacyapps/mi_aplic/',
			//'URL'           => dirname($_SERVER['PHP_SELF']) . '/../shawn/src/legacyapps/mi_aplic/', // URL to files (REQUIRED)
                        'URL'           => $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'/shawn/src/legacyapps/mi_aplic/',
			'accessControl' => 'access',             // disable and hide dot starting files (OPTIONAL)
                        'alias'         => 'mi_aplic'.$unPath
		),
            
                array(
			'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
			'path'          => '../shawn/src/legacyapps/simple_app/',         // path to files (REQUIRED)
			'URL'           => dirname($_SERVER['PHP_SELF']) . '/../shawn/src/legacyapps/simple_app/', // URL to files (REQUIRED)
			'accessControl' => 'access',             // disable and hide dot starting files (OPTIONAL)
                        'alias'         => 'simple_app'
		),
            
            
		// array(
		//	    'driver'        => 'LocalFileSystem',
		//	    'path'          => '/home/hernix/sensores/shawn/shawn/src/legacyapps/simple_app',
		//	    'URL'           => '/home/', //seteado en /etc/apache2/sites-available/prueba como un alias
		//	    'accessControl' => 'access',	
		//	    'alias'         => 'simple_app'
		//       )
            
	)
);*/

// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();

