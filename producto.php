<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Inicializar variables
$nombre = "Documento"; // Título por defecto
$descripcion = "";
$precio = "";
$imagen = "";
$marca = "";

// Verificar si se ha pasado un ID de producto en la URL
if (isset($_GET['id_producto'])) {
    $id = $_GET['id_producto'];

    // Consulta SQL para obtener los detalles del producto
    $sql = "SELECT nombre, descripcion, precio_ud, imagen, marca FROM producto WHERE id_producto = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Verificar si se encontró el producto
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombre = $row["nombre"];
        $descripcion = $row["descripcion"];
        $precio = number_format($row["precio_ud"], 2, '.', '');
        $imagen = $row["imagen"];
        $marca = $row["marca"];
    } else {
        $nombre = "Producto no encontrado";
    }
} else {
    $nombre = "ID de producto no especificado";
}

// Cerrar la conexión
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/ce9416b376.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="producto.css">
    <title><?php echo htmlspecialchars($nombre); ?></title>
</head>
<body>
<div class="producto-detalles">
    <?php if (!empty($imagen)): ?>
        <img class="img-fluid" src="<?php echo htmlspecialchars($imagen); ?>" alt="<?php echo htmlspecialchars($nombre); ?>">
    <?php endif; ?>
    <h1><?php echo htmlspecialchars($nombre); ?></h1>
    <p><?php echo htmlspecialchars($descripcion); ?></p>
    <p>Marca: <?php echo htmlspecialchars($marca); ?></p>
    <p>Precio: <?php echo htmlspecialchars($precio); ?>€</p>
    <a href="index.php" class="btn-catalogo">Volver al catálogo</a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.producto-detalles').classList.add('show');
    });
</script>
</body>
</html>
