
<?php
  session_start();
  if(isset($_SESSION['usuarioNombre'])){
     require_once "menu.php";
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <?php
      require_once "../clases/Gonexion.php";

      $c = new conectar();
      $conexion = $c->conexion();
      $sql = "SELECT persona_id,
                     persona_dni
                from persona";
      $result = mysqli_query($conexion, $sql);
    ?>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3">
          <p></p>
          <span data-toggle="modal" data-target="#modalNuevoCliente" class="btn btn-info form-control">
				    <span class="glyphicon glyphicon-pencil"></span> Agregar Nuevo Cliente
		      </span>
          <h3>Datos del Cliente</h3>
          <form id="frmAdelanto">
            <select class="form-control input-sm" id="dniSelect" name="dniSelect" title="Ingresa DNI">
              <option value="A">Ingresa el DNI</option>
              <?php while ($ver=mysqli_fetch_row($result)): ?>
                <?php if ($ver[1] <> ""): ?>
                  <option value="<?php echo $ver[0]; ?>"><?php echo $ver[1]; ?></option>
                <?php endif; ?>
              <?php endwhile; ?>
            </select><p></p>
            <input type="text" readonly name="nombre" id="nombre" placeholder="Nombre" title="Nombre" class="form-control input-sm"><p></p>
            <input type="text" readonly name="apellido" id="apellido" placeholder="Apellido" title="Apellido" class="form-control input-sm"><p></p>
            <input type="text" readonly name="celular" id="celular" placeholder="Celular" title="Celular" class="form-control input-sm"><p></p>
            <input type="text" readonly name="razon" id="razon" placeholder="Razon Social" title="Razon Social" class="form-control input-sm"><p></p>
            <input type="text" readonly name="direccion" id="direccion" placeholder="Dirección" title="Dirección" class="form-control input-sm"><p></p>
            <textarea name="detalle" id="detalle" placeholder="Caracteristicas del Servicio" title="Caracteristicas del Servicio" class="form-control input-sm"></textarea><p></p>
            <input type="reset" name="Limpiar" value="Limpiar" class="btn btn-danger">
            <span class="btn btn-success" id="btnRegistrar">Registrar</span>
          </form>
        </div>
        <div class="col-sm-9">
          <h3>Lista de Servicios</h3>
          <div class="row">
            <div id="cargaTablaAdelantos"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalNuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Datos del Nuevo Cliente</h4>
          </div>
          <div class="modal-body">
            <form id="frmNuevoCliente">
              <input type="text" name="dni" id="dni" placeholder="DNI" title="DNI" class="form-control input-sm"><p></p>
              <input type="text" name="nombre" id="nombre" placeholder="Nombre" title="Nombre" class="form-control input-sm"><p></p>
              <input type="text" name="apellido" id="apellido" placeholder="Apellido" title="Apellido" class="form-control input-sm"><p></p>
              <input type="text" name="celular" id="celular" placeholder="Celular" title="Celular" class="form-control input-sm"><p></p>
              <input type="reset" name="Limpiar" value="Limpiar" class="btn btn-default btn-sm">
            </form>
          </div>
          <div class="modal-footer">
            <button id="btnNuevoCliente" type="button" class="btn btn-success btn-sm" data-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<?php
  } else {
    header("location:../index.php");
  }
?>
