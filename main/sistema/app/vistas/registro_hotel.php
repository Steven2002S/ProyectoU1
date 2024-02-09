<?php
    // Inicia la sesión
    session_start();
    require_once  ('../.././php/conexion/conexion.php');
    $conn = ConexionManager::obtenerConexionDesdeSesion();
    // Obtén la instancia de la conexión
    $result_ciudades = $conn->getConexion()->query("SELECT * FROM ciudad;");
    $ciudades = ($result_ciudades->num_rows > 0) ? $result_ciudades->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Formulario de registro hotelero</title>
    <style>
        .checkbox-item {
            display: inline-block;
            margin-right: 30px;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="">Regitro de hoteles</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">Configuración</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Salir</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav_content">
        <div class="container p-5">
            <h3 class="text-center mb-5">Registo de empresa hotelera</h3>
            <div class="card mb-4" id="form-registrar">
                <div class="card-header"><i class="fas fa-table mr-1"></i><b>Registro</b></div>
                <div class="card-body">
                    <form action="../../php/post/registrar_hotel.php" method="post" onsubmit="enviarJson()" id="form_registro">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-12">
                                <div class="form-group">
                                    <label>Nombre del hotel</label>
                                    <input type="text" class="form-control" name="nombre">
                                </div>
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <input type="text" class="form-control" name="direccion">
                                </div>
                                <div class="form-group">
                                    <label>Correo electrónico</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Ciudad</label>
                                    <select class="form-control" name="ciudad" id="ciudad">
                                        <option value="">-- Seleccione una ciudad --</option>
                                        <?php
											foreach ($ciudades as $ciudad) {
												echo "<option value='{$ciudad['id_ciudad']}'>{$ciudad['nombre']}</option>";
											}
											?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="number" class="form-control" minlength="10" maxlength="10"  name="telefono">
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-12">
                                <div class="form-group">
                                    <label>Numero de habitaciones</label>
                                    <input type="number" class="form-control" name="numHabitaciones" id="numHabitaciones"  onchange="crearCheckboxes()">
                                </div>
                                <div class="row">
                                    <div class="col form-group">
                                        <label>Tipo de habitación</label>
                                        <select name="tipo" id="tipo" class="form-control">
                                            <option value="">-- Seleccione el tipo --</option>
                                            <option value="Single">Single</option>
                                            <option value="Double">Double</option>
                                            <option value="Triple">Triple</option>
                                            <option value="Familiar">Familiar</option>
                                            <option value="Suite">Suite</option>
                                        </select>
                                    </div>
                                    <div class="col form-group">
                                        <label>Nuevo tipo de habitacion (OPCIONAL)</label>
                                        <input type="text" class="form-control" id="nuevoTipo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Descripcion de la habitacion</label>
                                    <input type="text" class="form-control" id="descripcionHabitacion">
                                </div>
                                <div class="row">
                                    <div class="col form-group">
                                        <label>Capacidad</label>
                                        <input type="text" class="form-control" id="capacidad" name="capacidad">
                                    </div>
                                    <div class="col form-group">
                                        <label>Precio</label>
                                        <input type="text" class="form-control" id="precio" name="precio" pattern="^\d+(\.\d{1,2})?$" title="Ingrese un precio válido (puede contener hasta 2 decimales)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><b>Marque las habitaciones de tipo seleccionado</b></label>
                                    <div class="form-group form-check" id="checkboxContainer" name="checkboxContainer">
                                        <!-- Los checkboxes se agregarán aquí -->
                                    </div>
                                </div>
                                <button type="button" onclick="agregarHabitacion()" class="btn btn-primary btn-block">Agregar tipo de habitacion</button>
                                <div class="text-center mx-auto">
                                    <br>
                                    <h4>Habitaciones Agregadas</h4>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Descripción</th>
                                                <th>Habitaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaHabitaciones">
                                            <!-- Aquí se agregarán las filas de la tabla -->
                                        </tbody>
                                    </table>
                                </div>
                                <input type="hidden" name="habitacionesView" id="habitacionesViewInput" value="">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>

    $(document).ready(function() {

        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-zA-Z\sáéíóúüñÁÉÍÓÚÜÑ]+$/.test(value);
        }, "Ingrese solo letras.");

        $.validator.addMethod("integerOnly", function(value, element) {
            return this.optional(element) || (Number.isInteger(Number(value)) && Number(value) > 0);
        }, "Ingrese solo números enteros o positivo.");

        $("#form_registro").validate({
            rules: {
                nombre: {
                    required: true,
                    lettersonly: true,
                },
                direccion: "required",
                email: {
                    required: true,
                    email: true
                },
                ciudad: "required",
                telefono: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10,
                    integerOnly: true,
                },
                numHabitaciones: {
                    required: true,
                    number: true,
                    integerOnly: true,
                },
                tipo: "required",
                capacidad: {
                    required: true,
                    number: true,
                    integerOnly: true,
                },
                precio: {
                    required: true,
					number: true,
                },
            },
            messages: {
                nombre: {
                    required: "Este campo es obligatorio.",
                    lettersonly: "Este campo debe contener solo letras."
                },
                direccion: "Este campo es obligatorio.",
                email: {
                    required: "Este campo es obligatorio.",
                    email: "Ingrese una dirección de correo electrónico válida."
                },
                ciudad: "Seleccione una ciudad.",
                telefono: {
                    required: "Este campo es obligatorio.",
                    number: "Ingrese un número válido.",
                    minlength: "La teléfono debe tener 10 digitos.",
                    maxlength: "La teléfono debe tener 10 digitos.",
                    integerOnly: "Ingrese solo números enteros o positivo."
                },
                numHabitaciones: {
                    required: "Este campo es obligatorio.",
                    number: "Ingrese un número válido.",
                    integerOnly: "Ingrese solo números enteros o positivo."
                },
                tipo: "Seleccione el tipo de habitación",
                capacidad: {
                    required: "Este campo es obligatorio.",
                    number: "Ingrese un número válido.",
                    integerOnly: "Ingrese solo números enteros o positivo."
                },
                precio: {
                    required: "Este campo es obligatorio.",
					number: "Ingrese un número válido.",
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

        $("#form_regiso").submit(function(e){
            e.preventDefault();

            // Obtener los datos del formulario
            var formData = $(this).serialize();

            // Realizar la petición AJAX
            $.ajax({
                url: "../../php/post/registrar_hotel.php",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response){
                    // Manejar la respuesta del servidor
                    if(response.status === "success"){
                        // ...
                    } else if(response.status === "error" && response.message === "error_permisos") {
                        alert("El usuario  no tiene permisos para realizar esta acción.");
                    } else {
                        console.log(response.message);
                    }
                },
                error: function(e){
                    // Mostrar mensaje de error en caso de falla en la petición AJAX
                    //$("#mensaje").html('<div class="alert alert-danger">Error de conexión.</div>');
                    console.log(e);
                }
            });
        });

    });

    var habitacionesView = [];
    var check;

    function enviarJson(){
        document.getElementById("habitacionesViewInput").value = JSON.stringify(habitacionesView);
    }

    function agregarHabitacion() {
        // Obtener valores de los campos
        var tipoHabitacion = document.getElementById("nuevoTipo").value == "" ? document.getElementById("tipo").value : document.getElementById("nuevoTipo").value;
        var descripcion = document.getElementById("descripcionHabitacion").value;
        var capacidad = document.getElementById("capacidad").value;
        var precio = document.getElementById("precio").value;
        var checkboxes = document.querySelectorAll('#checkboxContainer input[type="checkbox"]:checked');
        // Crear objeto con la información de la habitación
        var habitacion = {
            tipo: tipoHabitacion,
            descripcion: descripcion,
            capacidad: capacidad,
            precio: precio,
            habitaciones: []
        };
        // Agregar habitaciones seleccionadas al objeto
        checkboxes.forEach(function (checkbox) {
            // Verificar si 'check' está definido y si el checkbox actual estaba marcado previamente
            if (check && Array.from(check).indexOf(checkbox) === -1) {
                habitacion.habitaciones.push(checkbox.nextSibling.textContent.trim());
            } else if (!check || (check && Array.from(check).indexOf(checkbox) === -1)) {
                habitacion.habitaciones.push(checkbox.nextSibling.textContent.trim());
            }
        });
        // Actualizar la variable 'check' con los checkboxes actuales
        check = checkboxes;
        // Agregar objeto al array global
        habitacionesView.push(habitacion);
        // Actualizar la tabla con las habitaciones
        actualizarTablaHabitaciones();
        // Mostrar array global en la consola (puedes ajustar esto según tus necesidades)
        console.log(habitacionesView);
    }

    function actualizarTablaHabitaciones() {
    var tablaHabitaciones = document.getElementById("tablaHabitaciones");
    // Limpiar contenido actual
    tablaHabitaciones.innerHTML = "";
    // Agregar filas a la tabla
    habitacionesView.forEach(function (habitacion, index) {
        var fila = document.createElement("tr");
        var tipoCel = document.createElement("td");
        tipoCel.textContent = habitacion.tipo;
        var descCel = document.createElement("td");
        descCel.textContent = habitacion.descripcion;
        var habCel = document.createElement("td");
        habCel.textContent = habitacion.habitaciones.join(", ");
        var eliminarCel = document.createElement("td");
        // Crear botón de eliminar
        var botonEliminar = document.createElement("button");
        botonEliminar.classList.add("btn", "btn-danger");
        botonEliminar.textContent = "Eliminar";
        // Asignar el índice de la habitación en el array global como un atributo del botón
        botonEliminar.setAttribute("data-index", index);
        // Agregar evento de clic al botón para llamar a la función eliminarHabitacion
        botonEliminar.addEventListener("click", eliminarHabitacion);
        // Agregar botón de eliminar a la celda
        eliminarCel.appendChild(botonEliminar);
        // Agregar celdas a la fila
        fila.appendChild(tipoCel);
        fila.appendChild(descCel);
        fila.appendChild(habCel);
        fila.appendChild(eliminarCel);
        // Agregar fila a la tabla
        tablaHabitaciones.appendChild(fila);
    });
}

function eliminarHabitacion(event) {
    // Obtener el índice de la habitación a eliminar desde el atributo del botón
    var index = event.target.getAttribute("data-index");
    // Obtener las habitaciones asociadas a la fila que se va a eliminar
    var habitacionesAEliminar = habitacionesView[index].habitaciones;
    // Eliminar la habitación del array global
    habitacionesView.splice(index, 1);
    // Desmarcar las casillas de verificación asociadas a las habitaciones eliminadas
    habitacionesAEliminar.forEach(function(habitacion) {
        var checkboxes = document.querySelectorAll('#checkboxContainer input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            if (checkbox.nextSibling.textContent.trim() === habitacion) {
                checkbox.checked = false;
                check.checked = false;
            }
        });
    });
    // Actualizar la tabla con las habitaciones
    actualizarTablaHabitaciones();
    // Mostrar array global en la consola (puedes ajustar esto según tus necesidades)
    console.log(habitacionesView);
}

/*
function eliminarHabitacion(event) {
    // Obtener el índice de la habitación a eliminar desde el atributo del botón
    var index = event.target.getAttribute("data-index");
    
    // Obtener las habitaciones asociadas a la fila que se va a eliminar
    var habitacionesAEliminar = habitacionesView[index].habitaciones;

    // Eliminar la habitación del array global
    habitacionesView.splice(index, 1);

    // Desmarcar las casillas de verificación asociadas a las habitaciones eliminadas en la variable 'check'
    if (check) {
        check.forEach(function (checkbox) {
            if (habitacionesAEliminar.includes(checkbox.nextSibling.textContent.trim())) {
                checkbox.checked = false;
            }
        });
    }

    // Desmarcar las casillas de verificación asociadas a las habitaciones eliminadas en el contenedor
    habitacionesAEliminar.forEach(function (habitacion) {
        var checkboxes = document.querySelectorAll('#checkboxContainer input[type="checkbox"]');
        checkboxes.forEach(function (checkbox) {
            if (checkbox.nextSibling.textContent.trim() === habitacion) {
                checkbox.checked = false;
            }
        });
    });

    // Actualizar la tabla con las habitaciones
    actualizarTablaHabitaciones();
    // Mostrar array global en la consola (puedes ajustar esto según tus necesidades)
    console.log(habitacionesView);
}
*/

    function crearCheckboxes() {
        // Obtener el valor del input de número de habitaciones
        var numHabitaciones = document.getElementById("numHabitaciones").value;
        // Obtener el div contenedor de checkboxes
        var checkboxContainer = document.getElementById("checkboxContainer");
        // Limpiar checkboxes existentes
        checkboxContainer.innerHTML = "";
        // Crear checkboxes
        for (var i = 1; i <= numHabitaciones; i++) {
            // Crear elemento de checkbox
            var checkboxItem = document.createElement("div");
            checkboxItem.classList.add("checkbox-item");
            // Crear checkbox
            var checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.classList.add("form-check-input");
            // Crear label
            var label = document.createElement("label");
            label.classList.add("form-check-label");
            label.textContent = "hab." + i + "  ";
            // Agregar checkbox y label al contenedor
            checkboxItem.appendChild(checkbox);
            checkboxItem.appendChild(label);
            // Agregar item de checkbox al div principal
            checkboxContainer.appendChild(checkboxItem);
        }
    }

</script>

</html>