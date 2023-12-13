<?php
include 'header.php';
include 'conexion.php';

// Verificar si se proporcionó un ID de cliente
if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];

    // Obtener la información del cliente para prellenar el formulario
    $cliente = obtenerClientePorId($idCliente);

    // Procesar el formulario de editar cliente
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $fechaNacimiento = $_POST['fecha_nacimiento'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $genero = $_POST['genero'];

        // Actualizar los datos del cliente
        actualizarCliente($idCliente, $cedula, $nombre, $email, $fechaNacimiento, $direccion, $telefono, $genero);

        // Redireccionar a la página principal después de editar
        header("Location: index.php");
        exit();
    }
} else {
    // Si no se proporcionó un ID válido, redirigir a la página principal
    header("Location: index.php");
    exit();
}

?>

<div class="content">
    <h2>Editar Cliente</h2>
    <form action="editar_cliente.php?id=<?php echo $idCliente; ?>" method="post">
        <label for="cedula">Cédula:</label>
        <input type="text" name="cedula" value="<?php echo $cliente['cedula']; ?>" required>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $cliente['nombre']; ?>" required>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $cliente['email']; ?>" required>
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" value="<?php echo $cliente['fecha_nacimiento']; ?>" required>
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" value="<?php echo $cliente['direccion']; ?>" required>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo $cliente['telefono']; ?>" required>
        <label for="genero">Género:</label>
        <select name="genero" required>
            <option value="Masculino" <?php echo ($cliente['genero'] === 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
            <option value="Femenino" <?php echo ($cliente['genero'] === 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
            <option value="Otro" <?php echo ($cliente['genero'] === 'Otro') ? 'selected' : ''; ?>>Otro</option>
        </select>
        <button type="submit">Guardar Cambios</button>
    </form>
</div>

<?php include 'footer.php'; ?>
