<?php
include 'header.php';
include 'conexion.php';

// Procesar el formulario de agregar cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $genero = $_POST['genero'];

    agregarCliente($cedula, $nombre, $email, $fechaNacimiento, $direccion, $telefono, $genero);

    // Redireccionar a la página principal después de agregar
    header("Location: index.php");
    exit();
}

?>

<div class="content">
    <h2>Agregar Nuevo Cliente</h2>
    <form action="agregar_cliente.php" method="post">
        <label for="cedula">Cédula:</label>
        <input type="text" name="cedula" required>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" required>
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required>
        <label for="genero">Género:</label>
        <select name="genero" required>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select>
        <button type="submit">Agregar Cliente</button>
    </form>
</div>

<?php include 'footer.php'; ?>
