<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberSphere Technologies</title>
    <script src="https://kit.fontawesome.com/ce9416b376.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="contacto.css">
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
                <li><a class="titulo">ENCUÉNTRANOS AQUÍ</a></li>
                <img class="rrss" src="./img/instagram.png"><img id="twitter" class="rrss" src="./img/twitter.png">
            </ul>
        </div>
        <div id="overlay"></div>
        <div id="contenido" style="margin-left: 0px;">
            <div id="div_menu"><a id="abrir" class="abrir-cerrar" href="javascript:void(0)" onclick="mostrar()" style="display: inline;"><i id="menu" class="fa-solid fa-bars" style="color: rgb(5,47,64);"></i></a></div>
        </div>
        <a id="cerrar" class="abrir-cerrar" href="#" onclick="ocultar()" style="display: none;"></a>
        <div id="logos"><img id="logo" src="./img/logo.png" alt="Logo empresa">
            <img id="nombre" class="d-none d-lg-block" src="./img/logo_nombre.png" alt="Nombre empresa">
        </div>
        <div id="div_cesta"><a href="cesta.html"><i id="cesta" class="fa-solid fa-cart-shopping" style="color: rgb(5,47,64);"></i></a></div>
    </header>

    <div id="despegable"></div>

    <div id="fondo_contenido" class="container my-5">
        <h1>ATENCIÓN AL CLIENTE</h1>
        <p class="parr_quien">Por favor, si tienes alguna duda o algún problema contacte con el siguiente teléfono:</p>
        <p class="parr_quien" id="telefono"><i class="fa-solid fa-mobile" style="color: #000000;"></i>&nbsp;+34 697 265 164</p>
        <p class="parr_quien" id="text_form">O en caso contrario, también disponemos de un formulario de contacto:</p>
        <?php
                include "conexion.php";
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obtener los datos del formulario
                    $nombre = $_POST['nombre'];
                    $email = $_POST['email'];
                    $texto = $_POST['mensaje'];
                    $sql = "INSERT INTO `contacto` (`nombre_i`, `email_i`, `incidencia_texto`) 
                    VALUES ('$nombre', '$email', '$texto')";
                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute()) {
                        echo "<script>alert('Incidencia enviada correctamente, nos pondremos en contacto contigo vía email.');</script>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            ?>
        <form class="contactoform" action="contacto.php" method="post">
            <div class="form-group">
                <label for="nombre" class="text_formulario">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="email" class="text_formulario">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mensaje" class="text_formulario">Mensaje:</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <footer class="text-center py-4 bg-light">
        <p>&copy; 2024 CyberSphere Technologies. David Díaz y Héctor Marín.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-ZMKt2E7MH5CgjkBuvqVPik4U4H4HiFAtRLWZ01DBD41qk9MrHxnELG8eGAtLheYI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-8MndfRxcbDg4SY6pqlg2R9su6R9eIFix3O5lR5N0TFvzp6N5bGpHzprk/RRAEzv0" crossorigin="anonymous"></script>
</body>

</html>
