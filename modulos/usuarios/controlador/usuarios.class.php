<?php
//mantiene la sesion para obtener los datos del usuario
session_start();

//instancia la clase controladora
$controlador_usuarios=new usuarios();

//controla los parametros de modificacion de datos de usuario
if (isset($_POST["modificar-usuario"]))
{
    $nombre_usuario=$_POST["nombre-usuario"];
    $email=$_POST["email"];
    $password=$_POST["password"];
    $password_confirmar=$_POST["password-confirmar"];
    $controlador_usuarios->modificarUsuario($nombre_usuario,$email,$password,$password_confirmar);
 }else{
        //retorna la modificacion del usuario
        header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/usuarios/vistas/modificar_datos_perfil.php');
}   

class usuarios{
    public function modificarUsuario($nombre_usuario,$email,$password,$password_confirmar)
    {
        if($password==$password_confirmar)
        {
            require($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'modelo'.DIRECTORY_SEPARATOR.'Usuario.class.php');
            $usuario=unserialize($_SESSION['Usuario']);
            $usuario=$usuario->modificarUsuario($usuario,$nombre_usuario,$email,$password);
            
            if($usuario !== null){
                //guarda el objeto modificado en la variable sesion
                $_SESSION['Usuario']= serialize($usuario);
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/usuarios/vistas/modificar_datos_perfil.php?ok='.urlencode('Los datos se modificaron correctamente'));
            }else{
                //error interno al persistir el usuario
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/usuarios/vistas/modificar_datos_perfil.php?err='.urlencode('Error al modificar el usuario'));
            }
        }else{
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/modulos/usuarios/vistas/modificar_datos_perfil.php?err='.urlencode('No coinciden las contrase&ntilde;as'));
        }
            
    }
}    
    
?>


