
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
      <script src="../librerias/printThis.js"></script>
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
              <p style="text-align: right">
              <span class="btn btn-info" name="imprimeDiario" id="imprimeDiario">
                 Imprimir Diario
              </span>
              </p>
            </div>
         </div>
         <div hidden>
            <div class="formatoDiario" id="impFormatoDiario"></div>
         </div>
      </div>
   </body>
</html>

<script type="text/javascript">
   $(document).ready(function(){
      $('#cargaTablaDiario').load("tablas/tablaDiario.php");
      $('#impFormatoDiario').load("imprimir/impDiario.php");

      $('#imprimeDiario').click(function(){
         $('.formatoDiario').printThis();
      });
   });
</script>

<?php
} else {
  header("location:../index.php");
}
?>
