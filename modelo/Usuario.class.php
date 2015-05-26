<?php
/**
 * Clase Usuario: Gestiona los Usuarios de Simulación
 * @author hernix
 */

require_once ($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'ORM'.DIRECTORY_SEPARATOR.'redbeam.php');

class Usuario 
{
    //atributos
    private $id;
    private $nombre;
    private $password;
    private $email;
    private $proyectos;
    
    //metodos
    /**
     * Crea un Usuario y Persiste los datos en la DB
     * @return boolean $resultado 
     */
    public function crearUsuario($usuario_nuevo,$nombre_usuario,$email,$password)
    {   
        try{
        $usuario = R::dispense( 'usuario' );
        $usuario->nombre=$nombre_usuario;
        $usuario->email=$email;
        $usuario->password=$password;
        
        //obtiene el gruupo de usuarios desarrolladores de aplicaciones de simuulacion
        $grupo = R::findOne('grupo', 'codigo =:codigo', array('codigo' => 'G_DES'));
        $usuario->sharedGrupoList[] = $grupo;
        
        $id = R::store( $usuario );
        $usuario_nuevo->setId($id);
        $usuario_nuevo->setNombre($nombre_usuario);
        $usuario_nuevo->setEmail($email);
        $usuario_nuevo->setPassword($password);
                
        
        }catch(Exception $e){
            return false;
        }
        return true;        
    }
    public function eliminarUsuario($idUsuario=0){return $resultado=true;}
    
    /**
     * Modifica los datos del usuario y guarda en la DB
     * @param Usuario $unUsuario 
     * @param string $nombre_usuario
     * @param string $email
     * @param string $password
     * @return boolean true si se realizo la modificacon false hubo un error
     */
    public function modificarUsuario($unUsuario,$nombre_usuario,$email,$password)
    {
        try{
            $usuario=null;
            //modifica el usuario
            $usuario=R::load('usuario', $unUsuario->getId());            
            $usuario->nombre=$nombre_usuario;
            $usuario->email=$email;
            $usuario->password=$password;
            R::store($usuario);
            
            $usuario=R::load('usuario', $unUsuario->getId());
            
            $unUsuario->setNombre($usuario->nombre);
            $unUsuario->setEmail($usuario->email);
            $unUsuario->setPassword($usuario->password);
            
        }catch(Exception $e){
            return null;
        }
        return $unUsuario;
        
    }
    /**
     * Identifica un usuario registrado. De existir devuelve el objeto o null
     * @param string $unNombre
     * @param string $unPassword
     * @return Usuario $usuario Objeto usuario
     */
    public function identificarUsuario($unNombre,$unPassword)
    {      
        $usuario = R::findOne('usuario', 'nombre =:nombre AND password =:password', array('nombre' => $unNombre, 'password' => $unPassword));
        if($usuario==null){
            return null;
        }else{
        $unUsuario=new Usuario();
        $unUsuario->setId($usuario->id);
        $unUsuario->setNombre($usuario->nombre);
        $unUsuario->setPassword($usuario->password);
        $unUsuario->setEmail($usuario->email);
        return $unUsuario;
        }
    }
    
    /**
     * Verifica si el nombre de usuario ya existe en la DB.
     * Si existe retorna true, si no existe retorna false
     * @param string $unNombre nombre de usuario
     * @return boolean
     */
    public function existeNombreUsuario($unNombre)
    {
        $usuario=R::findOne('usuario', 'nombre =:nombre', array('nombre' => $unNombre));
        if($usuario==null){
            return false;
        }else{
            return true;
        }
    }
    public function listarProyectos($unUsuario) 
    {
        $usuario=R::load( 'usuario', $unUsuario->getId() );
        return $proyectos=$usuario->ownProyectoList;
    }


    public function getId(){return $this->id;}
    public function getNombre(){return $this->nombre;}
    public function getPassword(){return $this->password;}
    public function getEmail(){return $this->email;}
    public function getProyectos(){return $this->proyectos;}
    
    public function setId($unId)
    {
        $this->id=$unId;        
    }
    public function setNombre($unNombre="")
    {
        $this->nombre=$unNombre;
    }
    public function setPassword($unPassword="")
    {
        $this->password=$unPassword;
    }
    public function setEmail($unEmail="")
    {
        $this->email=$unEmail;
    }
    public function setProyectos($unProyecto)
    {
        $this->proyectos=$unProyecto;        
    }

}

?>
