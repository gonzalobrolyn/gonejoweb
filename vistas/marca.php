
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
          <h2>Nueva Marca</h2>
          <form id="frmMarca">
            <input type="text" name="nombre" id="nombre" placeholder="Nombre" title="Nombre" class="form-control"><p></p>
            <input type="reset" class="btn btn-danger" name="Limpiar" value="Limpiar">
            <span class="btn btn-success" id="btnAgregaMarca">Agregar</span>
          </form>
        </div>
        <div class="col-sm-9">
          	<h2>Datos de Marcas</h2>
          	<div id="cargaTablaMarca"></div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="actualizaMarca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Actualiza Marca</h4>
             </div>
             <div class="modal-body">
                <form id="frmMarcaU">
                   <input type="text" hidden="" id="idmarca" name="idmarca">
                   <label>Nombre de la Marca</label>
                   <input type="text" id="marcaU" name="marcaU" class="form-control input-sm">
                </form>
             </div>
             <div class="modal-footer">
                <button type="button" id="btnActualizaMarca" class="btn btn-success" data-dismiss="modal">Guardar Cambios
                </button>
             </div>
          </div>
      </div>
    </div>
  </body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#cargaTablaMarca').load('tablas/tablaMarcas.php');
		$('#btnAgregaMarca').click(function(){

			vacios = validarFrmVacio('frmMarca');
			if(vacios > 0){
				alertify.alert("Debes llenar todos los datos.");
				return false;
			}

			datos = $('#frmMarca').serialize();
			$.ajax({
				type:"POST",
				data:datos,
				url:"../procesos/marcas/agregarMarca.php",
				success:function(r){
					if(r==1){
						$('#frmMarca')[0].reset();
            $('#cargaTablaMarca').load('tablas/tablaMarcas.php');
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
   function agregaDato(idMarca,marca){
      $('#idmarca').val(idMarca);
      $('#marcaU').val(marca);
   }
</script>

<script type="text/javascript">
   $(document).ready(function(){
      $('#btnActualizaMarca').click(function(){

         datos=$('#frmMarcaU').serialize();
         $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/marcas/actualizarMarca.php",
            success:function(r){
               if(r==1){
                  $('#cargaTablaMarca').load('tablas/tablaMarcas.php');
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
