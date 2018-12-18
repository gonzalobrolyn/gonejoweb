
<?php
  session_start();
  if(isset($_SESSION['usuarioNombre'])){
    require_once "menu.php";
    require_once "../clases/Gonexion.php";
    $c = new conectar();
    $conexion = $c->conexion();
    $idCaja = $_SESSION['cajaID'];
    $idMovimiento = $_GET['idMov'];
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3">
          <h3>Buscar Producto</h3>
          <form id="frmCompra">
            <select class="form-control" id="productoCompra" name="productoCompra">
              <option value="A">Ingresa Modelo</option>
              <?php
                $sqlCompra = "SELECT alm.almacen_id,
                                     pro.producto_modelo
                                from almacen as alm
                          inner join producto as pro
                                  on alm.almacen_producto = pro.producto_id";
                $result = mysqli_query($conexion, $sqlCompra);
                while ($producto=mysqli_fetch_row($result)):
              ?>
                <option value="<?php echo $producto[0]; ?>">
                  <?php echo $producto[1];?>
                </option>
              <?php endwhile; ?>
            </select><p></p>
            <input readonly type="text" name="grupoC" id="grupoC" title="Grupo" placeholder="Grupo" class="form-control input-sm"><p></p>
            <input readonly type="text" name="marcaC" id="marcaC" title="Marca" placeholder="Marca" class="form-control input-sm"><p></p>
            <textarea readonly name="detalleC" id="detalleC" placeholder="Descripción" title="Descripción" class="form-control"></textarea><p></p>
            <input type="text" name="cantidadC" id="cantidadC" title="Cantidad" placeholder="Cantidad" class="form-control input-sm"><p></p>
            <input type="text" name="precioC" id="precioC" title="Precio" placeholder="Precio S/" class="form-control input-sm"><p></p>
            <input class="btn btn-default btn-sm" type="reset" name="Limpiar" value="Limpiar">
            <span class="btn btn-info btn-sm" id="btnAgregaCompra">Agregar</span>
            <p></p>
            <div id="imgProducto" class="form-group" style="text-align: center"></div>
          </form>
        </div>
        <div class="col-sm-9">

            <h3>Datos del Deposito</h3>
            <?php
              $sqlDatos = "SELECT per.persona_dni,
                                  per.persona_nombre,
                                  per.persona_celular,
                                  mov.movimiento_monto,
                                  mov.movimiento_detalle,
                                  mov.movimiento_fecha,
                                  per.persona_apellido
                             from movimiento as mov
                       inner join persona as per
                               on mov.movimiento_persona = per.persona_id
                            where mov.movimiento_caja = '$idCaja'
                              and mov.movimiento_nombre = 'Adelanto'
                              and mov.movimiento_id = '$idMovimiento'";
              $result = mysqli_query($conexion, $sqlDatos);
              $Dato = mysqli_fetch_row($result);
            ?>
            <table class="table table-hover table-condensed table-bordered">
              <tr>
                <th>Proveedor:<?php echo " ".$Dato[1]." ".$Dato[6] ?></th>
                <th>DNI:<?php echo " ".$Dato[0] ?></th>
                <th>Celular:<?php echo " ".$Dato[2] ?></th>
              </tr>
              <tr>
                <th>Detalle:<?php echo " ".$Dato[4] ?></th>
                <th>Monto:<?php echo " S/ ".$Dato[3] ?></th>
                <th>Fecha:<?php echo " ".$Dato[5] ?></th>
              </tr>
            </table>
            <div style="text-align: right">
              <span class="btn btn-success" onclick="compraConDep()"> Generar Venta
                <span class="glyphicon glyphicon-usd"></span>
              </span>
              <a href="adelanto.php" class="btn btn-warning">Cambiar Adelanto
                <span class="glyphicon glyphicon-refresh"></span>
              </a>
              <span class="btn btn-danger" id="btnVaciarListaDep"> Vaciar Lista
                <span class="glyphicon glyphicon-trash"></span>
              </span>
            </div>

            <h3>Lista de Productos</h3>
            <div id="cargaTablaVentas"></div>
            <?php  ?>
        </div>
      </div>
    </div>
  </body>
</html>

<script type="text/javascript">
  $(document).ready(function(){
    $('#cargaTablaVentas').load("tablas/tablaVentasAde.php");

    $('#productoCompra').change(function(){
      document.getElementById("imgProducto").innerHTML="";
      $.ajax({
        type:"POST",
        data:"idProducto=" + $('#productoCompra').val(),
        url:"../procesos/productos/llenaFrmProducto2.php",
        success:function(r){
            dato=jQuery.parseJSON(r);

            $('#grupoC').val(dato['grupo']);
            $('#marcaC').val(dato['marca']);
            $('#detalleC').val(dato['detalle']);
            $('#cantidadC').val(dato['cantidad']);
            $('#precioC').val(dato['precio']);

            $('#imgProducto').prepend('<img height="120" class="img-thumbnail" id="imagenP" src="' + dato['ruta'] + '" />');
        }
      });
    });

    $('#btnAgregaCompra').click(function(){
      vacios = validarFrmVacio('frmCompra');
      if (vacios > 0) {
        alertify.alert("Debes llenar todos los datos.");
        return false;
      }
      datos = $('#frmCompra').serialize();
      $.ajax({
        type: "POST",
        data: datos,
        url: "../procesos/compras/agreProLisDep.php",
        success: function(r){
          $('#frmCompra')[0].reset();
          $('#cargaTablaVentas').load("tablas/tablaVentasAde.php");
        }
      });
    });

    $('#btnVaciarListaDep').click(function(){
		$.ajax({
			url:"../procesos/compras/vaciarListaDep.php",
			success:function(r){
            $('#cargaTablaVentas').load("tablas/tablaVentasAde.php");
			}
		});
	});

  });
</script>

<script type="text/javascript">
  function quitarProducto(index){
    $.ajax({
      type:"POST",
      data:"ind=" + index,
      url:"../procesos/compras/quitarProDep.php",
      success:function(r){
        $('#cargaTablaVentas').load("tablas/tablaVentasAde.php");
        alertify.success("Se quito el producto.");
      }
    });
  }

  function compraConDep(){
    <?php $_SESSION['depositoID'] = $idMovimiento; ?>
		$.ajax({
			url:"../procesos/compras/compraConDep.php",
			success:function(r){
        alert (r);
				if(r > 0){
               $('#cargaTablaVentas').load("tablas/tablaVentasAde.php");
					$('#frmCompra')[0].reset();
               window.location="deposito.php";
					alertify.success("Compra almacenada con exito.");
				}else if(r==0){
					alertify.alert("Lista de compra vacia.");
				}else{
					alertify.error("No se efectuo la compra.");
				}
			}
		});
	}
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#productoCompra').select2();
  });
</script>

<?php
} else {
  header("location:../index.php");
}
?>
