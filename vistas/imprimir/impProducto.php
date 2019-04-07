<?php
   session_start();
   require_once "../../clases/Gonexion.php";
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
            where alm.almacen_id = '$idProAlm'
              and alm.almacen_caja = '$idCaja'";
   $consulta = mysqli_query($conexion, $sql);
   $ver = mysqli_fetch_row($consulta);

   $sqlEsp = "SELECT especifi_id,
                     especifi_nombre,
                     especifi_detalle
                from especifi
               where especifi_producto = '$idProAlm'";
   $result = mysqli_query($conexion, $sqlEsp);
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
            <div class="col-sm-12" style="text-align: center">
               <br><br><br><br><br>
               <h4><?php echo $ver[1]." - ".$ver[2]." ".$ver[3]; ?></h4>
               <p><?php echo $ver[4]; ?></p>
               <p><?php echo $ver[5]; ?></p>

               <?php while($verEsp=mysqli_fetch_row($result)): ?>
                  <p><?php echo $verEsp[1]." - ".$verEsp[2]; ?></p>
               <?php endwhile; ?>
               <h4>
                  <?php echo "Precio: S/ ".ceil($ver[6]).".00"; ?>
               </h4>
            </div>
         </div>
         <div class="row">
            <div class="col-sm-12">
               <img height="200" width="200" src="<?php echo $img; ?>"/>
            </div>
         </div>
      </div>
   </body>
</html>
