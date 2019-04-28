
<?php
   session_start();
   if(isset($_SESSION['usuarioNombre']) && ($_SESSION['usuarioCargo']=="Empresa" ||      $_SESSION['usuarioCargo']=="Administrador")){
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
         <div class="row" style="text-align:center">
            <div class="col-sm-6">
               <h2>Todos los Movimientos</h2>
            </div>
            <div class="col-sm-6">

            </div>
            <div class="col-sm-12">
              <div id="cargaTablaMovimientos"></div>
            </div>
         </div>
      </div>
   </body>
</html>

<script type="text/javascript">
   $(document).ready(function(){
      $('#cargaTablaMovimientos').load("tablas/tablaMovimientos.php");
   });
</script>

<?php
} else {
   header("location:inicio.php");
}
?>
