<?php
session_start();
ob_start();
require_once '../conexion/conexion.php';

$conn = ConexionManager::obtenerConexionDesdeSesion();

// Función para escapar las variables y prevenir la inyección de SQL
function limpiar($conn, $datos) {
    return mysqli_real_escape_string($conn->getConexion(), $datos);
}

// Obtener la cédula del formulario y limpiarla para evitar inyección de SQL
$cedula = limpiar($conn, $_POST['cedula']);
$id_hotel = limpiar($conn, $_POST['id_hotel']);

// Verificar si la cédula ya existe
$checkQuery = "SELECT id_cliente FROM cliente WHERE cedula = '$cedula'";
$result = $conn->getConexion()->query($checkQuery);

if ($result->num_rows > 0) {
    // La cédula ya existe, enviar respuesta de error al cliente
    echo "Error: Ya existe un usuario con la cédula ingresada";
} else {
    // La cédula no existe, proceder con el registro

    // Obtener datos del formulario y limpiarlos para evitar inyección de SQL
    $id_ciudad = limpiar($conn, $_POST['ciudad']);
    $nombre = limpiar($conn, $_POST['nombre']);
    $apellido = limpiar($conn, $_POST['apellido']);
    $direccion = limpiar($conn, $_POST['direccion']);
    $telefono = limpiar($conn, $_POST['telefono']);
    $email = limpiar($conn, $_POST['email']);
    
    // Preparar la consulta SQL para el registro usando consultas preparadas
    $query = "CALL sp_insertar_cliente (?, ?, ?, ?, ?, ?, ?)";
    $statement = $conn->getConexion()->prepare($query);
    $statement->bind_param("issssss", $id_ciudad, $cedula, $nombre, $apellido, $direccion, $telefono, $email);

    // Ejecutar la consulta preparada
    if ($statement->execute()) {
        // Enviar respuesta al cliente indicando éxito
        header('Location: /sistema/app/vistas/vista_cliente.php?id_hotel='.$id_hotel);
        exit(); // Finalizar el script después de redirigir
    } else {
        // Enviar respuesta de error al cliente
        echo "Error al registrar el cliente.";
        // Guardar el error en la tabla de errores_auditoria
        $usuario = $_SESSION['conexion']['username']; // Asegúrate de tener la información del usuario en la sesión
        $sentencia_erronea = $query;
        $ip = $_SERVER['REMOTE_ADDR'];
        $fecha_hora = date('Y-m-d H:i:s');
        $motivo = $conn->getConexion()->error;
        $insertErrorQuery = "INSERT INTO errores_auditoria (usuario, sentencia_erronea, ip, fecha_hora, motivo) VALUES ('$usuario', '$sentencia_erronea', '$ip', '$fecha_hora', '$motivo')";
        $conn->getConexion()->query($insertErrorQuery);
    }
}

?>
