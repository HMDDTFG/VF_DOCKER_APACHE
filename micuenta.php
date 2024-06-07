<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberSphere Technologies</title>
    <script src="https://kit.fontawesome.com/ce9416b376.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="index.js"></script>
</head>

<body>
    <div class="cabecera">
        <i id="logo_user" class="fa-regular fa-user" style="color: white;"></i>
        <?php
        if (isset($_SESSION['id_usuario'])) {
            $username = htmlspecialchars($_SESSION['id_usuario'], ENT_QUOTES, 'UTF-8');
            echo "<a id=\"cab_usuario\" class=\"px-2\" href=\"micuenta.php\" style=\"color: #ffffff;\">$username</a>";
        } else {
            echo "<a id=\"cab_usuario\" class=\"px-2\" href=\"login.php\" style=\"color: #ffffff;\">Identifícate</a>";
        }
        ?>
    </div>
    <header class="subcabecera">
        <div id="sidebar" class="sidebar" style="width: 0px;">
            <a href="#" id="equis" class="boton-cerrar" onclick="ocultar()">×</a>
            <ul class="menu_opciones">
                <li><a class="titulo" id="botoninicio" href="index.php">INICIO</a></li>
                <li><a class="separacion"></a></li>
                <li><a class="titulo" id="botonquien" href="quiensomos.php">¿QUIÉNES SOMOS?</a></li>
                <li><a class="separacion"></a></li>
                <li><a class="titulo">PRODUCTOS</a></li>
                <li><a class="opciones price-sorting-link" href="#" data-sort="h2l">MÁS CAROS</a></li>
                <li><a class="opciones price-sorting-link" href="#" data-sort="l2h">MÁS BARATOS</a></li>
                <li><a class="separacion"></a></li>
                <li><a class="titulo">AYUDA Y AJUSTES</a></li>
                <?php 
                    if (isset($_SESSION['id_usuario'])) {
                     
                     echo '<li><a class="opciones" href="micuenta.php">MI CUENTA</a></li>';
                     } 
                ?>
                <li><a class="opciones" href="contacto.php">ATENCIÓN AL CLIENTE</a></li>
                <?php 
                    if (isset($_SESSION['id_usuario'])) {
                     
                     echo "<li><a class=\"opciones\" href=\"login.php\">OTRA CUENTA</a></li>";
                     } else {
                    echo "<li><a class=\"opciones\" href=\"login.php\">IDENTIFICARSE</a></li>";
                    }
                ?>
                <li><a class="separacion"></a></li>
                <li><a class="titulo">ENCUENTRANOS AQUÍ</a></li>
                <img class="rrss" src="./img/instagram.png"><img id="twitter" class="rrss" src="./img/twitter.png">
            </ul>
        </div>
        <div id="overlay"></div>
        <div id="contenido" style="margin-left: 0px;">
            <div id="div_menu"><a id="abrir" class="abrir-cerrar" href="javascript:void(0)" onclick="mostrar()"
                    style="display: inline;"><i id="menu" class="fa-solid fa-bars" style="color: rgb(5,47,64);"></i></a>
            </div>
        </div>
        <a id="cerrar" class="abrir-cerrar" href="#" onclick="ocultar()" style="display: none;">
        </a>
        <div id="logos"><img id="logo" src="./img/logo.png" alt="Logo empresa">
            <img id="nombre" class="d-none d-lg-block" src="./img/logo_nombre.png" alt="Nombre empresa">
        </div>
        <div id="div_cesta"><a href="cesta.html"><i id="cesta" class="fa-solid fa-cart-shopping"
                    style="color: rgb(5,47,64);"></i></a></div>
    </header>

    <div id="despegable">

    </div>
    <div id="fondo_contenido">
        <div id="container">
            <h3 id="no">Mis datos</h3>
            <div id="misdatos">
                <ul id="listadatos">
                    <?php 
                    include "conexion.php";
                    if (isset($_SESSION['id_usuario'])) {
                        $username = htmlspecialchars($_SESSION['id_usuario'], ENT_QUOTES, 'UTF-8');

                        $sql = "SELECT `id_usuario`, `correo`, `ciudad`, `cp` FROM `usuario` WHERE `id_usuario` LIKE '$username'";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $datos = $stmt->fetch(PDO::FETCH_ASSOC);
            
                        echo '<li class="datos">Nombre de usuario: '.$datos['id_usuario'].'</li>';
                        echo '<li class="datos">Correo electrónico: '.$datos['correo'].' </li>';
                        echo '<li class="datos">Ciudad: '.$datos['ciudad'].' </li>';
                        echo '<li class="datos">Código postal: '.$datos['cp'].' </li>';
                    } else{
                        echo '<li class="datos">Inicia sesión para ver tus datos.</li>';
                    }
                    
                    ?>
                </ul>
            </div>
            <div id="sinsesion">
                    <?php if (isset($_SESSION['id_usuario'])) {
                    echo "<h4>¿Quieres cerrar sesión? Pulse aquí</h4>
                    <form class=\"cses\" action=\"cerrarsesion.php\" method=\"post\">
                        <input class=\"inputlog\" type=\"submit\" value=\"Cerrar Sesión\">
                    </form>";}
                    ?>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 CyberSphere Technologies. David Díaz y Héctor Marín.</p>
    </footer>
</body>
</html>