<?php 
$class_mensaje="";
if($_GET["err"]<>"")
{
    $class_mensaje="msj_error";    
}

if($_GET["ok"]<>"")
{
    $class_mensaje="msj_ok";    
}

if ($_GET["err"] <> "")
{
    $mensaje_error=urldecode($_GET["err"]);
?>        
    <h4 class="<?php echo $class_mensaje ; ?>"><?php echo $mensaje_error; ?></h4>
<?php 
}
?>        

<?php     
if ($_GET["ok"] <> "")
{
    $mensaje_error=urldecode($_GET["ok"]);
?>         
     <h4 class="<?php echo $class_mensaje ; ?>"><?php echo $mensaje_error; ?></h4>
<?php     
 } 
?>
