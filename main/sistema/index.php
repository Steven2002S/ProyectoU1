<?php
// Inicia la sesión si no está iniciada
if (!session_id()) {
    session_start();
}

// Verifica si hay un mensaje de error
$loginError = isset($_SESSION['conexion']["login_error"]) ? $_SESSION['conexion']["login_error"] : "";
// Limpia la variable de sesión después de mostrar el mensaje
unset($_SESSION['conexion']["login_error"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>

#miVentana {
    /* ... Otros estilos ... */
    opacity: 0; /* Inicialmente, establece la opacidad en 0 */
    transition: opacity 0.5s ease-in-out; /* Agrega una transición de opacidad con duración de 0.5 segundos */
}

#miVentana.mostrar {
    opacity: 1; /* Cuando tiene la clase 'mostrar', establece la opacidad en 1 */
}
.ventana-flotante {
            position: fixed;
            top: 150px;
            right: 20px;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: none;
        }

        .ventana-flotante h2 {
            margin-top: 0;
        }

        .cerrar {
            position: absolute;
            top: 0px;
            right: 0px;
            cursor: pointer;
            width: 30px;
            height: 30px;
            
            
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: background-color 0.5s ease; /* Transición de color */
        }

        .cerrar:hover {
            background-color: #e74c3c; /* Color al pasar el cursor */
            color: #fff;
        }


        .error {
            color: #dc3545;
            padding: 7px;
        }
        .is-invalid {
            border: 1px solid #dc3545;
        }

    </style>
</head>
<body>
    <section class="pt-5 pb-5 mt-0 align-items-center d-flex bg-dark" style="min-height: 100vh; background-size: cover; background-image: url(https://realestatemarket.com.mx/images/2022/02-feb/1002/nuevos-hoteles-en-mexico-ok-g.jpg);">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center d-flex-row text-center">
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card shadow rounded">
                        <div class="card-body mx-auto">
                            <h4 class="card-title mt-3 text-center pb-4">Iniciar sesión</h4>
                            <form action="php/login/login.php" method="post" id="form-login">
                                <div class="form-group p-2">
                                    <input type="text" name="usuario" class="form-control" placeholder="Usuario">
                                </div>
                                <div class="form-group p-2">
                                    <input type="password" name="contrasena" class="form-control" placeholder="Contraseña">
                                </div>
                                <div class="p-3">
                                    <button type="submit" class="btn btn-success btn-block rounded-pill" id="btn-ingresar">Ingresar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="miVentana" class="ventana-flotante">
        <div class="cerrar" onclick="closeErrorPopup()">X</div>
        <h6>Mensaje del sistema</h6>
        <p id="error-message"></p>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
    function showErrorPopup(message) {
        document.getElementById('error-message').innerHTML = message;
        document.getElementById('miVentana').style.display = 'block';
    }

    // Cierra la ventana flotante
    function closeErrorPopup() {
        document.getElementById('miVentana').style.display = 'none';
    }

    // Muestra el mensaje de error si existe
    <?php
    if (!empty($loginError)) {
        echo "showErrorPopup('$loginError');";
    }
    ?>

    // Cierra la ventana flotante al hacer clic en la "x"
    document.querySelector('.cerrar').addEventListener('click', function () {
        closeErrorPopup();
    });

    // Cierra la ventana flotante después de 7 segundos y elimina la clase 'mostrar'
    function autoCloseErrorPopup() {
        setTimeout(function () {
            closeErrorPopup();
        }, 7000); // 7000 milisegundos = 7 segundos
    }

    // Muestra la ventana flotante con la clase 'mostrar' y activa el temporizador
    function showErrorPopup(message) {
        var popup = document.getElementById('miVentana');
        var errorMessage = document.getElementById('error-message');
        
        errorMessage.innerText = message;
        popup.style.display = 'block';

        // Agrega la clase 'mostrar' para activar la animación de desvanecimiento
        popup.classList.add('mostrar');

        // Activa el temporizador para cerrar la ventana después de 7 segundos
        autoCloseErrorPopup();
    }

    // Cierra la ventana flotante y elimina la clase 'mostrar'
    function closeErrorPopup() {
        var popup = document.getElementById('miVentana');
        popup.classList.remove('mostrar');
        
        // Agrega un pequeño retraso antes de ocultar la ventana para permitir que se complete la animación de desvanecimiento
        setTimeout(function () {
            popup.style.display = 'none';
        }, 500); // 500 milisegundos = 0.5 segundos (la misma duración que la transición en CSS)
    }

    $("#form-login").validate({
    rules: {
        usuario: {
            required: true,
        },
        contrasena: {
            required: true,
        },
    },
    messages: {
        usuario: {
            required: "Este campo es obligatorio.",
        },
        contrasena: {
            required: "Este campo es obligatorio.",
        },
    },
    errorClass: "error",
    errorElement: "small",
    highlight: function (element, errorClass, validClass) {
        $(element).addClass("is-invalid");
        $(element).removeClass("is-valid");
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass("is-invalid");
        $(element).addClass("is-valid");
    },
    errorPlacement: function(error, element) {
        error.addClass("text-danger");
        error.insertAfter(element);
    },
    });

});
</script>
</html>
