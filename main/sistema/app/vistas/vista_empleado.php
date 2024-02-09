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
		// Definir valores predeterminados
		$hotel_id = 'N/D';
		$nombre_hotel = 'N/D';
		$total_habitaciones = 'N/D';
		$habitaciones_disponibles = 'N/D';
		$habitaciones_ocupadas = 'N/D';
		$reservaciones_hoy = 'N/D';

	if (isset($_GET['id_hotel'])) {
		$id_hotel = $_GET['id_hotel'];
	
		// Obtener información del hotel
		$hotel_info = getHotelInfo($conn, $id_hotel);
	
		// Asignar valores si se encontraron resultados, de lo contrario, se quedan con los valores predeterminados
		if ($hotel_info) {
			extract($hotel_info, EXTR_OVERWRITE);
		}
	
		// Consultar cargos
		$result_cargo = $conn->getConexion()->query("SELECT * FROM cargo");
		$cargos = ($result_cargo->num_rows > 0) ? $result_cargo->fetch_all(MYSQLI_ASSOC) : [];
	
		// Consultar empleados
		$sql_empleado = "SELECT * FROM empleado WHERE id_hotel = $id_hotel";
		$result_empleado = $conn->getConexion()->query($sql_empleado);
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
					<?php echo $nombre_hotel." - ". strtoupper($_SESSION['conexion']['username']); ; ?><i class="fas fa-user fa-fw"></i>
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

						<?php if(false) { ?>

						<div class="sb-sidenav-menu-heading">Interface</div>
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts"
							aria-expanded="false" aria-controls="collapseLayouts">
							<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
							Layouts
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
							data-parent="#sidenavAccordion">
							<nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="layout-static.html">Static
									Navigation</a><a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
							</nav>
						</div>
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
							aria-expanded="false" aria-controls="collapsePages">
							<div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
							Pages
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
							data-parent="#sidenavAccordion">
							<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
								<a class="nav-link collapsed" href="#" data-toggle="collapse"
									data-target="#pagesCollapseAuth" aria-expanded="false"
									aria-controls="pagesCollapseAuth">Authentication
									<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
								</a>
								<div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
									data-parent="#sidenavAccordionPages">
									<nav class="sb-sidenav-menu-nested nav"><a class="nav-link"
											href="login.html">Login</a><a class="nav-link"
											href="register.html">Register</a><a class="nav-link"
											href="password.html">Forgot Password</a></nav>
								</div>
								<a class="nav-link collapsed" href="#" data-toggle="collapse"
									data-target="#pagesCollapseError" aria-expanded="false"
									aria-controls="pagesCollapseError">Error
									<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
								</a>
								<div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
									data-parent="#sidenavAccordionPages">
									<nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="401.html">401
											Page</a><a class="nav-link" href="404.html">404 Page</a><a class="nav-link"
											href="500.html">500 Page</a></nav>
								</div>
							</nav>
						</div>

						<?php } ?>

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
					<h1 class="mt-4">Empleados</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a
								href="../dashboard/principal.php?id_hotel=<?php echo $id_hotel; ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Empleados</li>
					</ol>
					<div class="card mb-4" id="form-registrar">
						<div class="card-header"><i class="fas fa-table mr-1"></i>Registro de empleado</div>
						<div class="card-body">
							<form action="../.././php/post/registrar_empleado.php" method="post" id="registro-form">
								<div class="row">
									<div class="col form-group">
										<label for="nombre">Cargo:</label>
										<select name="cargo" id="cargo" class="form-control">
											<option value="">--- Seleccione un cargo ---</option>
											<?php
												foreach ($cargos as $cargo) {
													echo "<option value='{$cargo['id_cargo']}'>{$cargo['nombre']}</option>";
												}
												?>
										</select>
									</div>
									<div class="col form-group">
										<label for="correo">Cargo nuevo</label>
										<a href="vista_cargo.php?id_hotel=<?php echo $id_hotel; ?>"
											class="btn btn-primary form-control">Añadir un cargo</a>
									</div>
								</div>
								<div class="row">
									<div class="col form-group">
										<label for="correo">Nombre:</label>
										<input type="text" id="nombre" name="nombre" class="form-control">
									</div>
									<div class="col form-group">
										<label for="nombre">Apellido:</label>
										<input type="text" id="apellido" name="apellido" class="form-control">
									</div>
								</div>
								<div class="row">
									<div class="col form-group">
										<label for="correo">Fecha de contrato:</label>
										<input type="date" id="fecha" name="fecha" class="form-control">
									</div>
									<div class="col form-group">
										<label for="correo">Salario:</label>
										<input type="text" id="salario" name="salario" class="form-control">
									</div>
								</div>
								<input type="hidden" name="id_hotel" value="<?php echo $id_hotel; ?>">
								<button type="submit" class="btn btn-primary">Registrar</button>
							</form>
						</div>
					</div>
					<!-- Formulario de edición (inicialmente oculto) -->
					<div class="card mb-4" id="form-editar">
						<div class="card-header"><i class="fas fa-table mr-1"></i>Editar empleado</div>
						<div class="card-body">
							<form action="../.././php/post/editar_empleado.php" method="post" id="editar-form">
								<div class="row">
									<div class="col form-group">
										<label for="nombre">Cargo:</label>
										<select name="cargo_editar" id="cargo_editar" class="form-control">
											<option value="">--- Seleccione un cargo ---</option>
											<?php
												foreach ($cargos as $cargo) {
													echo "<option value='{$cargo['id_cargo']}'>{$cargo['nombre']}</option>";
												}
												?>
										</select>
									</div>
									<div class="col form-group">
										<label for="correo">Nombre:</label>
										<input type="text" id="nombre_editar" name="nombre_editar" class="form-control"
											required>
									</div>
								</div>
								<div class="row">
									<div class="col form-group">
										<label for="nombre">Apellido:</label>
										<input type="text" id="apellido_editar" name="apellido_editar"
											class="form-control" required>
									</div>
									<div class="col form-group">
										<label for="correo">Fecha de contrato:</label>
										<input type="date" id="fecha_editar" name="fecha_editar" class="form-control"
											required>
									</div>
								</div>
								<div class="row">
									<div class="col form-group">
										<label for="correo">Salario:</label>
										<input type="text" id="salario_editar" name="salario_editar"
											class="form-control" required>
									</div>
								</div>
								<input type="hidden" id="id_empleado_editar" name="id_empleado_editar">
								<input type="hidden" name="id_hotel" value="<?php echo $id_hotel; ?>">
								<button type="submit" class="btn btn-primary">Guardar cambios</button>
							</form>
						</div>
					</div>
					<div class="card mb-4">
						<div class="card-header"><i class="fas fa-table mr-1"></i>Listado de empleados</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered text-center align-middle" id="dataTable" width="100%"
									cellspacing="0">
									<thead>
										<tr>
											<th>ID</th>
											<th>Nombre</th>
											<th>Apellido</th>
											<th>Fecha de contrato</th>
											<th>Salario</th>
											<th>Editar</th>
											<th>Eliminar</th>
										</tr>
									</thead>
									<tbody>
										<?php while($row = $result_empleado->fetch_assoc()) { ?>
										<tr>
											<td>
												<?php echo $row['id_empleado']; ?>
											</td>
											<td>
												<?php echo $row['nombre']; ?>
											</td>
											<td>
												<?php echo $row['apellido']; ?>
											</td>
											<td>
												<?php echo $row['fecha_contratacion']; ?>
											</td>
											<td>
												<?php echo $row['salario']; ?>
											</td>
											<td>
												<!-- Botón de editar con icono -->
												<button class="btn btn-warning btn-editar">
													<i class="fas fa-edit"></i>
												</button>
											</td>
											<td>
												<!-- Botón de eliminar con icono -->
												<button class="btn btn-danger btn-eliminar">
													<i class="fas fa-trash-alt"></i>
												</button>
											</td>
											<td style="display:none">
												<?php echo $row['id_cargo']; ?>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

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
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
		crossorigin="anonymous"></script>
	<script src="../.././js/scripts.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
	<script src="assets/demo/datatables-demo.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script>
		$(document).ready(function () {

			$.validator.addMethod("lettersonly", function(value, element) {
				return this.optional(element) || /^[a-zA-Z\sáéíóúüñÁÉÍÓÚÜÑ]+$/.test(value);
			}, "Ingrese solo letras.");

			// VALIDACION PARA EL FORM PARA AGREGAR UN NUEVO EMPLEADO

			$("#registro-form").validate({
				rules: {
					cargo: "required",
					nombre: {
						required: true,
						lettersonly: true,
					},
					apellido: {
						required: true,
						lettersonly: true,
					},
					fecha: "required",
					salario: {
						required: true,
						number: true,
					},
				},
				messages: {
					cargo: "Seleccione un cargo.",
					nombre: {
						required: "Este campo es obligatorio.",
						lettersonly: "Este campo debe contener solo letras."
					},
					apellido: {
						required: "Este campo es obligatorio.",
						lettersonly: "Este campo debe contener solo letras."
					},
					fecha: "Este campo es obligatorio.",
					salario: {
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

			// VALIDACION PARA EL FORM PARA EDITAR UN EMPLEADO

			$("#editar-form").validate({
				rules: {
					cargo_editar: "required",
					nombre_editar: {
						required: true,
						lettersonly: true,
					},
					apellido_editar: {
						required: true,
						lettersonly: true,
					},
					fecha_editar: "required",
					salario_editar: {
						required: true,
						number: true,
					},
				},
				messages: {
					cargo_editar: "Seleccione un cargo.",
					nombre_editar: {
						required: "Este campo es obligatorio.",
						lettersonly: "Este campo debe contener solo letras."
					},
					apellido_editar: {
						required: "Este campo es obligatorio.",
						lettersonly: "Este campo debe contener solo letras."
					},
					fecha_editar: "Este campo es obligatorio.",
					salario_editar: {
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

			// Ocultar el formulario de edición al principio
			$("#form-editar").hide();

			// Función para editar un empleado
			function editarEmpleado(boton) {
				// Preguntar si desea editar
				if (!confirm("¿Desea editar este empleado?")) {
					return;
				}

				// Obtener datos del renglón de la tabla
				var row = $(boton).closest("tr");
				var id = row.find("td:eq(0)").text();
				var nombre = row.find("td:eq(1)").text();
				var apellido = row.find("td:eq(2)").text();
				var fecha = row.find("td:eq(3)").text();
				var salario = row.find("td:eq(4)").text();
				var cargo = row.find("td:eq(7)").text();

				// Establecer valores en el formulario de edición
				$("#id_empleado_editar").val(id.trim());
				$("#nombre_editar").val(nombre.trim());
				$("#apellido_editar").val(apellido.trim());
				$("#fecha_editar").val(fecha.trim());
				$("#salario_editar").val(salario.trim());
				$("#cargo_editar").val(cargo.trim());

				// Mostrar/ocultar formularios
				$("#form-registrar").hide();
				$("#form-editar").show();
			}

			// Manejar clic en el botón de editar
			$(".btn-editar").click(function () {
				editarEmpleado(this);
			});

			// Manejar clic en el botón de eliminar
			$(".btn-eliminar").click(function () {
				var boton = $(this);

				// Preguntar si desea eliminar
				if (!confirm("¿Está seguro que desea eliminar este empleado?")) {
					return;
				}

				// Obtener el ID del empleado a eliminar
				var fila = boton.closest("tr");
				var id_empleado = fila.find("td:eq(0)").text().trim();

				// Enviar solicitud AJAX para eliminar el empleado
				$.ajax({
					url: "../.././php/post/eliminar_empleado.php?id_empleado=" + id_empleado,
					success: function (response) {
						// Manejar la respuesta si es necesario
						console.log(response);
						// Recargar la página o realizar otras acciones según tus necesidades
						location.reload();
					},
					error: function (xhr, status, error) {
						// Manejar errores si es necesario
						console.error(error);
					}
				});
			});
		});

	</script>
</body>

</html>