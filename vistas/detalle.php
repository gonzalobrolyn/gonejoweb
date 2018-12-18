<?php
   session_start();
   if(isset($_SESSION['usuarioNombre'])){
      require_once "menu.php";
      require_once "../clases/Gonexion.php";
      $c = new conectar();
      $conexion = $c->conexion();

      $idProAlm = $_GET['idProAlm'];
      $idCaja = $_SESSION['cajaID'];

      $sql = "SELECT img.imagen_ruta,
                     gru.grupo_nombre,
                     mar.marca_nombre,
                     pro.producto_modelo,
                     pro.producto_descripcion,
                     pro.producto_detalle,
                     alm.almacen_cantidad,
                     alm.almacen_preciotraspaso,
                     alm.almacen_preciorebaja,
                     alm.almacen_precioventa,
                     alm.almacen_producto
                from almacen as alm
          inner join producto as pro
                  on alm.almacen_producto = pro.producto_id
          inner join imagen as img
                  on pro.producto_imagen = img.imagen_id
          inner join grupo as gru
                  on pro.producto_grupo = gru.grupo_id
          inner join marca as mar
                  on pro.producto_marca = mar.marca_id
               where alm.almacen_id = '$idProAlm'
                 and alm.almacen_caja = '$idCaja'";
      $consulta = mysqli_query($conexion, $sql);
      $ver = mysqli_fetch_row($consulta);
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
            <div class="col-sm-8" style="text-align: center">
               <p><?php echo 'T'.ceil($ver[7]).'R'.ceil($ver[8]).'GN'; ?></p>
               <h4><?php echo $ver[1]." - ".$ver[2]." ".$ver[3]; ?></h4>
               <p><?php echo $ver[4]; ?></p>
               <p><?php echo $ver[5]; ?></p>
            </div>
            <div class="col-sm-4" style="text-align: center">
               <button type="button" class="btn btn-info">Volver</button>
               <button type="button" class="btn btn-info" data-toggle="modal" data-target="#agregarEspecifi">Agregar dato</button>
               <button type="button" class="btn btn-info">Imprimir</button>
               <p></p>
               <div class="col-sm-6">
                  <?php echo "Disponible: ".$ver[6]; ?>
               </div>
               <div class="col-sm-6">
                  <?php echo "Precio: S/ ".ceil($ver[9]).".00"; ?>
               </div>
               <form id="frmAgreALista" style="text-align: center" class="form-inline">
                  <input type="text" hidden name="idAlmacen" id="idAlmacen" value="<?php echo $idAlma; ?>">
                  <input type="text" name="cantidad" id="cantidad" placeholder="Cantidad" title="Cantidad" class="form-control input-sm">
                  <input type="text" name="precio" id="precio" placeholder="Precio S/ ....00" title="Precio" class="form-control input-sm"><p></p>
                  <span class="btn btn-primary" id="btnAgreALista">Agregar a lista</span><p></p>
               </form>
            </div>
         </div>
         <div class="modal fade" id="agregarEspecifi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
           <div class="modal-dialog" role="document">
             <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Nueva Especificación</h4>
              </div>
              <div class="modal-body">
                  <form id="frmNuevaEspecifi">
                     <input type="text" hidden name="producto" id="producto" value="<?php echo $ver[10]; ?>">
                     <input type="text" name="atributo" id="atributo" placeholder="Atributo" title="Atributo" class="form-control input-sm"><p></p>
                     <input type="text" name="especificacion" id="especificacion" placeholder="Especificación" title="Especificación" class="form-control input-sm"><p></p>
                     <input type="reset" name="Limpiar" value="Limpiar" class="btn btn-default btn-sm">
                     <span class="btn btn-info btn-sm" id="btnAgregaEspecifi">Agregar especificación</span>
                  </form>
              </div>
              <div class="modal-footer">
              </div>
             </div>
           </div>
         </div>
         <div class="row">
            <div class="col-sm-5">
               <?php
               $img = explode("/",$ver[0]);
               $ruta = $img[1]."/".$img[2]."/".$img[3];
               ?>
               <img src="<?php echo $ruta; ?>" class="img-responsive" />
            </div>
            <div class="col-sm-7" id="cargaTablaEspecifi">
            </div>
         </div>
      </div>
   </body>
</html>

<script type="text/javascript">
   $(document).ready(function(){
      $('#cargaTablaEspecifi').load("tablas/tablaEspecifi.php?idProd=<?php echo $ver[10]; ?>");

      $('#btnAgreALista').click(function(){
        vacios = validarFrmVacio('frmAgreALista');
        if (vacios > 0) {
          alertify.alert("Debes llenar todos los datos.");
          return false;
        }
        datos = $('#frmAgreALista').serialize();
        $.ajax({
          type: "POST",
          data: datos,
          url: "../procesos/ventas/agreProLisTmp.php",
          success: function(r){
           $('#frmAgreALista')[0].reset();
           $('#cargaTablaVentas').load("tablas/tablaVentasTmp.php");
          }
        });
      });

      $('#btnAgregaEspecifi').click(function(){
        vacios = validarFrmVacio('frmNuevaEspecifi');
        if (vacios > 0) {
          alertify.alert("Debes llenar todos los datos.");
          return false;
        }
        datos = $('#frmNuevaEspecifi').serialize();
        $.ajax({
          type: "POST",
          data: datos,
          url: "../procesos/detalle/nuevaEspecifi.php",
          success: function(r){
           $('#frmNuevaEspecifi')[0].reset();
           $('#cargaTablaEspecifi').load("tablas/tablaEspecifi.php?idProd=<?php echo $ver[10]; ?>");
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
