<?php 

require ('rb.php');

//datos de conexion a base de datos
$host="localhost";
$db_name="shawnprueba";
$db_user_name="postgres";
$db_password="postgres";

R::setup('pgsql:host='.$host.';dbname='.$db_name,
            $db_user_name,$db_password);
    
/*R::setup('pgsql:host=localhost;dbname=shawnprueba',
        'postgres','postgres');*/


R::debug( false );


/**
 * Conectar a la base de datos por linea de comandos
 * sudo -u postgres psql
 */
?>