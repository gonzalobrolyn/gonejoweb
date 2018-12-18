
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
   </head>
   <body>
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-3">
               <h2>Nueva Familia</h2>
               <form id="frmFamilia">
                  <input type="text" name="nombre" id="nombre" placeholder="Nombre" title="Nombre" class="form-control"><p></p>
                  <input type="reset" class="btn btn-danger" name="Limpiar" value="Limpiar">
                  <span class="btn btn-success" id="btnAgregaFamilia">Agregar</span>
               </form>
            </div>
            <div class="col-sm-9">
          	   <h2>Lista de Familias</h2>
          	   <div id="cargaTablaFamilia"></div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="actualizaFamilia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel">Actualiza Familia</h4>
               </div>
               <div class="modal-body">
                  <form id="frmFamiliaU">
                     <input type="text" hidden="" id="idfamilia" name="idfamilia">
                     <label>Nombre de la Familia</label>
                     <input type="text" id="familiaU" name="familiaU" class="form-control input-sm">
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" id="btnActualizaFamilia" class="btn btn-success" data-dismiss="modal">Guardar Cambios
                  </button>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#cargaTablaFamilia').load('tablas/tablaFamilias.php');
		$('#btnAgregaFamilia').click(function(){

			vacios = validarFrmVacio('frmFamilia');
			if(vacios > 0){
				alertify.alert("Debes llenar todos los datos.");
				return false;
			}

			datos = $('#frmFamilia').serialize();
			$.ajax({
				type:"POST",
				data:datos,
				url:"../procesos/familias/agregarFamilia.php",
				success:function(r){
					if(r==1){
						$('#frmFamilia')[0].reset();
                  $('#cargaTablaFamilia').load('tablas/tablaFamilias.php');
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
   function agregaDato(idFamilia,familia){
      $('#idfamilia').val(idFamilia);
      $('#familiaU').val(familia);
   }
</script>

<script type="text/javascript">
   $(document).ready(function(){
      $('#btnActualizaFamilia').click(function(){

         datos=$('#frmFamiliaU').serialize();
         $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/familias/actualizarFamilia.php",
            success:function(r){
               if(r==1){
                  $('#cargaTablaFamilia').load('tablas/tablaFamilias.php');
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
