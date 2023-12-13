<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Hoteles</title>
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

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 8px;
        }

        input, button {
            margin-top: 8px;
            padding: 10px;
            width: 300px;
            box-sizing: border-box;
        }

        button {
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #2c3e50;
            color: #ecf0f1;
        }

        a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            font-size: 18px;
            transition: color 0.3s;
        }

        a:hover {
            color: #2980b9;
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
        <img src="" alt="Logo Hotel" class="logo">
        <h1>Gestión de Hoteles</h1>
    </header>

    <img src="background.jpg" alt="Fondo" class="background-image">

    <div class="content">
        <form action="crear_hotel.php" method="POST">
            <label for="nombre">Nombre del Hotel:</label>
            <input type="text" name="nombre" required>

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" required>

            <button type="submit">Crear Hotel</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí deberías obtener y mostrar los hoteles desde la base de datos -->
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="editar_hotel.php?id=1">Editar</a> |
                        <a href="eliminar_hotel.php?id=1">Eliminar</a>
                    </td>
                </tr>
                <!-- Repite esta estructura para cada hotel -->
            </tbody>
        </table>

        <a href="inicio.php">Volver a Inicio</a>
    </div>
</body>
</html>
