<?php
include "conexion.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $username = $_POST['usuario'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['correo'];
    $city = $_POST['ciudad'];
    $cp = $_POST['codigo_postal'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT `id_usuario`, `password`, `rol` FROM `usuario` WHERE `id_usuario` LIKE '$username'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('El usuario ya existe.');</script>";
    }
    elseif ($password == $confirm_password) {
    // Preparar y ejecutar la consulta de inserción
    $sql = "INSERT INTO `usuario` (`id_usuario`, `password`, `correo`, `ciudad`, `cp`, `rol`, `estado`) 
    VALUES ('$username', '$hashed_password', '$email', '$city', '$cp', '0', '1')";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        header("Location: login.php"); // Redirigir a la página de inicio de sesión después del registro
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }}
    elseif ($password !== $confirm_password){
        echo "<script>alert('Las contraseñas no coinciden.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberSphere Technologies</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="registro.css">
    <script src="https://kit.fontawesome.com/ce9416b376.js" crossorigin="anonymous"></script>
    <script src="index.js"></script>
</head>
<body>
    <div class="fondo_log">
        <div class="cabecera_log">
            <a href="index.php"><img class="logoemp" src="./img/logo.png"><img class="logonom" src="./img/logo_nombre.png"></a>
        </div>
        <div class="centro_log">
            <div class="cabecera_cen"></div>
            <div class="titulo_log">
                <h1 id="titlog">Crea tu cuenta</h1>
            </div>
            <div class="divform_log" id="divformlog">
                <div class="form_log">
                    <form action="registro.php" method="post">
                        <label for="usuario">Usuario:</label>
                        <input type="text" id="usuario" name="usuario" maxlength="12" required>
                        <br><br>
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" required>
                        <br><br>
                        <label for="confirm_password">Repetir Contraseña:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                        <br><br>
                        <label for="correo">E-mail:</label>
                        <input type="email" id="correo" name="correo" required>
                        <br><br>
                        <label for="ciudad">Ciudad:</label>
                        <input type="text" id="ciudad" name="ciudad" required>
                        <br><br>
                        <label for="codigo_postal">Código Postal:</label>
                        <input type="text" id="codigo_postal" name="codigo_postal" maxlength="5" required>
                        <br><br>
                        <input class="inputlog" type="submit" value="Crear cuenta">
                    </form>
                </div>
            </div>
            <div class="terms">
                <p class="termstexto">Al continuar, aceptas las Condiciones de uso y venta de CyberSphere Technologies. Consulta nuestro Aviso de privacidad, nuestro Aviso sobre cookies y nuestro Aviso sobre anuncios basados en intereses.</p>
            </div>
            <div class="help">
                <p class="termstexto"><a href="contacto.html">¿Necesitas ayuda? Contacta con nosotros aquí</a></p>
            </div>
        </div>
        <div class="eresnuevo">
            <p class="yaexistetexto">¿Ya tiene una cuenta?</p>
        </div>
        <a href="login.php"><div class="registroboton">
            <p class="textologin">Inicia sesión aquí</p>
        </div></a>
    </div>
    <footer>
        <p>&copy; 2024 CyberSphere Technologies. David Díaz y Héctor Marín.</p>
    </footer>
</body>
</html>
