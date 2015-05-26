<header id="menu_cabecera"> 
    <h1 class="titulo_home"><a class="link_home" href=" <?php echo 'http://'.$_SERVER['SERVER_NAME'].'/modulos/simulacion/vistas/simulacion_wsn.php'?> ">ShawnWEB</a><span> Simulaci&oacute;n de WSN Basada en la Web</span></h1>
    <nav>
        <ul>
          <li><a href="/about">Ayuda</a>
            <ul>
                <li><a href="https://github.com/itm/shawn">Shawn Wiki</a></li>
                <li><a href="http://shawn.sourceforge.net/doc/api/">Shawn API</a></li>
                <li><a href="/papers">Shawn Papers</a></li>
            </ul>
          </li>
          <li><a href="/about"><?php echo $usuario->getNombre(); ?></a>
            <ul>
                <li><a href="/modulos/usuarios/vistas/modificar_datos_perfil.php">Modificar Perfil</a></li>
                <li><a href="/modulos/login/controlador/logout.class.php">Salir</a></li>                            
            </ul>
          </li>
        </ul>
    </nav> 
</header>