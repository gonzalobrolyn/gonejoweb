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
            <div class="col-sm-6" style="text-align:center">
               <h2>Inventario de Almacen</h2>
            </div>
            <div class="col-sm-6">

            </div>
         </div>
         <div class="row">
            <div id="cargaTablaInventario"></div>
         </div>
      </div>
   </body>
</html>

<script type="text/javascript">
   $(document).ready(function(){
      $('#cargaTablaInventario').load('tablas/tablaInventario.php');
   });
</script>

<?php
} else {
   header("location:inicio.php");
}
?>
