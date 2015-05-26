<?php
//muestra mensajes de error en php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
function adminer_object() {
    // required to run any plugin
    include_once __DIR__."/plugins/plugin.php";
    
    /* autoloader
    foreach (glob(__DIR__."/plugins/*.php") as $filename) {
        include_once __DIR__."/plugins/./$filename";
    }*/
    
    include_once __DIR__.'/plugins/dump-alter.php';
    
    $plugins = array(
        // specify enabled plugins here
        new AdminerDumpAlter,
    );
    
    /* It is possible to combine customization and plugins:
    class AdminerCustomization extends AdminerPlugin {
    }
    return new AdminerCustomization($plugins);
    */
    
    return new AdminerPlugin($plugins);
}

// include original Adminer or Adminer Editor

include __DIR__."/adminer-4.2.1.php";
?>
