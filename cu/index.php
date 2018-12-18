
<?php
  session_start();
  if(isset($_SESSION['usuarioNombre']) && $_SESSION['usuarioNombre'] == "gonzalobrolyn"){
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Gonejo Web</title>
    <?php require_once "../vistas/dependencias.php"; ?>
    <link rel="icon" type="image/png" href="../imagenes/mifavicon.png" />
  </head>
  <body>
    <header class="navbar navbar-fixed-top navbar-default" role="navigation">
      <div class="container-fluid">

        <div class="nav navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">MENU</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="../vistas/inicio.php">
            <span class="btn btn-primary btn-lg">
              <span class="glyphicon glyphicon-fire" style="color: #22d0ff"></span> gonejo web</span>
          </a>
        </div>
        <div id="main-nav" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a style="color: red" href="../procesos/salir.php">
              <span class="glyphicon glyphicon-off"></span> Salir </a>
            </li>
          </ul>
        </div>
      </div>
    </header>
    <div class="container">
      <h2>Cajas</h2>
      <div class="row">
        <div class="col-sm-2">
          <form id="frmCU">
            <input type="text" class="form-control input-sm" name="codigoUnico" id="codigoUnico" maxlength="9" placeholder="Codigo" title="Codigo"><p></p>
            <input type="text" class="form-control input-sm" name="llaveCaja" id="llaveCaja" placeholder="Llave" title="Llave"><p></p>
            <input type="reset" class="btn btn-danger" name="Limpiar" value="Limpiar">
            <span class="btn btn-info" id="crearCU">Crear</span>
          </form>
        </div>
        <div class="col-sm-10">
          <div id="cargaTablaCajas"></div>
        </div>
      </div>
    </div>
    <footer>

    </footer>
  </body>
</html>

<script type="text/javascript">
  $(document).ready(function(){
    $('#cargaTablaCajas').load("tablaCajas.php");
    $('#crearCU').click(function(){
      vacios = validarFrmVacio('frmCU');
      if (vacios > 0) {
        alertify.alert("Debes agregar datos.");
        return false;
      }
      datos = $('#frmCU').serialize();
      $.ajax({
        type:"POST",
        data:datos,
        url:"crearCodigo.php",
        success:function(r){
          if(r==1){
            $('#frmCU')[0].reset();
            $('#cargaTablaCajas').load("tablaCajas.php");
            alertify.success("Codigo y llave agregados con exito.");
          } else {
            alertify.error("El codigo y llave no fueron agregados.");
          }
        }
      });
    });
  });
</script>

<?php
} else {
  header("location:../vistas/inicio.php");
}
?>
