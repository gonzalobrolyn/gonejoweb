
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

    $sqlFamilia = "SELECT familia_id,
                          familia_nombre
                     from familia";
    $resultFamilia = mysqli_query($conexion, $sqlFamilia);

    $sqlMarca = "SELECT marca_id,
                        marca_nombre
                   from marca";
    $resultMarca = mysqli_query($conexion, $sqlMarca);

    $sqlFamiliaM = "SELECT familia_id,
                          familia_nombre
                     from familia";
    $resultFamiliaM = mysqli_query($conexion, $sqlFamiliaM);
    ?>

  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3">
            <span data-toggle="modal" data-target="#modalNuevoFamilia" class="btn btn-info form-control">
               <span class="glyphicon glyphicon-pencil"></span> Agregar Nueva Familia
            </span><p></p>
            <span data-toggle="modal" data-target="#modalNuevoGrupo" class="btn btn-info form-control">
               <span class="glyphicon glyphicon-pencil"></span> Agregar Nuevo Grupo
            </span><p></p>
            <span data-toggle="modal" data-target="#modalNuevoMarca" class="btn btn-info form-control">
               <span class="glyphicon glyphicon-pencil"></span> Agregar Nueva Marca
            </span><p></p>
          <h2>Nuevo Producto</h2>
          <form id="frmProducto" enctype="multipart/form-data">
            <select class="form-control" name="familia" id="familia" title="Selecciona Familia">
               <option value="A">Selecciona Familia</option>
               <?php while($verFamilia=mysqli_fetch_row($resultFamilia)): ?>
                  <option value="<?php echo $verFamilia[0]; ?>">
                     <?php echo $verFamilia[1]; ?>
                  </option>
               <?php endwhile; ?>
            </select><p></p>


            <div id="llamaGrupo">
               <p class="form-control" style="text-align: left">Para ver grupos elige una familia</p>
            </div>


            <select class="form-control" name="marca" id="marca" title="Selecciona Marca">
              <option value="A">Selecciona Marca</option>
              <?php while($verMarca=mysqli_fetch_row($resultMarca)): ?>
                <option value="<?php echo $verMarca[0]; ?>">
                  <?php echo $verMarca[1]; ?>
                </option>
              <?php endwhile; ?>
            </select><p></p>
            <input type="text" name="modelo" id="modelo" placeholder="Modelo" title="Modelo" class="form-control"><p></p>
            <textarea rows="7" name="detalle" id="detalle" placeholder="Caracteristicas" title="Caracteristicas" class="form-control"></textarea><p></p>
            <input type="file" name="imagen" id="imagen"><p></p>
            <input type="reset" class="btn btn-danger" name="Limpiar" value="Limpiar">
            <span class="btn btn-success" id="btnAgregaProducto">Agregar</span>
          </form>
        </div>
        <div class="col-sm-9">

            <h2>Datos de Producto</h2>
          	<div id="cargaTablaProducto"></div>

        </div>
      </div>
    </div>
    <div class="modal fade" id="modalNuevoFamilia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Nombre de la Nueva Familia</h4>
          </div>
          <div class="modal-body">
            <form id="frmNuevoFamilia">
             <input type="text" name="nombre" id="nombre" placeholder="Nombre de Familia Nueva" title="Nombre de Familia Nueva" class="form-control">
            </form>
          </div>
          <div class="modal-footer">
            <button id="btnNuevoFamilia" type="button" class="btn btn-success" data-dismiss="modal">Agregar Familia</button>
          </div>
        </div>
     </div>
    </div>
    <div class="modal fade" id="modalNuevoGrupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Nombre del Nuevo Grupo</h4>
          </div>
          <div class="modal-body">
            <form id="frmNuevoGrupo">
             <select class="form-control" name="familia" id="familia" title="Selecciona Familia">
                <option value="A">Selecciona Familia</option>
                <?php while($verFamiliaM=mysqli_fetch_row($resultFamiliaM)): ?>
                  <option value="<?php echo $verFamiliaM[0]; ?>">
                     <?php echo $verFamiliaM[1]; ?>
                  </option>
               <?php endwhile; ?>
             </select><p></p>
             <input type="text" name="nombre" id="nombre" placeholder="Nombre del Grupo Nuevo" title="Nombre del Grupo Nuevo" class="form-control">
            </form>
          </div>
          <div class="modal-footer">
            <button id="btnNuevoGrupo" type="button" class="btn btn-success" data-dismiss="modal">Agregar Grupo</button>
          </div>
        </div>
     </div>
    </div>
    <div class="modal fade" id="modalNuevoMarca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Nombre de la Nueva Marca</h4>
          </div>
          <div class="modal-body">
            <form id="frmNuevoMarca">
             <input type="text" name="nombre" id="nombre" placeholder="Nombre de Marca Nueva" title="Nombre de Marca Nueva" class="form-control">
            </form>
          </div>
          <div class="modal-footer">
            <button id="btnNuevoMarca" type="button" class="btn btn-success" data-dismiss="modal">Agregar Marca</button>
          </div>
        </div>
     </div>
    </div>
  </body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#btnNuevoFamilia').click(function(){
			vacios = validarFrmVacio('frmNuevoFamilia');
			if(vacios > 0){
				alertify.alert("Debes llenar todos los datos.");
				return false;
			}
			datos = $('#frmNuevoFamilia').serialize();
			$.ajax({
				type:"POST",
				data:datos,
				url:"../procesos/familias/agregarFamilia.php",
				success:function(r){
					if(r==1){
						$('#frmNuevoFamilia')[0].reset();
                  window.location="producto.php";
						alertify.success("Agregado con exito.");
					}else{
						alertify.error("Fallo al agregar.");
					}
				}
			});
		});

      $('#btnNuevoGrupo').click(function(){
         vacios = validarFrmVacio('frmNuevoGrupo');
         if(vacios > 0){
            alertify.alert("Debes llenar todos los datos.");
            return false;
         }
         datos = $('#frmNuevoGrupo').serialize();
         $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/grupos/agregarGrupo.php",
            success:function(r){
               if(r==1){
                  $('#frmNuevoGrupo')[0].reset();
                  window.location="producto.php";
                  alertify.success("Agregado con exito.");
               }else{
                  alertify.error("Fallo al agregar.");
               }
            }
         });
      });

      $('#btnNuevoMarca').click(function(){
         vacios = validarFrmVacio('frmNuevoMarca');
         if(vacios > 0){
            alertify.alert("Debes llenar todos los datos.");
            return false;
         }
         datos = $('#frmNuevoMarca').serialize();
         $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/marcas/agregarMarca.php",
            success:function(r){
               if(r==1){
                  $('#frmNuevoMarca')[0].reset();
                  window.location="producto.php";
                  alertify.success("Agregado con exito.");
               }else{
                  alertify.error("Fallo al agregar.");
               }
            }
         });
      });

      $("#familia").change(function(){
         if ($(this).val() != "A"){
            $.ajax({
               url: "producto2.php",
               type: "GET",
               data: {
                  opcion: $(this).val()
               }
            }).done(function(response){
               $("#llamaGrupo").html(response);
            }).fail(function(jqXHR, textStatus){
               $("#llamaGrupo").html("Ha ocurrido un error: " + textStatus);
            });
         }
      });

	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#cargaTablaProducto').load('tablas/tablaProductos.php');
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
            $('#cargaTablaProducto').load('tablas/tablaProductos.php');
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
    $('#familia').select2();
    $('#marca').select2();
  });
</script>

<?php
} else {
  header("location:inicio.php");
}
?>
