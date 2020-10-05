
<?php
  session_start();
  if(isset($_SESSION['usuarioNombre']) && ($_SESSION['usuarioCargo']=="Empresa" || $_SESSION['usuarioCargo']=="Administrador")){
    require_once "menu.php";
    require_once "../clases/Gonexion.php";
    $c = new conectar();
    $conexion = $c->conexion();

   $sqlProducto = "SELECT pro.producto_id,
                        pro.producto_codigo,
                        mar.marca_nombre,
                        pro.producto_modelo,
                        pro.producto_descripcion
                   from producto as pro
             inner join marca as mar
                     on pro.producto_marca = mar.marca_id";
   $rProducto = mysqli_query($conexion, $sqlProducto);

   $sqlProveedor = "SELECT persona_id,
                     persona_dni,
                     persona_ruc
                from persona";
   $rProveedor = mysqli_query($conexion, $sqlProveedor);

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
        <div class="col-sm-2">
          <h3>Buscar Producto</h3>
          <form id="frmCompra">
            <select class="form-control" id="productoSelect" name="productoSelect">
               <option value="A">Buscar Producto</option>
               <?php
                  while ($verProducto=mysqli_fetch_row($rProducto)):
               ?>
                  <option value="<?php echo $verProducto[0]; ?>">
                     <?php echo $verProducto[1]." ".$verProducto[2]." ".$verProducto[3]." ".$verProducto[4]; ?>
                  </option>
               <?php endwhile; ?>
            </select><p></p>

            <input readonly type="text" name="familiaC" id="familiaC" title="Familia" placeholder="Familia" class="form-control"><p></p>
            <input readonly type="text" name="grupoC" id="grupoC" title="Grupo" placeholder="Grupo" class="form-control"><p></p>
            <input readonly type="text" name="marcaC" id="marcaC" title="Marca" placeholder="Marca" class="form-control"><p></p>
            <textarea readonly name="descripcionC" id="descripcionC" title="Descripción" placeholder="Descripción" class="form-control"></textarea><p></p>
            <textarea rows="5" readonly name="detalleC" id="detalleC" placeholder="Caracteristicas" title="Caracteristicas" class="form-control"></textarea><p></p>
            <input type="text" name="cantidad" id="cantidad" title="Cantidad" placeholder="Cantidad" class="form-control"><p></p>
            <input type="text" name="preciollegada" id="preciollegada" title="Precio de Llegada" placeholder="Precio de Llegada S/" class="form-control"><p></p>
            <input type="text" name="preciotraspaso" id="preciotraspaso" title="Precio de Traspaso" placeholder="Precio de Traspaso S/" class="form-control"><p></p>
            <input type="text" name="precioventa" id="precioventa" title="Precio de Venta" placeholder="Precio de Venta S/" class="form-control"><p></p>
            <input class="btn btn-default" type="reset" name="Limpiar" value="Limpiar">
            <span class="btn btn-primary" id="btnAgregaCompra">Agregar</span>
            <p></p>
            <div id="imgProducto" class="form-group" style="text-align: center"></div>
          </form>
        </div>
        <div class="col-sm-10">
          <div class="row">
             <div class="col-sm-6">
                <h3>Datos de la Compra</h3>
             </div>
             <div class="col-sm-6" style="text-align: right">
                <p></p>
                <span data-toggle="modal" data-target="#modalNuevoProveedor" class="btn btn-info">
                  <span class="glyphicon glyphicon-pencil"></span> Agregar Nuevo Proveedor
               </span>
             </div>
            </div>

            <div class="col-sm-12" style="text-align: center">
               <form id="frmProveedor" class="form-inline">
                  <select class="form-control" id="comprobante" name="comprobante" title="Comprobante">
                  <option value="A">Selecciona Comprobante</option>
                     <option value="Boleta">Boleta</option>
                     <option value="Factura">Factura</option>
                  </select>
                  <input type="text" name="numero" id="numero" title="Número d Comprobante" placeholder="Número d Comprobante" class="form-control">
               <select class="form-control" id="proveedorSelect" name="proveedorSelect">
               <option value="A">Buscar DNI - RUC</option>
               <?php while ($verProveedor=mysqli_fetch_row($rProveedor)): ?>
                  <option value="<?php echo $verProveedor[0]; ?>"><?php echo $verProveedor[1]." ".$verProveedor[2]; ?></option>
               <?php endwhile; ?>
               </select>
              </form>
            </div>

            <div class="row">
            <form id="frmPersona" class="form-inline" style="text-align: center">
              <input type="text" name="nombre" id="nombre" title="Nombre" placeholder="Nombre" class="form-control" readonly>
              <input type="text" name="apellido" id="apellido" title="Apelido" placeholder="Apelido" class="form-control" readonly>
              <input type="text" name="celular" id="celular" title="Celular" placeholder="Celular" class="form-control" readonly>
              <input type="text" name="razon" id="razon" title="Razon" placeholder="Razon" class="form-control" readonly>
              <input type="text" name="direccion" id="direccion" title="Dirección" placeholder="Dirección" class="form-control" readonly>
            </form><p></p>
          </div>
          <div class="row">
            <div id="cargaTablaCompras"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalNuevoProveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title" id="myModalLabel">Datos del Nuevo Proveedor</h4>
         </div>
         <div class="modal-body">
           <div class="col-sm-6">
             <form id="frmNuevoPersona">
                <input type="text" name="dni" id="dni" placeholder="DNI" title="DNI" class="form-control input-sm"><p></p>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" title="Nombre" class="form-control input-sm"><p></p>
                <input type="text" name="apellido" id="apellido" placeholder="Apellido" title="Apellido" class="form-control input-sm"><p></p>
                <input type="text" name="celular" id="celular" placeholder="Celular" title="Celular" class="form-control input-sm"><p></p>
                <input type="reset" name="Limpiar" value="Limpiar" class="btn btn-default btn-sm">
                <span class="btn btn-info btn-sm" id="agrePerNatural">Agregar Persona Natural</span>
             </form>
           </div>
           <div class="col-sm-6">
              <form id="frmNuevoEmpresa">
                <input type="text" name="ruc" id="ruc" placeholder="RUC" title="RUC" class="form-control input-sm"><p></p>
                <input type="text" name="razon" id="razon" placeholder="Razon" title="Razon" class="form-control input-sm"><p></p>
                <input type="text" name="direccion" id="direccion" placeholder="Direccion" title="Direccion" class="form-control input-sm"><p></p>
                <input type="text" name="celular" id="celular" placeholder="Celular" title="Celular" class="form-control input-sm"><p></p>
                <input type="reset" name="Limpiar" value="Limpiar" class="btn btn-default btn-sm">
                <span class="btn btn-info btn-sm" id="agrePerJuridica">Agregar Persona Juridica</span>
             </form>
           </div>
         </div>
         <div class="modal-footer">
         </div>
        </div>
      </div>
    </div>
  </body>
</html>

<script type="text/javascript">
  $(document).ready(function(){
    $('#cargaTablaCompras').load("tablas/tablaComprasTmp.php");

    $('#productoSelect').change(function(){
      document.getElementById("imgProducto").innerHTML="";
      $.ajax({
        type:"POST",
        data:"idProducto=" + $('#productoSelect').val(),
        url:"../procesos/productos/llenaFrmProducto.php",
        success:function(r){
            dato=jQuery.parseJSON(r);

            $('#familiaC').val(dato['familia']);
            $('#grupoC').val(dato['grupo']);
            $('#marcaC').val(dato['marca']);
            $('#descripcionC').val(dato['descripcion']);
            $('#detalleC').val(dato['detalle']);

            $('#imgProducto').prepend('<img height="120" class="img-thumbnail" id="imagenP" src="' + dato['ruta'] + '" />');
        }
      });
    });

    $('#btnAgregaCompra').click(function(){
      vacios = validarFrmVacio('frmCompra');
      if (vacios > 0) {
        alertify.alert("Debes llenar cantidad y precios.");
        return false;
      }
      datos = $('#frmCompra').serialize();
      $.ajax({
        type: "POST",
        data: datos,
        url: "../procesos/compras/agreProLisTmp.php",
        success: function(r){
          $('#frmCompra')[0].reset();
          $('#cargaTablaCompras').load("tablas/tablaComprasTmp.php");
        }
      });
    });

    $('#proveedorSelect').change(function(){
      $.ajax({
          type: "POST",
          data: "idPersona=" + $('#proveedorSelect').val(),
          url: "../procesos/personas/llenarFrmPersona.php",
          success:function(r){
             dato=jQuery.parseJSON(r);
             $('#nombre').val(dato['nombreP']);
             $('#apellido').val(dato['apellidoP']);
             $('#celular').val(dato['celularP']);
             $('#razon').val(dato['razonP']);
             $('#direccion').val(dato['direccionP']);
          }
      });
    });

  });
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#agrePerNatural').click(function(){

			vacios = validarFrmVacio('frmNuevoPersona');
			if(vacios > 0){
				alertify.alert("Debes llenar todos los datos.");
				return false;
			}

			datos = $('#frmNuevoPersona').serialize();
			$.ajax({
				type:"POST",
				data:datos,
				url:"../procesos/personas/nuevoCliente.php",
				success:function(r){
					if(r>1){
						$('#frmNuevoPersona')[0].reset();
						alertify.success("Agregado con exito.");
					}else{
						alertify.error("Fallo al agregar.");
					}
				}
			});
		});

      $('#agrePerJuridica').click(function(){

         vacios = validarFrmVacio('frmNuevoEmpresa');
         if(vacios > 0){
            alertify.alert("Debes llenar todos los datos.");
            return false;
         }

         datos = $('#frmNuevoEmpresa').serialize();
         $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/personas/nuevoEmpresa.php",
            success:function(r){
               if(r>1){
                  $('#frmNuevoEmpresa')[0].reset();
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
   function vaciarLista(){
      $.ajax({
         url:"../procesos/compras/vaciarListaTmp.php",
         success:function(r){
            $('#cargaTablaCompras').load("tablas/tablaComprasTmp.php");
            alertify.success("Se quito toda la Lista.");
         }
      });
   }

   function quitarProducto(index){
       $.ajax({
         type:"POST",
         data:"ind=" + index,
         url:"../procesos/compras/quitarProTmp.php",
         success:function(r){
            $('#cargaTablaCompras').load("tablas/tablaComprasTmp.php");
            alertify.success("Se quito el producto.");
         }
       });
   }

   function compra(){
      datos = $('#frmProveedor').serialize();
      $.ajax({
         type: "POST",
         data: datos,
         url: "../procesos/compras/compra.php",
         success:function(r){
            alert(r);
            if(r > 0){
               $('#cargaTablaCompras').load("tablas/tablaComprasTmp.php");
               $('#frmProveedor')[0].reset();
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
    $('#productoSelect').select2();
    $('#proveedorSelect').select2();
  });
</script>

<?php
} else {
  header("location:inicio.php");
}
?>
