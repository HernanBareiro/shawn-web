<?php 

//muestra mensajes de error en php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require ('rb.php');

//datos de conexion a base de datos
$host="localhost";
$db_name="shawnweb";
$db_user_name="postgres";
$db_password="postgres";

try 
{
    R::setup('pgsql:host='.$host.';dbname='.$db_name,
            $db_user_name,$db_password);
    
    R::debug( true );
    
    $existe_conexion = R::testConnection();
    
    if($existe_conexion)
    {
        echo '<br> Conexi&oacute;n correcta a la base de datos <br>';
        
         $logs = R::getDatabaseAdapter()->getDatabase()->getLogger();
        
        //crea un usuario de prueba
        $usuario = R::dispense( 'usuario' );
        //setearle los atributos del usuario 
        $usuario->nombre='test';
        $usuario->email='test@test.com';
        $usuario->password='test';                
        
        //crea otro usuario de prueba
        $usuario2 = R::dispense( 'usuario' );
        $usuario2->nombre='usuario2';
        $usuario2->email='usuario2@usuario2.com';
        $usuario2->password='usuario2';                
               
        //crea un proyecto
        $proyecto = R::dispense( 'proyecto' );
        $proyecto->nombre='';
        $proyecto->descripcion='';
        $proyecto->fechacreacion= R::isoDateTime() ;
        $proyecto->path='';
        //asigna al usuario los proyectos relacion 1-usuario N-proyectos
        $usuario->ownProyectoList[] = $proyecto;        
        
        $grupo=R::dispense('grupo');
        $grupo->nombre='Desarrollador de Aplicaciones de Simulación';
        $grupo->codigo='G_DES';
        
        //crea una relacion N-usuarios N-grupos
        //crea una tabla intermedia grupo_usuario
        $usuario->sharedGrupoList[] = $grupo;
        $usuario2->sharedGrupoList[] = $grupo;
        
        R::storeAll( array($usuario, $usuario2) );    
        
        //elimina el proyecto creado para generar la estructura de la db
        $proyecto_creado=R::load('proyecto', '1'); 
        R::trash($proyecto_creado);                                 
         
        echo($logs->grep( 'INSERT' ));
        echo "<br>";
        echo($logs->grep( 'CREATE' ));
        echo "<br>";
        echo($logs->grep( 'ALTER' ));
        
        
    }  else {
        echo '<br> No se pudo establecer conexi&oacute;n con la base de datos. Verifique los datos <br>';
    }
    
}  catch (RedException $e){
    
    print_r($e);
}

?>