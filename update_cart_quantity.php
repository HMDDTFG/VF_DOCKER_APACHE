<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"]) && isset($_POST["cantidad"])) {
        $id = $_POST["id"];
        $cantidad = $_POST["cantidad"];

        // Verificar si el producto está en el carrito
        if (!empty($_SESSION['carrito'][$id])) {
            // Actualizar la cantidad del producto en el carrito
            if ($cantidad > 0) {
                $_SESSION['carrito'][$id]['cantidad'] = $cantidad;
            } else {
                // Eliminar el producto del carrito si la cantidad es 0
                unset($_SESSION['carrito'][$id]);
            }
            // Enviar respuesta exitosa
            echo json_encode(['response' => 200, 'message' => 'Cantidad actualizada correctamente.']);
        } else {
            echo json_encode(['response' => 404, 'message' => 'Producto no encontrado en el carrito.']);
        }
    } else {
        echo json_encode(['response' => 400, 'message' => 'Parámetros incorrectos.']);
    }
} else {
    echo json_encode(['response' => 405, 'message' => 'Método no permitido.']);
}
?>
