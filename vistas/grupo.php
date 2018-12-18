
<?php
   session_start();
   if(isset($_SESSION['usuarioNombre']) && ($_SESSION['usuarioCargo']=="Empresa" || $_SESSION['usuarioCargo']=="Administrador")){

      require_once "../clases/Gonexion.php";
      require_once "menu.php";

      $c = new conectar();
      $conexion = $c->conexion();
      $familiaID = $_GET['familia'];

      $sql = "SELECT familia_nombre
                from familia
               where familia_id = '$familiaID'";
      $query = mysqli_query($conexion, $sql);
      $nombreFam = mysqli_fetch_row($query)[0];
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
               <h2>Nuevo Grupo</h2>
               <form id="frmGrupo">
                  <input type="text" name="familia" id="familia" hidden value="<?php echo $familiaID; ?>">
                  <input type="text" name="nombre" id="nombre" placeholder="Nombre" title="Nombre" class="form-control"><p></p>
                  <input type="reset" class="btn btn-danger" name="Limpiar" value="Limpiar">
                  <span class="btn btn-success" id="btnAgregaGrupo">Agregar</span>
               </form>
            </div>
            <div class="col-sm-9">
               <div class="col-sm-8">
                  <h2>Grupos dentro de <?php echo $nombreFam; ?></h2>
               </div>
               <div class="col-sm-4" style="text-align: right">
                  <p></p>
                  <a href="familia.php" class="btn btn-info">Volver a Familias
                   <span class="glyphicon glyphicon-refresh"></span>
                  </a>
               </div>
          	   <div id="cargaTablaGrupo"></div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="actualizaGrupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel">Actualiza Grupo</h4>
               </div>
               <div class="modal-body">
                  <form id="frmGrupoU">
                     <input type="text" hidden="" id="idgrupo" name="idgrupo">
                     <label>Nombre del Grupo</label>
                     <input type="text" id="grupoU" name="grupoU" class="form-control input-sm">
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" id="btnActualizaGrupo" class="btn btn-success" data-dismiss="modal">Guardar Cambios
                  </button>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#cargaTablaGrupo').load('tablas/tablaGrupos.php?familia=<?php echo $familiaID;?>');
		$('#btnAgregaGrupo').click(function(){

			vacios = validarFrmVacio('frmGrupo');
			if(vacios > 0){
				alertify.alert("Debes llenar todos los datos.");
				return false;
			}

			datos = $('#frmGrupo').serialize();
			$.ajax({
				type:"POST",
				data:datos,
				url:"../procesos/grupos/agregarGrupo.php",
				success:function(r){
					if(r==1){
						$('#frmGrupo')[0].reset();
                  $('#cargaTablaGrupo').load('tablas/tablaGrupos.php?familia=<?php echo $familiaID;?>');
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
   function agregaDato(idGrupo,grupo){
      $('#idgrupo').val(idGrupo);
      $('#grupoU').val(grupo);
   }
</script>

<script type="text/javascript">
   $(document).ready(function(){
      $('#btnActualizaGrupo').click(function(){

         datos=$('#frmGrupoU').serialize();
         $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/grupos/actualizarGrupo.php",
            success:function(r){
               if(r==1){
                  $('#cargaTablaGrupo').load('tablas/tablaGrupos.php?familia=<?php echo $familiaID;?>');
                  alertify.success("Actualizado con exito.");
               }else{
                  alertify.error("No se pudo actualizar.");
               }
            }
         });
      });
   });
</script>

<?php
} else {
   header("location:inicio.php");
}
?>
