<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Página de administrador - CyberSphere Technologies</title>
    <link rel="stylesheet" href="admin.css">
  </head>
  <body>
	<script src="index.js"></script>
    <header class="cabadmin">
        <div class="tituloadmin">
        <?php 
                    if (isset($_SESSION['id_usuario'])) {
                        $username = htmlspecialchars($_SESSION['id_usuario'], ENT_QUOTES, 'UTF-8');
                        echo "<h1>Página de administrador, bienvenido $username !!</h1>";
                    } else {
                        echo "<h1>Página de administrador, <a href=\"login.php\" style=\"color: #ffffff;\">Identifícate</a>";
                    }
        ?>
       
        </div>
    </header>
    <div>
        <h3>Bienvenido a la página de administrador de CyberSphere Technologies. Desde esta páginas podrás borrar usuarios, crear usuarios, otorgar permisos de administrador a usuarios ya existentes y actualizar datos de usuarios.</h3>
        <h4><?php 
        if (isset($_SESSION['id_usuario'])) {
                    echo "<label for=\"usuario\">¿Quieres cerrar sesión?</label><br><br>
                    <form class=\"csea\" action=\"cerrarsesion.php\" method=\"post\">
                        <input class=\"inputcses\" type=\"submit\" value=\"Cerrar Sesión\">
                    </form>";
        }
        ?></h4>
        <ul>
        <li class="lista">Crear un usuario nuevo: </li>
        <?php
            include "conexion.php";
            if (isset($_POST['insertar'])) {
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
                $sql = "INSERT INTO `usuario` (`id_usuario`, `password`, `correo`, `ciudad`, `cp`, `rol`, `estado`) 
                VALUES ('$username', '$hashed_password', '$email', '$city', '$cp', '0', '1')";
                $stmt = $conn->prepare($sql);
                if ($stmt->execute()) {
                    echo "<script>alert('Se ha creado el usuario correctamente.');</script>";
                    header("Location: admin.php"); //Redirigiralapáginadeiniciodesesióndespuésdelregistro
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }}
                elseif ($password !== $confirm_password){
                    echo "<script>alert('Las contraseñas no coinciden.');</script>";
                }
            }
?>
        <form action="admin.php" method="post">
                        <label for="usuario">Usuario:</label>
                        <input type="text" id="usuario" name="usuario" required>
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
                        <input type="text" id="codigo_postal" name="codigo_postal" required>
                        <br><br>
                        <input name="insertar" class="inputlog" type="submit" value="Crear usuario">
        </form>
        <li class="lista">Borrar usuario:</li>
        <?php
// Incluir el archivo de conexión
include "conexion.php";
if (isset($_POST['borrar'])) {
    $usernameb = $_POST['usuariob'];
    // Preparar y ejecutar la consulta para buscar al usuario
    $sql = "SELECT `id_usuario`, `rol` FROM `usuario` WHERE `id_usuario` LIKE '$usernameb'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    // Verificar si se encontró el usuario
    if ($stmt->rowCount() == 1) {
        $userb = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($userb['rol']==0) {
                $sql = "DELETE FROM usuario WHERE `usuario`.`id_usuario` = '$usernameb'";
                $stmt = $conn->prepare($sql);
                if ($stmt->execute()) {
                    echo "<script>alert('El usuario se ha borrado correctamente.');</script>";
                    header("Location: admin.php"); // Redirigir a la página de admin después del registro
                    exit;
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
        }else {
            echo "<script>alert('No puedes borrar un usuario administrador.');</script>";
        }
    } else {
        // El usuario no existe
        echo "<script>alert('El usuario no existe.');</script>";
    }
}
?>
        <form action="admin.php" method="post">
                        <label for="usuario">Usuario:</label>
                        <input type="text" id="usuariob" name="usuariob" required>
                        <br><br>
                        <input name="borrar" class="inputlog" type="submit" value="Borrar usuario">
        </form>
        <li class="lista">Otorgar rol de administrador al siguiente usuario:</li>
        <?php
// Incluir el archivo de conexión
include "conexion.php";
if (isset($_POST['admini'])) {
    $usernamea = $_POST['usuarioa'];
    // Preparar y ejecutar la consulta para buscar al usuario
    $sql = "SELECT `id_usuario`, `rol` FROM `usuario` WHERE `id_usuario` LIKE '$usernamea'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    // Verificar si se encontró el usuario
    if ($stmt->rowCount() == 1) {
        $usera = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usera['rol']==0) {
                $sql = "UPDATE `usuario` SET `rol` = '1' WHERE `usuario`.`id_usuario` = '$usernamea';";
                $stmt = $conn->prepare($sql);
                if ($stmt->execute()) {
                    echo "<script>alert('Se ha convertido en administrador correctamente.');</script>";
                    //header("Location: admin.php"); // Redirigir a la página de admin después del registro
                    exit;
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
        }else {
            echo "<script>alert('Ya es administrador.');</script>";
        }
    } else {
        // El usuario no existe
        echo "<script>alert('El usuario no existe.');</script>";
    }
}
?>
            <form action="admin.php" method="post">
                            <label for="usuario">Usuario:</label>
                            <input type="text" id="usuarioa" name="usuarioa" required>
                            <br><br>
                            <input name="admini" class="inputlog" type="submit" value="Hacer administrador">
            </form>
        <li class="lista">Escribe el usuario que quieres actualizar, luego selecciona el campo y luego escribe el nuevo valor:</li>
        <form action="admin.php" method="post">
                            <label for="usuario">Usuario:</label>
                            <input type="text" id="usuariou" name="usuariou" required>
                            <br><br>
                            <input type="radio" name="group" value="id_usuario" checked>Nombre de usuario
                            <input type="radio" name="group" value="password">Contraseña
                            <input type="radio" name="group" value="ciudad">Ciudad
                            <br><br>
                            <label for="nuevovalor">Nuevo valor:</label>
                            <input type="text" name="nuevovalor" required>
                            <br><br>
                            <input name="actualizar" class="inputlog" type="submit" value="Actualizar">
        </form>
        <?php
include "conexion.php";
if (isset($_POST['actualizar'])) {
    $usernameu = $_POST['usuariou'];
    $campo = $_POST['group'];
    $nuevovalor = $_POST['nuevovalor'];
    $sql = "SELECT `id_usuario` FROM `usuario` WHERE `id_usuario` LIKE '$usernameu'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        if ($campo=="password"){
            $hashed_nv = password_hash($nuevovalor, PASSWORD_DEFAULT);
            $sql = "UPDATE `usuario` SET `$campo` = '$hashed_nv' WHERE `usuario`.`id_usuario` = '$usernameu';";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute()) {
            echo "<script>alert('Se ha actualizado la contraseña correctamente.');</script>";
            exit;
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }elseif ($campo!=="contraseña"){
        $sql = "UPDATE `usuario` SET `$campo` = '$nuevovalor' WHERE `usuario`.`id_usuario` = '$usernameu';";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute()) {
            echo "<script>alert('Se ha actualizado correctamente.');</script>";
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }}
    } else {
        echo "<script>alert('El usuario no existe.');</script>";
    }
}
?>
        </ul>
    </div>

  </body>
</html>