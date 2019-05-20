
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
      <div class="modal fade" id="modalIngreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel">Ingreso de Capital</h4>
            </div>
            <div class="modal-body">
               <form id="frmIngreso">
                  <label for="ingresoCap">Monto a ingresar:</label>
                  <input type="number" name="ingresoCap" id="ingresoCap" class="form-control"> <p></p>
                  <label for="">Concepto del ingreso:</label>
                  <input type="text" name="conceptoIn" id="conceptoIn" class="form-control">
                  <p></p>
                  <p style="text-align: right">
                     <span name="btnIngresoCap" id="btnIngresoCap" class="btn btn-success">
                     Ingresar
                     </span>
                  </p>
               </form>
            </div>
         </div>
      </div>
      </div>
      <div class="modal fade" id="modalEgreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel">Retiro de Capital</h4>
            </div>
            <div class="modal-body">
               <form id="frmEgreso">
                  <label for="egresoCap">Monto a Retirar:</label>
                  <input type="text" name="egresoCap" id="egresoCap" class="form-control">
                  <p></p>
                  <label for="">Concepto del retiro:</label>
                  <input type="text" name="conceptoEg" id="conceptoEg" class="form-control">
                  <p></p>
                  <p style="text-align: right">
                     <span name="btnEgresoCap" id="btnEgresoCap" class="btn btn-danger">
                     Retirar
                     </span>
                  </p>
               </form>
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

    $('#btnIngresoCap').click(function(){
      vacios = validarFrmVacio('frmIngreso');
      if(vacios > 0){
         alertify.alert("Debes llenar un monto.");
         return false;
      }
      datos = $('#frmIngreso').serialize();
      $.ajax({
         type:"POST",
         data:datos,
         url:"../procesos/cajas/ingresoCapital.php",
         success:function(r){
            if(r==1){
               $('#frmIngreso')[0].reset();
               $('#modalIngreso').modal("hide");
               $('#cargaTablaCajas').load("tablas/tablaCajas.php");
               alertify.success("Agregado con exito.");
            }else{
               alertify.error("Fallo al agregar.");
            }
         }
      });
   });

   $('#btnEgresoCap').click(function(){
     vacios = validarFrmVacio('frmEgreso');
     if(vacios > 0){
        alertify.alert("Debes llenar un monto.");
        return false;
     }
     datos = $('#frmEgreso').serialize();
     $.ajax({
        type:"POST",
        data:datos,
        url:"../procesos/cajas/egresoCapital.php",
        success:function(r){
           if(r==1){
             $('#frmEgreso')[0].reset();
             $('#modalEgreso').modal("hide");
             $('#cargaTablaCajas').load("tablas/tablaCajas.php");
             alertify.success("Retirado con exito.");
           }else{
             alertify.error("Fallo al retirar.");
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
