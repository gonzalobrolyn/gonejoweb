<?php
  session_start();
  if(isset($_SESSION['usuarioNombre']) && ($_SESSION['usuarioCargo']=="Empresa" || $_SESSION['usuarioCargo']=="Administrador")){
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
                     persona_ruc
                from persona";
      $result = mysqli_query($conexion, $sql);
    ?>
  </head>
  <script type="text/javascript">
    function mostrar(){
      document.getElementById('cambio').style.display = "block";
    }
    function ocultar(){
      document.getElementById('cambio').style.display = "none";
    }
    function multiplicar(){
      var fac1 = document.getElementById('tipo');
      var fac2 = document.getElementById('dolar');
      document.getElementById('monto').value = fac1.value * fac2.value;
    }
    function ceros(){
      var dato1 = document.getElementById('tipo');
      var dato2 = document.getElementById('dolar');
      if (dato1.value == "" && dato2.value == "") {
        dato1.value = 0;
        dato2.value = 0;
      }
    }
  </script>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3">
          <p></p>
          <span data-toggle="modal" data-target="#modalNuevoProveedor" class="btn btn-info form-control">
				    <span class="glyphicon glyphicon-pencil"></span> Agregar Nuevo Proveedor
		      </span>
          <h3>Datos de Proveedor</h3>
          <form id="frmDeposito">
            <select class="form-control input-sm" id="rucSelect" name="rucSelect" title="Ingresa RUC">
              <option value="A">Ingresa el RUC</option>
              <?php while ($ver=mysqli_fetch_row($result)): ?>
                <?php if ($ver[1] <> ""): ?>
                  <option value="<?php echo $ver[0]; ?>"><?php echo $ver[1]; ?></option>
                <?php endif; ?>
              <?php endwhile; ?>
            </select><p></p>
            <input type="text" readonly name="razon" id="razon" placeholder="Razon Social" title="Razon Social" class="form-control input-sm"><p></p>
            <input type="text" readonly name="celular" id="celular" placeholder="Celular" title="Celular" class="form-control input-sm"><p></p>
            Elige Moneda:
            <input type="button" name="btnDolar" id="btnDolar" class="btn btn-default input-sm" onclick="mostrar()" value="Dolares">
            <input type="button" name="btnSoles" id="btnSoles" class="btn btn-default input-sm" onclick="ocultar()" value="Soles"><p></p>
            <div id="cambio">
              <input type="text" name="tipo" id="tipo" placeholder="Tipo de Cambio" title="Tipo de Cambio" class="form-control input-sm"><p></p>
              <input type="text" name="dolar" id="dolar" placeholder="Deposito en Dolares" title="Deposito en Dolares" class="form-control input-sm" onkeyup="multiplicar()"><p></p>
            </div>
            <input type="text" name="monto" id="monto" placeholder="Deposito en Soles" title="Deposito en Soles" class="form-control input-sm" onkeyup="ceros()"><p></p>
            <input type="text" name="numerocom" id="numerocom" placeholder="Numero de Operación" title="Numero de Operación" class="form-control input-sm"><p></p>
            <textarea name="detalle" id="detalle" placeholder="Descripción del Deposito" title="Descripción del Deposito" class="form-control input-sm"></textarea><p></p>
            <input type="reset" name="Limpiar" value="Limpiar" class="btn btn-danger">
            <span class="btn btn-success" id="btnRegistrar">Registrar</span>
          </form>
        </div>
        <div class="col-sm-9">
          <h3>Lista de Depositos</h3>
            <div id="cargaTablaDepositos"></div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalNuevoProveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Datos del Nuevo Proveedor</h4>
          </div>
          <div class="modal-body">
            <form id="frmNuevoProveedor">
              <input type="text" name="ruc" id="ruc" placeholder="RUC" title="RUC" class="form-control input-sm"><p></p>
              <input type="text" name="razon" id="razon" placeholder="Razon" title="Razon" class="form-control input-sm"><p></p>
              <input type="text" name="celular" id="celular" placeholder="Celular" title="Celular" class="form-control input-sm"><p></p>
              <input type="text" name="direccion" id="direccion" placeholder="Dirección" title="Dirección" class="form-control input-sm"><p></p>
              <input type="text" name="ciudad" id="ciudad" placeholder="Ciudad" title="Ciudad" class="form-control input-sm"><p></p>
              <input type="reset" name="Limpiar" value="Limpiar" class="btn btn-default btn-sm">
            </form>
          </div>
          <div class="modal-footer">
            <button id="btnNuevoProveedor" type="button" class="btn btn-success btn-sm" data-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<script type="text/javascript">
  $(document).ready(function(){
    $('#cargaTablaDepositos').load("tablas/tablaDepositos.php");

    $('#rucSelect').change(function(){
      $.ajax({
        type: "POST",
        data: "idPersona=" + $('#rucSelect').val(),
        url: "../procesos/personas/llenarFrmPersona.php",
        success:function(r){
          dato=jQuery.parseJSON(r);
          $('#razon').val(dato['razonP']);
          $('#celular').val(dato['celularP']);
        }
      });
    });

    $('#btnRegistrar').click(function(){
      vacios = validarFrmVacio('frmDeposito');
      if (vacios > 0) {
        alertify.alert("Debes llenar todos los datos.");
        return false;
      }

      datos = $('#frmDeposito').serialize();
      $.ajax({
        type: "POST",
        data: datos,
        url: "../procesos/compras/agregaDeposito.php",
        success: function(r){
          if (r == 1) {
            $('#frmDeposito')[0].reset();
            $('#cargaTablaDepositos').load("tablas/tablaDepositos.php");
            alertify.success("Deposito agregado.")
          } else {
            alertify.error("Error al agregar.")
          }
        }
      });
    });

  });
</script>

<script type="text/javascript">
$(document).ready(function(){
  $('#btnNuevoProveedor').click(function(){

    vacios = validarFrmVacio('frmNuevoProveedor');
    if(vacios > 0){
      alertify.alert("Debes llenar todos los datos.");
      return false;
    }

    datos = $('#frmNuevoProveedor').serialize();
    $.ajax({
      type:"POST",
      data:datos,
      url:"../procesos/personas/nuevoProveedor.php",
      success:function(r){
        if(r==1){
          $('#frmNuevoProveedor')[0].reset();
          window.location="deposito.php";
          alertify.success("Agregado con exito.");
        }else{
          alertify.error("Fallo al agregar.");
        }
      }
    });
  });
});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#rucSelect').select2();
	});
</script>

<?php
} else {
  header("location:inicio.php");
}
?>
