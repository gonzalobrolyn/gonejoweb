
<?php
   session_start();
   if(isset($_SESSION['usuarioNombre'])){
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
            <div class="col-sm-6">
               <h2>Movimientos del Día</h2>
            </div>
            <div class="col-sm-6">

            </div>
            <div class="col-sm-12">
              <div id="cargaTablaDiario"></div>
            </div>
         </div>
      </div>
   </body>
</html>

<script type="text/javascript">
   $(document).ready(function(){
      $('#cargaTablaDiario').load("tablas/tablaDiario.php");
   });
</script>

<?php
} else {
  header("location:../index.php");
}
?>
