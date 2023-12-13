<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Gestión Hotelera</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

header {
    background-color: #2c3e50;
    color: #ecf0f1;
    padding: 20px;
    text-align: center;
}

.content {
    margin: 20px;
    text-align: center;
}

ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
    justify-content: center;
}

li {
    width: 100%; /* Ancho máximo de cada columna */
}

a {
    text-decoration: none;
    color: #3498db;
    font-weight: bold;
    font-size: 18px;
    transition: color 0.3s;
    display: block;
    padding: 15px;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

a:hover {
    color: #2980b9;
    background-color: violet; /* metodo hover */
}

.icon {
    margin-right: 10px;
}

.logo {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    margin-bottom: 20px;
}

.background-image {
    width: 100%;
    height: auto;
    opacity: 0.2;
    position: fixed;
    top: 0;
    left: 0;
    z-index: -1;
}
</style>
</head>
<body>
    <header>
        <img src="icono.avif" alt="Logo Hotel" class="logo">
        <h1>Gestión Hotelera</h1>
    </header>
    <img src="background.jpg" alt="Fondo" class="background-image">
    <div class="content">
        <ul>
            <li><a href="hoteles.php"><i class="fas fa-hotel icon"></i>Hoteles</a></li>
            <li><a href="habitaciones.php"><i class="fas fa-bed icon"></i>Habitaciones</a></li>
            <li><a href="clientes.php"><i class="fas fa-user icon"></i>Clientes</a></li>
            <li><a href="reservaciones.php"><i class="far fa-calendar-alt icon"></i>Reservaciones</a></li>
            <li><a href="pagos.php"><i class="fas fa-money-check icon"></i>Pagos</a></li>
            <li><a href="servicios.php"><i class="fas fa-concierge-bell icon"></i>Servicios</a></li>
            <li><a href="reservaciones_servicios.php"><i class="fas fa-calendar-plus icon"></i>Reservaciones de Servicios</a></li>
            <li><a href="empleados.php"><i class="fas fa-users icon"></i>Empleados</a></li>
            <!-- Agrega más enlaces según sea necesario -->
        </ul>
    </div>
</body>
</html>
