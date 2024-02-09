<?php
session_start();
ob_start();
require_once '../conexion/conexion.php';

$conn = ConexionManager::obtenerConexionDesdeSesion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger valores del formulario
    $nombre = strtoupper(trim($_POST["nombre"]));
    $direccion = strtoupper(trim($_POST["direccion"]));
    $email = $_POST["email"];
    //$pais = $_POST["pais"];
    $ciudad = $_POST["ciudad"];
    $telefono = $_POST["telefono"];

    $habitacionesView = json_decode($_POST['habitacionesView'], true);

    // Insertar datos en la tabla Hotel
    $sqlHotel = "INSERT INTO hotel (nombre, direccion, id_ciudad, telefono, correo_electronico) 
                    VALUES ('$nombre', '$direccion', '$ciudad', '$telefono', '$email')";

    if ($conn->getConexion()->query($sqlHotel)) {
        $hotelId = $conn->getConexion()->insert_id;  // Obtener el ID del hotel recién insertado
        //print($hotelId);
        // Procesar tipos de habitación
        if (is_array($habitacionesView)) {
            // Iterar sobre el array de habitaciones
            foreach ($habitacionesView as $habitacion) {
                // Acceder a las propiedades individuales de cada habitación
                $tipo = $habitacion['tipo'];
                $descripcion = $habitacion['descripcion'];
                $capacidad = $habitacion['capacidad'];
                $precio = $habitacion['precio'];

                $sqlTipoHabitacion = "INSERT INTO tipo_habitacion (nombre, descripcion, capacidad, precio)
                VALUES ('$tipo', '$descripcion', '$capacidad', '$precio')";

                // Acceder al array de habitaciones dentro de cada habitación
                if ($conn->getConexion()->query($sqlTipoHabitacion) === TRUE) {
                    $tipoHabitacionId = $conn->getConexion()->insert_id;  // Obtener el ID del tipo de habitación recién insertado
                    $habitaciones = $habitacion['habitaciones'];

                    // Iterar sobre el array de habitaciones
                    foreach ($habitaciones as $habitacionIndividual) {
                        $sqlHabitacion = "INSERT INTO habitacion (id_tipo_habitacion, id_hotel, numero, disponibilidad)
                            VALUES ('$tipoHabitacionId', '$hotelId', '$habitacionIndividual', 1)";
                        $conn->getConexion()->query($sqlHabitacion);
                    }
                }
            }
        }
        header('Location: /sistema/app/dashboard/principal.php?id_hotel=' . $hotelId);
        ob_end_flush();
        //echo "Registro exitoso";
    } else {
        echo "Error: " . $sqlHotel . "<br>" . $conn->getConexion()->error;
    }

}

?>