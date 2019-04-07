
<?php
   session_start();
   if(isset($_SESSION['usuarioNombre'])){
      require_once "menu.php";
      require_once "../clases/Gonexion.php";
      $c = new conectar();
      $conexion = $c->conexion();
      $idCaja = $_SESSION['cajaID'];
      $sql = "SELECT caj.caja_sede,
                     ima.imagen_ruta
                from caja as caj
          inner join imagen as ima
                  on caj.caja_logo = ima.imagen_id
               where caj.caja_id = '$idCaja'";
      $result = mysqli_query($conexion, $sql);
      $ver = mysqli_fetch_row($result);

      $sqlFamilia = "SELECT familia_id,
                            familia_nombre
                       from familia";
      $rFamilia = mysqli_query($conexion, $sqlFamilia);

      $sqlDNI = "SELECT persona_id,
                        persona_dni
                   from persona
                  where persona_dni <> 'NULL'";
      $rDNI = mysqli_query($conexion, $sqlDNI);

      $sqlRUC = "SELECT persona_id,
                        persona_ruc
                   from persona
                  where persona_ruc <> 'NULL'";
      $rRUC = mysqli_query($conexion, $sqlRUC);

      $sqlBusqueda = "SELECT alm.almacen_id,
                             pro.producto_modelo,
                             pro.producto_codigo
                        from almacen as alm
                  inner join producto as pro
                          on alm.almacen_producto = pro.producto_id
                       where alm.almacen_caja = '$idCaja'";
      $rProducto = mysqli_query($conexion, $sqlBusqueda);

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
               <div class="row">
                  <?php
                  if ($ver[1]<>NULL) {
                     $img = explode("/",$ver[1]);
                     $ruta = $img[1]."/".$img[2]."/".$img[3];
                  } else {
                     $ruta = "../imagenes/imagen.jpg";
                  }
                  ?>
                  <p style="text-align: center">
                     <img height="120" src="<?php echo $ruta ?>">
                  </p>
                  <p style="text-align: center">
                     <b><?php echo $ver[0]; ?></b>
                  </p>
                  <hr>
                  <span data-toggle="modal" data-target="#modalNuevoCliente" class="btn btn-info form-control">
                     <span class="glyphicon glyphicon-pencil"></span> Agregar Nuevo Cliente
                  </span>
                  <hr>
                  <h4 style="text-align: center">Datos del Cliente</h4>
                  <form id="frmCliente" style="text-align: center">
                    <select class="form-control input-sm" id="dniSelect" name="dniSelect" title="Ingresa DNI">
                     <option value="A">Ingresa DNI</option>
                     <?php while ($verDNI=mysqli_fetch_row($rDNI)): ?>
                        <?php if ($verDNI[1] <> ""): ?>
                          <option value="<?php echo $verDNI[0]; ?>"><?php echo $verDNI[1]; ?></option>
                        <?php endif; ?>
                     <?php endwhile; ?>
                    </select><p></p>
                    <select class="form-control input-sm" id="rucSelect" name="rucSelect" title="Ingresa RUC">
                     <option value="A">Ingresa RUC</option>
                     <?php while ($verRUC=mysqli_fetch_row($rRUC)): ?>
                        <?php if ($verRUC[1] <> ""): ?>
                          <option value="<?php echo $verRUC[0]; ?>"><?php echo $verRUC[1]; ?></option>
                        <?php endif; ?>
                     <?php endwhile; ?>
                    </select><p></p>
                    <input type="text" readonly name="nombre" id="nombre" placeholder="Nombre" title="Nombre" class="form-control input-sm"><p></p>
                    <input type="text" readonly name="apellido" id="apellido" placeholder="Apellido" title="Apellido" class="form-control input-sm"><p></p>
                    <input type="text" readonly name="celular" id="celular" placeholder="Celular" title="Celular" class="form-control input-sm"><p></p>
                    <input type="text" readonly name="razon" id="razon" placeholder="Razon Social" title="Razon Social" class="form-control input-sm"><p></p>
                    <input type="text" readonly name="direccion" id="direccion" placeholder="Direccion" title="Direccion" class="form-control input-sm"><p></p>
                  </form>
               </div>
            </div>
            <div class="col-sm-8">
               <div id="cargaPizarra">
                  <div class="col-sm-6" style="text-align: center">
                     <br><br>
                     <h3>Gonejo Web</h3>
                     <h4>Control Dinamico de Caja y Almacen</h4> <br>
                     <p>Sistema informático para la gestión de caja y almacen, con arquitectura de bases de datos escalable. Tiene modulos de compra, venta, servicios, pagos y mas.</p><br><br>
                     <span class="btn btn-primary btn-sm">Manual para el Usuario</span>
                  </div>
                  <div class="col-sm-6">
                     <img src="../imagenes/monitor.png" class="img-responsive" />
                  </div>
               </div>
               <div id="cargaTablaVentas"></div>
            </div>
            <div class="col-sm-2" style="text-align: center">
               <div class="row">
                  <form id="busqueda" role="search">
                     <p></p>
                     <label>Buscar Producto:</label>
                     <select class="form-control" name="producto" id="producto">
                        <option value="A">Ingresa Modelo</option>
                        <?php while($verProd=mysqli_fetch_row($rProducto)): ?>
                        <option value="<?php echo $verProd[0]; ?>">
                        <?php echo $verProd[2]." ".$verProd[1];  ?>
                        </option>
                        <?php endwhile; ?>
                     </select><p></p>
                  </form>

                  <table class="table table-hover table-condensed table-bordered" style="text-align: center">
                     <?php while($verFamilia=mysqli_fetch_row($rFamilia)): ?>
                     <tr>
                        <td>
                           <a href="inicio2.php?familia=<?php echo $verFamilia[0]?>&nombre=<?php echo $verFamilia[1]?>">
                              <?php echo $verFamilia[1]; ?>
                           </a>
                        </td>
                     </tr>
                     <?php endwhile; ?>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="modalNuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title" id="myModalLabel">Datos del Nuevo Cliente</h4>
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
   <footer class="row" style="background-color: black">
      <div style="color: gray">
         <p></p>
         <p style="text-align: center">
            Todos los derechos reservados
            <span class="glyphicon glyphicon-copyright-mark"></span>
            Gonzalo Brolyn -
            <?php echo date('Y'); ?>
         </p>
      </div>
   </footer>
</html>

<script type="text/javascript">
   $(document).ready(function(){
      $('#dniSelect').change(function(){
         $.ajax({
            type: "POST",
            data: "idPersona=" + $('#dniSelect').val(),
            url: "../procesos/personas/llenarFrmPersona.php",
            success:function(r){
               dato=jQuery.parseJSON(r);
               $('#nombre').val(dato['nombreP']);
               $('#apellido').val(dato['apellidoP']);
               $('#celular').val(dato['celularP']);
            }
         });
      });

      $('#rucSelect').change(function(){
         $.ajax({
            type: "POST",
            data: "idPersona=" + $('#rucSelect').val(),
            url: "../procesos/personas/llenarFrmPersona.php",
            success:function(r){
               dato=jQuery.parseJSON(r);
               $('#celular').val(dato['celularP']);
               $('#razon').val(dato['razonP']);
               $('#direccion').val(dato['direccionP']);
            }
         });
      });

      $('#producto').change(function(){
         $('#cargaPizarra').load("inicio/pizarra.php?idAlmacen=" + $('#producto').val());
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
         url:"../procesos/ventas/vaciarLisTmp.php",
         success:function(r){
            $('#cargaTablaVentas').load("tablas/tablaVentasTmp.php");
            alertify.success("Se quito toda la Lista.");
         }
      });
   }

   function quitarProducto(index){
       $.ajax({
         type:"POST",
         data:"ind=" + index,
         url:"../procesos/ventas/quitarProTmp.php",
         success:function(r){
            $('#cargaTablaVentas').load("tablas/tablaVentasTmp.php");
            alertify.success("Se quito el producto.");
         }
       });
   }

   function venta(){
      datos = $('#frmCliente').serialize();
      $.ajax({
         type: "POST",
         data: datos,
         url: "../procesos/ventas/venta.php",
         success:function(r){
            alert(r);
            if(r > 0){
               $('#cargaTablaVentas').load("tablas/tablaVentasTmp.php");
               $('#frmCliente')[0].reset();
               alertify.success("Venta almacenada con exito.");
            }else if(r==0){
               alertify.alert("Lista de venta vacia.");
            }else{
               alertify.error("No se efectuo la venta.");
            }
         }
      });
   }
</script>

<script type="text/javascript">
  $(document).ready(function(){
      $('#cargaTablaVentas').load("tablas/tablaVentasTmp.php");
      $('#dniSelect').select2();
      $('#rucSelect').select2();
      $('#producto').select2();
  });
</script>

<?php
   } else {
      header("location:../index.php");
   }
?>
