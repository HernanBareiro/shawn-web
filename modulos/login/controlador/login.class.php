<?php

//muestra mensajes de error en php
//ini_set('display_startup_errors',1);
//ini_set('display_errors',1);
//error_reporting(-1);

//incluye el modelo de clases
require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'Usuario.class.php');
//instancia este controlador login
$controlador_login=new login();

//controla los parametros de inicio de sesion o registro
if (isset($_POST["iniciar-sesion"]))
{
    $nombre_usuario=$_POST["nombre-usuario"];
    $password=$_POST["password"];
    //iniciar sesion
    $controlador_login->iniciarSesion($nombre_usuario,$password);
    
} else if(isset($_POST["registrar-usuario"]))
        {
            $nombre_usuario=$_POST["nombre-usuario"];
            $email=$_POST["email"];
            $password=$_POST["password"];
            $password_confirmar=$_POST["password-confirmar"];
            //registrar usuario
            $controlador_login->registrarUsuario($nombre_usuario,$email,$password,$password_confirmar);
            
        }else{
            //retorna al inicio de sesion
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/login/vistas/iniciar_sesion.php');
        }

//clase controladora login
class login
{
    /**
     * Inicia sesión en el sistema y guarda en sesión el objeto Usuario
     * @param string $nombre_usuario
     * @param string $password
     */
    public function iniciarSesion($nombre_usuario,$password)
    {
        $usuario=new Usuario();
        $usuario=$usuario->identificarUsuario($nombre_usuario, $password);
        
        if(isset ($usuario) ){
            //inicia la sesion 
            session_start();
            //guarda el objeto Usuario en una variable sesion
            $_SESSION['Usuario']= serialize($usuario);
            //guarda el id del Usaurio en una variable sesion
            $_SESSION['usuario_id']=$usuario->getId();
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/simulacion/vistas/simulacion_wsn.php');
        }else{
            //usuario no registrado
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/login/vistas/iniciar_sesion.php?err='.urlencode('Usuario no registrado'));
        }
        
    }
    
    /**
     * Registra un usuario en el sistema
     * @param string $nombre_usuario
     * @param string $email
     * @param string $password
     * @param string $password_confirmar
     */    
    public function registrarUsuario($nombre_usuario,$email,$password,$password_confirmar)
    {
        //verifica que coincidan las contraseñas
        if($password==$password_confirmar)
        {
            //se crea el objeto usuario
            $usuario=new Usuario();
            //verifica que el nombre de usuario no este registrado
            $existe=$usuario->existeNombreUsuario($nombre_usuario);
            if( $existe==true )
            {
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/login/vistas/registrar_usuario.php?err='.urlencode('El nombre de usuario ya existe'));
            }  else {
                
                //persiste el objeto Usuario
                $resultado=$usuario->crearUsuario($usuario,$nombre_usuario,$email,$password);

                if($resultado==true){
                    //inicia la sesion 
                    session_start();
                    //guarda el objeto Usuario en una variable sesion
                    $_SESSION['Usuario']= serialize($usuario);
                    //guarda el id del Usaurio en una variable sesion
                    $_SESSION['usuario_id']=$usuario->getId();
                    header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/simulacion/vistas/simulacion_wsn.php');
                }else{
                    //error interno al persistir el usuario
                    header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/login/vistas/registrar_usuario.php?err='.urlencode('Error al crear el usuario'));
                }
            }
        }else{
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/login/vistas/registrar_usuario.php?err='.urlencode('No coinciden las contrase&ntilde;as'));
        }
        
    }

}

?>
