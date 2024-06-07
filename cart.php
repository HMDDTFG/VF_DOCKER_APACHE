<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart.css">
    <title>Carrito de la Compra</title>
</head>
<body>
    <div class="container">
        <h3>Compras:</h3>
        <?php

        if (!empty($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $key => $producto) {
                echo '<div class="cart-item">';
                echo '<img src="' . $producto["img"] . '">';
                echo '<div class="item-details">';
                echo '<p class="item-name">' . $producto['name'] . '</p>';
                echo '<p class="item-price">' . $producto['price'] . ' €</p>';
                echo '<div class="item-quantity">';
                echo '<button class="subtract-btn" data-id="' . $key . '">-</button>';
                echo '<span>' . $producto['cantidad'] . '</span>';
                echo '<button class="add-btn" data-id="' . $key . '">+</button>';
                echo '<button class="delete-btn" data-id="' . $key . '">Eliminar</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p class="cart-empty">Carrito Vacío.</p>';
        }
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
    // Botón para restar cantidad
    $('.subtract-btn').click(function () {
        var id = $(this).closest('.cart-item').find('.add-btn').attr('data-id');
        var cantidadElement = $(this).siblings('span');
        var cantidad = parseInt(cantidadElement.text());
        if (cantidad > 1) {
            cantidad--;
            cantidadElement.text(cantidad);
            updateCartQuantity(id, cantidad);
        }
    });
    // Botón para sumar cantidad
    $('.add-btn').click(function () {
        var id = $(this).attr('data-id');
        var cantidadElement = $(this).siblings('span');
        var cantidad = parseInt(cantidadElement.text());
        cantidad++;
        cantidadElement.text(cantidad);
        updateCartQuantity(id, cantidad);
    });
    // Botón para eliminar producto del carrito
    $('.delete-btn').click(function () {
        var id = $(this).attr('data-id');
        deleteCartItem(id);
    });
    // Función para actualizar la cantidad en el carrito usando AJAX
    function updateCartQuantity(id, cantidad) {
        $.ajax({
            url: 'update_cart_quantity.php',
            type: 'post',
            data: { id: id, cantidad: cantidad },
            success: function (response) {
                console.log(response);
            }
        });
    }
    // Función para eliminar un producto del carrito usando AJAX
    function deleteCartItem(id) {
        $.ajax({
            url: 'delete_cart_item.php',
            type: 'post',
            data: { id: id },
            success: function (response) {
                console.log(response);
                // Recargar la página después de eliminar el producto del carrito
                location.reload();
            }
        });
    }
});
    </script>
</body>
</html>
