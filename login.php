<?php
session_start();
include "conexion.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['usuario'];
    $password = $_POST['contraseña'];
    $sql = "SELECT `id_usuario`, `password`, `rol` FROM `usuario` WHERE `id_usuario` LIKE '$username'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Las credenciales son correctas
            if ($user['rol']==0){
                $_SESSION['id_usuario'] = $user['id_usuario'];
                header("Location: index.php"); // Redirigir a la página de inicio
                exit;
            } else {
                $_SESSION['id_usuario'] = $user['id_usuario'];
                header("Location: admin.php"); // Redirigir a la página de administrador
                exit;
            }
        }else {
            echo "<script>alert('Contraseña incorrecta.');</script>";
        }
    } else {
        echo "<script>alert('El usuario no existe.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberSphere Technologies</title>
    <script src="https://kit.fontawesome.com/ce9416b376.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="index.js"></script>
    <link rel="stylesheet" href="login.css">   

</head>

<body>
    <div class="container">
        <div class="header">
            <a href="index.php"><img class="logoemp" src="./img/logo.png"><img class="logonom" src="./img/logo_nombre.png"></a>
        </div>
        <div class="content">
            <div class="login-form">
                <h1>Iniciar sesión</h1>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input type="text" id="usuario_login" name="usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="contraseña">Contraseña:</label>
                        <input type="password" id="contraseña_login" name="contraseña" required>
                    </div>
                    <input class="btn-login" type="submit" value="Iniciar Sesión">
                </form>
                <div class="terms">
                    <p>Al continuar, aceptas las Condiciones de uso y venta de CyberSphere Technologies. Consulta nuestro Aviso de privacidad, nuestro Aviso sobre cookies y nuestro Aviso sobre anuncios basados en intereses.</p>
                </div>
                <div class="help">
                    <p><a href="contacto.php">¿Necesitas ayuda? Contacta con nosotros aquí</a></p>
                </div>
            </div>
            <div class="eresnuevo">
                <p class="nuevotexto">¿Eres nuevo?</p>
            </div>
            <a href="registro.php">
                <div class="registroboton">
                    <p class="textoregistro">Crea tu cuenta en CyberSphere aquí</p>
                </div>
            </a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 CyberSphere Technologies. David Díaz y Héctor Marín.</p>
    </footer>
</body>

</html>