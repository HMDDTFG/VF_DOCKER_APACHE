<?php
session_start();
// Comprueba si existe el id en la sesión

$id = 'producto_'. $_POST['id'];
if (empty($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id] = [
        "price" => $_POST['price'], 
        "name" => $_POST['name'], 
        "img" => $_POST['img'],      
        "id" => $_POST['id'],   
        "cantidad" => 1            
    ];
} else {
    $_SESSION['carrito'][$id]['cantidad']++;
}
echo json_encode(['response'=>200]);
?>