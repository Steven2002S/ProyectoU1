<?php
include 'header.php';
include 'conexion.php';

// Obtener la lista de clientes desde la base de datos
$clientes = obtenerClientes();

?>

<div class="content">
    <h2>Listado de Clientes</h2>
    <table>
        <tr>
            <th>ID Cliente</th>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Fecha de Nacimiento</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Fecha de Registro</th>
            <th>Género</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($clientes as $cliente) : ?>
            <tr>
                <td><?php echo $cliente['id_cliente']; ?></td>
                <td><?php echo $cliente['cedula']; ?></td>
                <td><?php echo $cliente['nombre']; ?></td>
                <td><?php echo $cliente['email']; ?></td>
                <td><?php echo $cliente['fecha_nacimiento']; ?></td>
                <td><?php echo $cliente['direccion']; ?></td>
                <td><?php echo $cliente['telefono']; ?></td>
                <td><?php echo $cliente['fecha_registro']; ?></td>
                <td><?php echo $cliente['genero']; ?></td>
                <td>
                    <a href="editar_cliente.php?id=<?php echo $cliente['id_cliente']; ?>">Editar</a>
                    <a href="eliminar_cliente.php?id=<?php echo $cliente['id_cliente']; ?>" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include 'footer.php'; ?>
