
<!DOCTYPE html>
<html>
<head>
	<title>Gonejo Web</title>
	<link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
	<link rel="icon" type="image/png" href="imagenes/mifavicon.png" />
	<script src="librerias/jquery-3.2.1.min.js"></script>
	<script src="js/funciones.js"></script>
</head>

<body style="background-color: silver">
	<br>
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="panel panel-primary">
					<div class="panel panel-heading">Registro para Empresas.</div>
					<div class="panel panel-body">
						<form id="frmRegistro">
              			<input type="text" class="form-control input-sm" name="usuario" id="usuario" title="Usuario" placeholder="Usuario"><p></p>
              			<input type="password" class="form-control input-sm" name="clave" id="clave" title="Contraseña" placeholder="Contraseña"><p></p>
                  	<input type="text" class="form-control input-sm" name="dni" id="dni" title="DNI" placeholder="DNI"><p></p>
              			<input type="text" class="form-control input-sm" name="nombre" id="nombre" title="Nombre" placeholder="Nombre"><p></p>
							<input type="text" class="form-control input-sm" name="apellido" id="apellido" title="Apellido" placeholder="Apellido"><p></p>
              			<input type="text" class="form-control input-sm" name="celular" id="celular" title="Celular" placeholder="Celular"><p></p>
							<input type="text" class="form-control input-sm" name="ruc" id="ruc" title="RUC" placeholder="RUC"><p></p>
							<input type="text" class="form-control input-sm" name="razon" id="razon" title="Razon Social" placeholder="Razon Social"><p></p>
              			<input type="text" class="form-control input-sm" name="direccion" id="direccion" title="Dirección" placeholder="Dirección"><p></p>
              			<input type="text" class="form-control input-sm" name="ciudad" id="ciudad" title="Distrito Provincia Region" placeholder="Distrito Provincia Region"><p></p>
							<div class="panel panel-footer">Al hacer click en Registrar, aceptas nuestras <a href="#">condiciones de servicio y politica de datos.</a></div>
							<input type="reset" name="limpiar" value="Limpiar" class="btn btn-sm btn-default">
							<a href="index.php" class="btn btn-info btn-sm">Regresar</a>
							<span class="btn btn-sm btn-primary" id="registro">Registrar Empresa</span>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</body>
<footer>
	<div class="container-fluid">
		<div class="col-sm-12" style="text-align: center">
			<p>
				Todos los derechos reservados
				<span class="glyphicon glyphicon-copyright-mark"></span>
				Gonzalo Brolyn -
				<?php echo date('Y'); ?>
			</p>
		</div>
	</div>
</footer>

</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#registro').click(function(){

			vacios=validarFrmVacio('frmRegistro');
			if(vacios > 0){
				alert("Debes llenar todos los datos.");
				return false;
			}

			datos=$('#frmRegistro').serialize();
			$.ajax({
				type:"POST",
				data:datos,
				url:"procesos/personas/registrarPersona.php",
				success:function(r){
					if(r==1) {
						alert("Registro exitoso.");

						datoso=$('#frmRegistro').serialize();
						$.ajax({
							type:"POST",
							data:datoso,
							url:"procesos/clientes/registrarCliente.php",
							success:function(s){
								if (s==1) {
									window.location = "index.php";
								} else {
									alert("Registro de cliente denegado.");
								}
							}
						});

					} else {
						alert("Registro denegado.");
					}
				}
			});
		});
	});
</script>
