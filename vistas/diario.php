
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
         <div class="row" style="text-align: center">
            <div class="col-sm-6">
               <h2>Movimientos del Día</h2>
            </div>
            <div class="col-sm-3">

            </div>
            <div class="col-sm-3">
               <br>
               <span class="btn btn-success" name="imprimeDiario" id="imprimeDiario">
                 Imprimir Diario
              </span>
            </div>
         </div>
         <div class="row" style="text-align: center">
            <div class="col-sm-12">
              <div id="cargaTablaDiario"></div>
            </div>
            <div class="col-sm-9">

            </div>
            <div class="col-sm-3">
               <span class="btn btn-danger" name="cerrarDiario" id="cerrarDiario">
                  Cerrar Diario
               </span>
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

      $('#cerrarDiario').click(function(){
         $.ajax({
            url:"../procesos/cajas/cierraDiario.php",
            success:function(r){
               if(r==1){
                  $('#cargaTablaDiario').load("tablas/tablaDiario.php");
                  $('#impFormatoDiario').load("imprimir/impDiario.php");
                  alertify.success("Diario cerrado con exito.");
               }else{
                  alertify.error("No se pudo cerrar diario.");
               }
            }
         });
      });

   });
</script>

<?php
} else {
  header("location:../index.php");
}
?>
