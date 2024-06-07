<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"])) {
        $id = $_POST["id"];

        // Verificar si el producto está en el carrito
        if (!empty($_SESSION['carrito'][$id])) {
            // Eliminar el producto del carrito
            unset($_SESSION['carrito'][$id]);
            // Enviar respuesta exitosa
            echo json_encode(['response' => 200, 'message' => 'Producto eliminado correctamente del carrito.']);
        } else {
            // Enviar respuesta si el producto no se encuentra en el carrito
            echo json_encode(['response' => 404, 'message' => 'Producto no encontrado en el carrito.']);
        }
    } else {
        // Enviar respuesta si no se proporciona el ID del producto
        echo json_encode(['response' => 400, 'message' => 'ID de producto no especificado.']);
    }
} else {
    // Enviar respuesta si el método de solicitud no es POST
    echo json_encode(['response' => 405, 'message' => 'Método no permitido.']);
}
?>
