<?php
	/*session_start();
	require 'conexion.php';
	
	if(!isset($_SESSION['id'])){
		header("Location: index.php");
	}
	
	$id = $_SESSION['id'];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	
	if($tipo_usuario == 1){
		$where = "";
		} else if($tipo_usuario == 2){
		$where = "WHERE id=$id";
	}
	
	$sql = "SELECT * FROM usuarios $where";
	$resultado = $mysqli->query($sql);
	*/

	session_start();

	require_once  ('../.././php/get/datos_hotel.php');
	require_once  ('../.././php/conexion/conexion.php');
	require_once  ('../.././php/config/config.php');

	$conn = ConexionManager::obtenerConexionDesdeSesion();

	if($_GET['id_hotel']){

		$id_hotel = $_GET['id_hotel'];
        $id_habitacion = $_GET['id_habitacion'];

		// Obtener información del hotel
		$hotel_info = getHotelInfo($conn, $id_hotel);

		// Verificar si se encontraron resultados
		if ($hotel_info) {
			// Guardar los datos en variables
			//$hotel_id = $hotel_info["id_hotel"];
			$nombre_hotel = $hotel_info["nombre_hotel"];
			$total_habitaciones = $hotel_info["total_habitaciones"];
			$habitaciones_disponibles = $hotel_info["total_habitaciones_disponibles"];
			$habitaciones_ocupadas = $hotel_info["total_habitaciones_ocupadas"];
			$reservaciones_hoy = $hotel_info["reservaciones_hoy"];
		} else {
			$hotel_id = "N/D";
			$nombre_hotel = "N/D";
			$total_habitaciones = "N/D";
			$habitaciones_disponibles = "N/D";
			$habitaciones_ocupadas = "N/D";
			$reservaciones_hoy = "N/D";
		}

	
	    $sql_vh = "SELECT * FROM vista_habitaciones WHERE  id_habitacion = $id_habitacion";
    	$resultvh = $conn->getConexion()->query($sql_vh);

    if ($resultvh->num_rows > 0) {
        // Utilizar fetch_assoc para obtener la fila como un array asociativo
        $habitacion_info = $resultvh->fetch_assoc();

        // Guardar los datos en variables
        $id_habitacion = $habitacion_info["id_habitacion"];
        $tipo_habitacion = $habitacion_info["tipo_habitacion"];
        $capacidad = $habitacion_info["capacidad"];
        $precio = $habitacion_info["precio"];
        $numero = $habitacion_info["numero"];
        $disponibilidad = $habitacion_info["disponibilidad"];
        $id_hotel = $habitacion_info["id_hotel"];
        $id_tipo_habitacion = $habitacion_info["id_tipo_habitacion"];
    }

	$sql_cuidades = "SELECT * FROM ciudad";
		$result = $conn->getConexion()->query($sql_cuidades);

		if ($result->num_rows > 0) {
			$ciudades = array();
			while ($row = $result->fetch_assoc()) {
				$ciudades[] = $row;
			}
		}


	}



?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Tables - SB Admin</title>
	<link href="../.././css/styles.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
		crossorigin="anonymous" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
		crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
	<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
		<a class="navbar-brand" href="../dashboard/principal.php?id_hotel=<?php echo $id_hotel; ?>">
			<?php echo $nombre_hotel ; ?>
		</a>
		<button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
				class="fas fa-bars"></i></button><!-- Navbar Search-->
		<form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
			<div class="input-group">
				<input class="form-control" type="text" placeholder="Search for..." aria-label="Search"
					aria-describedby="basic-addon2" />
				<div class="input-group-append">
					<button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
				</div>
			</div>
		</form>
		<!-- Navbar-->
		<ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
					<?php echo $nombre_hotel." - ". strtoupper($_SESSION['conexion']['username']); ?><i class="fas fa-user fa-fw"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
					<a class="dropdown-item" href="#">Configuración</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="../.././php/config/logout.php">Salir</a>
				</div>
			</li>
		</ul>
	</nav>
	<div id="layoutSidenav">
		<div id="layoutSidenav_nav">
			<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
				<div class="sb-sidenav-menu">
					<div class="nav">
						<a class="nav-link" href="../dashboard/principal.php?id_hotel=<?php echo $id_hotel; ?>">
							<div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
							Dashboard
						</a>



						<div class="sb-sidenav-menu-heading">Personal</div>
						<a class="nav-link" href="vista_cliente.php?id_hotel=<?php echo $id_hotel; ?>">
							<div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>Clientes
						</a>
						<a class="nav-link" href="vista_empleado.php?id_hotel=<?php echo $id_hotel; ?>">
							<div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>Empleados
						</a>

					</div>
				</div>

			</nav>
		</div>
		<div id="layoutSidenav_content">
			<main>
				<div class="container-fluid">
					<h1 class="mt-4">Registro de reservación</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a
								href="../dashboard/principal.php?id_hotel=<?php echo $id_hotel; ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a
								href="vista_hab_disponibles.php?id_hotel=<?php echo $id_hotel; ?>">Hab. disponibles</a>
						</li>
						<li class="breadcrumb-item active">Reservación</li>
					</ol>
					<form action="../.././php/post/registrar_reservacion.php" method="post" id="form">
						<div class="card mb-4" id="form-registrar">
							<div class="card-header"><i class="fas fa-table mr-1"></i> Datos de la habitación</div>
							<div class="card-body">
								<div class="row">
									<div class="col form-group">
										<label for="nombre">Número de habitación</label>
										<input type="text" id="numero_hab" name="numero_hab" class="form-control"
											value="<?php echo $numero; ?>" disabled>
										<input type="hidden" id="id_habitacion" name="id_habitacion"
											value="<?php echo $id_habitacion; ?>">
									</div>
									<div class="col form-group">
										<label for="correo">Capacidad:</label>
										<input type="text" id="capacidad" name="capacidad" class="form-control"
											value="<?php echo $capacidad; ?>" disabled>
									</div>
									<div class="col form-group">
										<label for="nombre">Tipo de habitación:</label>
										<input type="text" id="tipo_hab" name="tipo_hab" class="form-control"
											value="<?php echo $tipo_habitacion; ?>" disabled>
									</div>
								</div>
								<div class="row">
									<div class="col form-group">
										<label for="correo">Fecha incio:</label>
										<input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
									</div>
									<div class="col form-group">
										<label for="correo">Fecha fin:</label>
										<input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
									</div>
									<div class="col form-group">
										<label for="precio"><b>Precio:</b></label>
										<input type="text" id="precio" name="precio" class="form-control" value="<?php echo $precio; ?>" disabled>
										<input type="hidden" name="precio_hidden" id="precio_hidden" value="<?php echo $precio; ?>">
									</div>
								</div>
								<input type="hidden" name="id_hotel" value="<?php echo $id_hotel; ?>">
							</div>
						</div>
						<!-- Formulario de edición (inicialmente oculto) -->
						<div class="card mb-4" id="form-editar">
							<div class="card-header"><i class="fas fa-table mr-1"></i>Datos del cliente</div>
							<div class="card-body">
								<div class="row">
									<div class="col-8 form-group">
										<label for="cedula_busqueda">Búsqueda por cédula:</label>
										<input type="text" id="cedula_busqueda" name="cedula_busqueda" class="form-control">
									</div>
									<div class="col-4 form-group">
										<label for="cedula" style="color: white;">:</label>
										<button type="button" class="btn btn-primary form-control btn-buscar-cliente">Buscar</button>
									</div>
								</div>
								<div class="row">
									<div class="col form-group">
										<label for="cedula">Cédula:</label>
										<input type="number" id="cedula" name="cedula" class="form-control">
									</div>
									<div class="col form-group">
										<label for="nombe">Nombre:</label>
										<input type="text" id="nombre" name="nombre" class="form-control">
									</div>
									<div class="col form-group">
										<label for="apellido">Apellido:</label>
										<input type="text" id="apellido" name="apellido" class="form-control">
									</div>
								</div>
								<div class="row">
									<div class="col form-group">
										<label for="direccion">Dirección:</label>
										<input type="text" id="direccion" name="direccion" class="form-control">
									</div>
									<div class="col form-group">
										<label for="ciudad">Ciudad:</label>
										<select name="ciudad" id="ciudad" class="form-control">
											<option value="">--- Seleccione una ciudad ---</option>
											<?php
											foreach ($ciudades as $ciudad) {
												echo "<option value='{$ciudad['id_ciudad']}'>{$ciudad['nombre']}</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col form-group">
										<label for="telefono">Teléfono:</label>
										<input type="number" id="telefono" name="telefono" class="form-control">
									</div>
									<div class="col form-group">
										<label for="email">Correo eléctronico:</label>
										<input type="email" id="email" name="email" class="form-control">
									</div>
								</div>
								<input type="hidden" id="id_empleado_editar" name="id_empleado_editar">
								<button type="submit" class="btn btn-primary btn-realizar-compra">REALIZAR PAGO</button>
							</div>
						</div>
					</form>
			</main>
			<footer class="py-4 bg-light mt-auto">
				<div class="container-fluid">
					<div class="d-flex align-items-center justify-content-between small">
						<div class="text-muted">Copyright &copy; Grupo 6
							<?php echo date('Y'); ?>
						</div>
						<div>
							<a href="#">Privacy Policy</a>
							&middot;
							<a href="#">Terms &amp; Conditions</a>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script src="../.././js/scripts.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
	<script src="assets/demo/datatables-demo.js"></script>

	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

	<script>
		$(document).ready(function () {

			function buscarCliente() {
				var cedulaBusqueda = $("#cedula_busqueda").val();
				if (cedulaBusqueda.trim() === "") {
					alert("Debe ingresar una cédula");
					return false;
				}
				// Realizar la llamada AJAX para buscar el cliente por la cédula
				$.ajax({
					url: "../.././php/get/buscar_cliente.php",
					method: "POST",
					data: { cedula: cedulaBusqueda },
					dataType: "json",
					success: function (response) {
						// Verificar si se encontró un cliente
						if (response.success) {
							// Actualizar los campos del formulario con la información del cliente
							$("#cedula").val(response.cliente.cedula);
							$("#nombre").val(response.cliente.nombre);
							$("#apellido").val(response.cliente.apellido);
							$("#direccion").val(response.cliente.direccion);
							$("#ciudad").val(response.cliente.ciudad);
							$("#telefono").val(response.cliente.telefono);
							$("#email").val(response.cliente.email);
							// Puedes agregar más campos según sea necesario
						} else {
							alert("Cliente no encontrado");
						}
					},
					error: function () {
						alert("Error al realizar la búsqueda");
					}
				});
			}

			// Manejar clic en el botón de búsqueda
			$(".btn-buscar-cliente").click(function (e) {
				e.preventDefault();
				buscarCliente();
			});

			$.validator.addMethod("lettersonly", function(value, element) {
				return this.optional(element) || /^[a-zA-Z\sáéíóúüñÁÉÍÓÚÜÑ]+$/.test(value);
			}, "Ingrese solo letras.");

			// VALIDACION PARA EL FORM PARA AGREGAR UNA RESEVACION, AGREGANDO UN CLIENTE
			$("#form").validate({
				rules: {
					cedula: {
						required: true,
						number: true,
						minlength: 10,
						maxlength: 10,
					},
					nombre: {
						required: true,
						lettersonly: true,
					},
					apellido: {
						required: true,
						lettersonly: true,
					},
					direccion: "required",
					ciudad: "required",
					telefono: {
						required: true,
						number: true,
						minlength: 10,
						maxlength: 10,
					},
					email: {
						required: true,
						email: true
					}
				},
				messages: {
					cedula: {
						required: "Este campo es obligatorio.",
						number: "Ingrese un número válido.",
						minlength: "La cédula debe tener 10 digitos.",
						maxlength: "La cédula debe tener 10 digitos."
					},
					nombre: {
						required: "Este campo es obligatorio.",
						lettersonly: "Este campo debe contener solo letras."
					},
					apellido: {
						required: "Este campo es obligatorio.",
						lettersonly: "Este campo debe contener solo letras."
					},
					direccion: "Este campo es obligatorio.",
					ciudad: "Seleccione una ciudad.",
					telefono: {
						required: "Este campo es obligatorio.",
						number: "Ingrese un número válido.",
						minlength: "La teléfono debe tener 10 digitos.",
						maxlength: "La teléfono debe tener 10 digitos."
					},
					email: {
						required: "Este campo es obligatorio.",
						email: "Ingrese una dirección de correo electrónico válida."
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

			$(".btn-realizar-compra").click(function () {
				if (!confirm("¿Está seguro que desea realizar la transacción?")) {
					// Acción a realizar si se confirma la transacción
					return;
				}
			});

			const precioInicial = <?php echo $precio; ?>;

			function actualizarPrecio() {
				const fechaInicio = new Date(document.getElementById("fecha_inicio").value);
				const fechaFin = new Date(document.getElementById("fecha_fin").value);

				// Calcular la diferencia en días
				const diferenciaEnDias = Math.floor((fechaFin - fechaInicio) / (1000 * 60 * 60 * 24));

				// Actualizar el precio
				if (diferenciaEnDias >= 2) {
					// Aumentar el precio a partir del segundo día
					const precioActualizado = precioInicial + ((diferenciaEnDias - 1) * <?php echo $precio; ?>);
					document.getElementById("precio").value = precioActualizado.toFixed(2);
					document.getElementById("precio_hidden").value = precioActualizado.toFixed(2);
				} else {
					// Mantener el precio inicial si hay un día de diferencia o menos
					document.getElementById("precio").value = precioInicial.toFixed(2);
					document.getElementById("precio_hidden").value = precioInicial.toFixed(2);
				}
			}

			// Asignar valores iniciales a las fechas
			const ahora = new Date();
			const timezoneOffset = ahora.getTimezoneOffset();
			ahora.setMinutes(ahora.getMinutes() - timezoneOffset);
			const fechaActual = ahora.toISOString().split('T')[0];
			document.getElementById("fecha_inicio").value = fechaActual;

			const fechaFin = new Date(ahora);
			fechaFin.setDate(ahora.getDate() + 1);
			const fechaFinISO = fechaFin.toISOString().split('T')[0];
			document.getElementById("fecha_fin").value = fechaFinISO;

			// Actualizar el precio al cargar la página
			actualizarPrecio();

			// Agregar eventos de cambio en las fechas
			document.getElementById("fecha_inicio").addEventListener("change", actualizarPrecio);
			document.getElementById("fecha_fin").addEventListener("change", actualizarPrecio);




		});
	</script>
</body>

</html>