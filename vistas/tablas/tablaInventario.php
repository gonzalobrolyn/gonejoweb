
<?php
   session_start();
   require_once "../../clases/Gonexion.php";
   $c = new conectar();
   $conexion = $c->conexion();

   $caja = $_SESSION['cajaID'];

   $sqlPro = "SELECT alm.almacen_id,
                     pro.producto_codigo,
                     gru.grupo_nombre,
                     mar.marca_nombre,
                     pro.producto_modelo,
                     pro.producto_descripcion,
                     alm.almacen_cantidad,
                     alm.almacen_preciofactura,
                     alm.almacen_preciollegada,
                     alm.almacen_precioempresa,
                     alm.almacen_preciotraspaso,
                     alm.almacen_preciocantidad,
                     alm.almacen_preciorebaja,
                     alm.almacen_precioventa
                from almacen as alm
          inner join producto as pro
                  on alm.almacen_producto = pro.producto_id
          inner join grupo as gru
                  on pro.producto_grupo = gru.grupo_id
          inner join marca as mar
                  on pro.producto_marca = mar.marca_id
               where alm.almacen_caja = '$caja'";
   $queryPro = mysqli_query($conexion, $sqlPro);
   ?>

   <table class="table table-hover table-condensed table-bordered" style="text-align: center">
      <tr>
         <td><b>CODIGO</b></td>
         <td><b>GRUPO</b></td>
         <td><b>MARCA</b></td>
         <td><b>MODELO</b></td>
         <td><b>DESCRIPCION</b></td>
         <td><b>CANTIDAD</b></td>
         <td><b>P LLEGADA</b></td>
         <td><b>P TRASPASO</b></td>
         <td><b>P VENTA</b></td>
      </tr>
      <?php while($ver=mysqli_fetch_row($queryPro)): ?>
      <tr>
         <td><?php echo $ver[1]; ?></td>
         <td><?php echo $ver[2]; ?></td>
         <td><?php echo $ver[3]; ?></td>
         <td><?php echo $ver[4]; ?></td>
         <td><?php echo $ver[5]; ?></td>
         <td><?php echo $ver[6]; ?></td>
         <td><?php echo $ver[8]; ?></td>
         <td><?php echo $ver[10]; ?></td>
         <td><?php echo $ver[13]; ?></td>
      </tr>
      <?php endwhile; ?>
   </table>
