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
        echo "Registro exitoso";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ce9416b376.js" crossorigin="anonymous"></script>
    <script src="index.js"></script>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="container-fluid d-flex flex-column min-vh-100">
        <div class="row bg-white shadow-sm p-3 mb-4">
            <div class="col text-center">
                <a href="index.php"><img class="img-fluid logoemp" src="./img/logo.png"><img class="img-fluid logonom" src="./img/logo_nombre.png"></a>
            </div>
        </div>
        <div class="row flex-grow-1 d-flex justify-content-center align-items-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                <div class="card p-4 shadow-sm">
                    <h1 class="text-center mb-4">Crea tu cuenta</h1>
                    <form action="registro.php" method="post">
                        <div class="form-group">
                            <label for="usuario">Usuario:</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" maxlength="12" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Repetir Contraseña:</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">E-mail:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="form-group">
                            <label for="ciudad">Ciudad:</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo_postal">Código Postal:</label>
                            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" maxlength="5" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Crear cuenta</button>
                    </form>
                </div>
                <div class="text-center mt-3">
                    <p class="terms">Al continuar, aceptas las <a href="#">Condiciones de uso</a> y venta de CyberSphere Technologies. Consulta nuestro <a href="#">Aviso de privacidad</a>, nuestro <a href="#">Aviso sobre cookies</a> y nuestro <a href="#">Aviso sobre anuncios basados en intereses</a>.</p>
                </div>
                <div class="text-center mt-2">
                    <p class="help"><a href="contacto.html">¿Necesitas ayuda? Contacta con nosotros aquí</a></p>
                </div>
            </div>
        </div>
        <footer class="bg-primary text-white text-center py-3 mt-auto">
            <p>&copy; 2024 CyberSphere Technologies. David Díaz y Héctor Marín.</p>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
