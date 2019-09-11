
<?php
   session_start();
   require_once "../../clases/Gonexion.php";

   $c = new conectar();
   $conexion = $c->conexion();

   $idAlma = $_GET['idAlmacen'];
   $idCaja = $_SESSION['cajaID'];

   $sql = "SELECT img.imagen_ruta,
                  gru.grupo_nombre,
                  mar.marca_nombre,
                  pro.producto_modelo,
                  pro.producto_descripcion,
                  pro.producto_detalle,
                  alm.almacen_cantidad,
                  alm.almacen_precioempresa,
                  alm.almacen_preciotraspaso,
                  alm.almacen_preciocantidad,
                  alm.almacen_preciorebaja,
                  alm.almacen_precioventa
             from almacen as alm
       inner join producto as pro
               on alm.almacen_producto = pro.producto_id
       inner join imagen as img
               on pro.producto_imagen = img.imagen_id
       inner join grupo as gru
               on pro.producto_grupo = gru.grupo_id
       inner join marca as mar
               on pro.producto_marca = mar.marca_id
            where alm.almacen_id = '$idAlma'
              and alm.almacen_caja = '$idCaja'";
   $consulta = mysqli_query($conexion, $sql);
   $ver = mysqli_fetch_row($consulta);
?>

<div>
   <div class="col-sm-6" style="text-align: center">

      <p><?php echo 'E'.ceil($ver[7]).'T'.ceil($ver[8]).'C'.ceil($ver[9]).'R'.ceil($ver[10]); ?></p>
      <h4><?php echo $ver[1]." - ".$ver[2]; ?></h4>
      <h4><?php echo $ver[3]; ?></h4>
      <p><?php echo $ver[4]; ?></p>
      <p><?php echo $ver[5]; ?></p>
      <p><?php echo "Cantidad: ".$ver[6]; ?></p>
      <p><b><?php echo "Precio: S/ ".ceil($ver[11]).".00"; ?></b></p>
      <form id="frmAgreALista" style="text-align: center" class="form-inline">
         <input type="text" hidden name="idAlmacen" id="idAlmacen" value="<?php echo $idAlma; ?>">
         <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad" title="Cantidad" class="form-control input-sm">
         <input type="number" name="precio" id="precio" placeholder="Precio S/ ....00" title="Precio" class="form-control input-sm"><p></p>
         <span class="btn btn-primary btn-sm" id="btnAgreALista">Agregar a lista</span><p></p>
      </form>
   </div>
   <div class="col-sm-6">
      <?php
      $img = explode("/",$ver[0]);
      $ruta = $img[1]."/".$img[2]."/".$img[3];
      ?>
      <img src="<?php echo $ruta; ?>" class="img-responsive" />
   </div>
</div>

<script type="text/javascript">
   $(document).ready(function(){
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
   });
</script>
