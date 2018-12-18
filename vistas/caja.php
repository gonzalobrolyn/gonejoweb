
<?php
  session_start();
  if(isset($_SESSION['usuarioNombre']) and $_SESSION['usuarioCargo']=="Empresa"){
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
          <h2>Nueva Caja</h2>

          <form id="frmCajas" enctype="multipart/form-data">
            <input type="text" name="codigo" id="codigo" placeholder="Código Unico" title="Código Unico" maxlength="9" class="form-control"><p></p>
            <input type="text" name="llave" id="llave" placeholder="Nueva Llave" title="Nueva Llave" class="form-control"><p></p>
            <input type="text" name="sede" id="sede" placeholder="Nombre de Local" title="Nombre de Local" class="form-control"><p></p>
            <input type="text" name="direccion" id="direccion" placeholder="Dirección" title="Dirección" class="form-control"><p></p>
            <input type="text" name="ciudad" id="ciudad" placeholder="Distrito Provincia Region" title="Distrito Provincia Region" class="form-control"><p></p>
            <input type="text" name="telefono" id="telefono" placeholder="Telefono" title="Telefono" maxlength="9" class="form-control"><p></p>
            <input type="text" name="efectivo" id="efectivo" placeholder="Capital S/." title="Capital" class="form-control"><p></p>
            <caption>Logo</caption>
            <input type="file" name="logo" id="logo"><p></p>
            <input type="reset" name="Limpiar" value="Limpiar" class="btn btn-default">
            <span id="btnAgregaCaja" class="btn btn-info">Agregar</span>
          </form>
        </div>
        <div class="col-sm-9">
          <div class="row">
            <h2>Datos de Cajas</h2>
            <div id="cargaTablaCajas"></div>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>

<script type="text/javascript">
  $(document).ready(function(){
    $('#cargaTablaCajas').load("tablas/tablaCajas.php");
    $('#btnAgregaCaja').click(function(){
      vacios = validarFrmVacio('frmCajas');
      if (vacios > 0) {
        alertify.alert("Debes llenar todos los datos.");
        return false;
      }
      var formData = new FormData(document.getElementById("frmCajas"));
      $.ajax({
        url: "../procesos/cajas/agregarCaja.php",
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(r){
          if (r == 1) {
            $('#frmCajas')[0].reset();
            $('#cargaTablaCajas').load("tablas/tablaCajas.php");
            alertify.success("Agregado con exito.");
          } else {
            alertify.error("Fallo al agregar.");
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
