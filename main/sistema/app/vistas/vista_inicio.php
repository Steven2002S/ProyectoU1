<?php

// Inicia la sesión
session_start();

require_once('../.././php/conexion/conexion.php');
require_once('../.././php/get/datos_hotel.php');


// Verifica si el usuario está autenticado
if (!isset($_SESSION['username']) || !isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    // Si no está autenticado, redirige a la página de inicio de sesión o muestra un mensaje
    //header('Location: /ruta_a_tu_pagina_de_inicio_de_sesion.php');
   // exit();
}

$conn = ConexionManager::obtenerConexionDesdeSesion();

// Obtiene los hoteles utilizando la conexión
$hoteles = getHoteles($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* Personaliza el estilo para centrar el contenido del select */
        .custom-select {
            text-align-last: center;
        }
    </style>
</head>

<body>
    <section class="pt-5 pb-5 mt-0 align-items-center d-flex bg-dark"
        style="min-height: 100vh; background-size: cover; background-image: url(https://realestatemarket.com.mx/images/2022/02-feb/1002/nuevos-hoteles-en-mexico-ok-g.jpg);">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center d-flex-row text-center h-100">
                <div class="col-12 col-md-4 col-lg-3 h-75">
                    <div class="card shadow rounded">
                        <div class="card-body mx-auto">
                            <h4 class="card-title mt-3 text-center pb-4">Seleccione una empresa hotelera</h4>
                            <form action="../dashboard/principal.php" method="post">
                                <div class="form-group input-group">
                                    <!-- Agrega la clase 'custom-select' para centrar el contenido del select -->
                                    <select name="hotel" id="hotel" class="form-control custom-select">
                                        <option value="">--- Seleccione un hotel ---</option>
                                        <?php
                                            foreach ($hoteles as $hotel) {
                                                echo "<option class='custom-select' value='{$hotel['id_hotel']}'>{$hotel['nombre_hotel']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="p-3">
                                    <button type="submit" class="btn btn-success btn-block rounded-pill" id="btn-ingresar">Ingresar</button>
                                </div>
                                <p class="text-center">Añadir una empresa hotelera?
                                    <a href="registro_hotel.php" class="text-success">Nuevo</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
