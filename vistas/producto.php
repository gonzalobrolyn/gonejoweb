
<?php
   session_start();
   if(isset($_SESSION['usuarioNombre']) && ($_SESSION['usuarioCargo']=="Empresa" || $_SESSION['usuarioCargo']=="Administrador")){

      require_once "../clases/Gonexion.php";
      require_once "menu.php";

      $c = new conectar();
      $conexion = $c->conexion();
      $grupoID = $_GET['grupo'];

      $sqlGrupo = "SELECT grupo_nombre,
                          grupo_familia
                     from grupo
                    where grupo_id = '$grupoID'";
      $queryGru = mysqli_query($conexion, $sqlGrupo);
      $resultGru = mysqli_fetch_row($queryGru);

      $sqlFamilia = "SELECT familia_nombre
                       from familia
                      where familia_id = '$resultGru[1]'";
      $queryFam = mysqli_query($conexion, $sqlFamilia);
      $resultFam = mysqli_fetch_row($queryFam)[0];

      $sqlMarca = "SELECT marca_id,
                          marca_nombre
                     from marca";
      $resultMarca = mysqli_query($conexion, $sqlMarca);

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
               <p></p>
               <span data-toggle="modal" data-target="#modalNuevoMarca" class="btn btn-info form-control">
               <span class="glyphicon glyphicon-pencil"></span> Agregar Nueva Marca
               </span><p></p>
               <h2>Nuevo Producto</h2>
               <form id="frmProducto" enctype="multipart/form-data">
                  <input readonly type="text" name="familia" id="familia" title="Familia" class="form-control" value="<?php echo $resultFam; ?>"><p></p>
                  <input readonly type="text" name="grupo" id="grupo" title="Grupo" class="form-control" value="<?php echo $resultGru[0]; ?>"><p></p>
                  <input type="text" hidden name="grupoID" id="grupoID" value="<?php echo $grupoID; ?>">
                  <select class="form-control" name="marca" id="marca" title="Selecciona Marca">
                     <option value="A">Selecciona Marca</option>
                     <?php while($verMarca=mysqli_fetch_row($resultMarca)): ?>
                     <option value="<?php echo $verMarca[0]; ?>">
                        <?php echo $verMarca[1]; ?>
                     </option>
                     <?php endwhile; ?>
                  </select><p></p>
                  <input type="text" name="modelo" id="modelo" placeholder="Modelo" title="Modelo" class="form-control"><p></p>
                  <input type="text" name="descripcion" id="descripcion" placeholder="Descripcion" title="Descripcion" class="form-control"><p></p>
                  <textarea rows="7" name="detalle" id="detalle" placeholder="Caracteristicas" title="Caracteristicas" class="form-control"></textarea><p></p>
                  <input type="file" name="imagen" id="imagen"><p></p>
                  <input type="reset" class="btn btn-danger" name="Limpiar" value="Limpiar">
                  <span class="btn btn-success" id="btnAgregaProducto">Agregar</span>
               </form>
            </div>
            <div class="col-sm-9">
               <div class="col-sm-8">
                  <h2>Productos en <?php echo $resultFam." ".$resultGru[0]; ?></h2>
               </div>
               <div class="col-sm-4" style="text-align: right">
                  <p></p>
                  <a href="grupo.php?familia=<?php echo $resultGru[1]; ?>" class="btn btn-info">Volver a Grupos
                   <span class="glyphicon glyphicon-refresh"></span>
                  </a>
               </div>
          	   <div id="cargaTablaProducto"></div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="actualizaProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel">Actualiza Producto</h4>
               </div>
               <div class="modal-body">
                  <form id="frmProductoU">
                     <input type="text" hidden id="idProductoU" name="idProductoU">
                     <input type="text" name="modeloU" id="modeloU" placeholder="Modelo" title="Modelo" class="form-control"><p></p>
                     <input type="text" name="descripcionU" id="descripcionU" placeholder="Descripcion" title="Descripcion" class="form-control"><p></p>
                     <textarea rows="7" name="detalleU" id="detalleU" placeholder="Caracteristicas" title="Caracteristicas" class="form-control"></textarea>
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" id="btnActualizaProducto" class="btn btn-success" data-dismiss="modal">Guardar Cambios
                  </button>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#cargaTablaProducto').load('tablas/tablaProductos.php?grupo=<?php echo $grupoID;?>');

      $('#btnAgregaProducto').click(function(){
			vacios = validarFrmVacio('frmProducto');
			if(vacios > 0){
				alertify.alert("Debes llenar todos los datos.");
				return false;
			}
         var formData = new FormData(document.getElementById("frmProducto"));
			$.ajax({
            url: "../procesos/productos/agregarProducto.php",
   			type: "post",
            dataType: "html",
   			data: formData,
            cache: false,
            contentType: false,
            processData: false,
   			success:function(r){
					if(r==1){
						$('#frmProducto')[0].reset();
		            $('#cargaTablaProducto').load('tablas/tablaProductos.php?grupo=<?php echo $grupoID;?>');
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
   function agregaDato(idProd){
      $.ajax({
         type: "POST",
         data: "productoID="+idProd,
         url: "../procesos/productos/traerDatos.php",
         success: function(r){
            dato=jQuery.parseJSON(r);
            $('#idProductoU').val(dato['producto']);
            $('#modeloU').val(dato['modelo']);
            $('#descripcionU').val(dato['descripcion']);
            $('#detalleU').val(dato['detalle']);
         }
      });
   }
</script>

<script type="text/javascript">
   $(document).ready(function(){
      $('#btnActualizaProducto').click(function(){
         datos=$('#frmProductoU').serialize();
         $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/productos/actualizarProducto.php",
            success:function(r){
               if(r==1){
                  $('#cargaTablaProducto').load('tablas/tablaProductos.php?grupo=<?php echo $grupoID;?>');
                  alertify.success("Actualizado con exito.");
               }else{
                  alertify.error("No se pudo actualizar.");
               }
            }
         });
      });
   });
</script>

<script type="text/javascript">
   $(document).ready(function(){
      $('#marca').select2();
   });
</script>

<?php
} else {
   header("location:inicio.php");
}
?>
