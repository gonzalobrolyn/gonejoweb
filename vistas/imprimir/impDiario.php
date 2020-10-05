
<?php
  session_start();
  require_once "../../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();

  $idCaja = $_SESSION['cajaID'];
  $suma = 0;
  $inversion = 0;
  $renta = 0;
  $hoy = date('Y-m-d');

  $sql = "SELECT mov.movimiento_id,
                 mov.movimiento_nombre,
                 mov.movimiento_efectivo,
                 mov.movimiento_detalle,
                 mov.movimiento_fecha,
                 per.persona_nombre,
                 per.persona_apellido,
                 per.persona_razon,
                 usu.persona_nombre
            from movimiento as mov
      inner join persona as per
              on mov.movimiento_persona = per.persona_id
      inner join persona as usu
              on mov.movimiento_persona_usu = usu.persona_id
           where mov.movimiento_caja = '$idCaja'
             and mov.movimiento_estado = 0
        order by mov.movimiento_id asc ";
  $result = mysqli_query($conexion, $sql);
?>
<h2 style="text-align: center">Blue Store</h2>
<h4 style="text-align: center">Cuenta del <?php echo $hoy; ?></h4>
<table class="table table-hover table-condensed table-bordered" style="text-align: center">
   <tr>
      <td><b>Usuario</b></td>
      <td><b>Hora</b></td>
      <td colspan="2"><b>A Nombre</b></td>
      <td><b>Movimiento</b></td>
      <td><b>Efectivo</b></td>
      <td><b>Suma</b></td>
   </tr>
   <?php while($ver=mysqli_fetch_row($result)):
      if ($ver[1] == "Egreso") {
         $suma = $suma - $ver[2];
      } else {
         $suma = $suma + $ver[2];
      }
   ?>
      <tr>
         <td><?php echo $ver[8]; ?></td>
         <td><?php echo $ver[4]; ?></td>
         <td colspan="2"><?php echo $ver[5]." ".$ver[6]." ".$ver[7]; ?></td>
         <td><?php echo $ver[1]; ?></td>
         <td><?php echo $ver[2]; ?></td>
         <td><?php echo $suma.".00"; ?></td>
      </tr>

      <?php
      $sqlDetalle = "SELECT sal.salida_id,
                            gru.grupo_nombre,
                            mar.marca_nombre,
                            pro.producto_modelo,
                            pro.producto_descripcion,
                            sal.salida_salecan,
                            sal.salida_precioventa,
                            sal.salida_precio
                       from salida as sal
                 inner join producto as pro
                         on sal.salida_producto = pro.producto_id
                 inner join grupo as gru
                         on pro.producto_grupo = gru.grupo_id
                 inner join marca as mar
                         on pro.producto_marca = mar.marca_id
                      where sal.salida_movimiento = '$ver[0]'";
      $queryDetalle = mysqli_query($conexion, $sqlDetalle);

      while ($verDetalle = mysqli_fetch_row($queryDetalle)):
      ?>
      <tr>
         <td colspan="2"><?php echo $verDetalle[1]." ".$verDetalle[2]." ".$verDetalle[3]." ".$verDetalle[4]; ?></td>
         <td><?php echo $verDetalle[5]; ?></td>
         <td><?php echo $verDetalle[7]; ?></td>
         <td><?php echo $verDetalle[6]; ?></td>
         <td><?php echo $verDetalle[5]*$verDetalle[6].".00"; ?></td>
      </tr>
      <?php
      $inversion = $inversion + $verDetalle[5] * $verDetalle[7];
      endwhile;
   endwhile;
   ?>
   <tr>
      <td colspan="6" style="text-align: right"><b>TOTAL VENTA S/</b></td>
      <td><b><?php echo $suma.".00"; ?></b></td>
   </tr>
   <tr>
      <td colspan="6" style="text-align: right"><b>TOTAL INVERSION S/</b></td>
      <td><b><?php echo $inversion; ?></b></td>
   </tr>
   <tr>
      <td colspan="6" style="text-align: right"><b>TOTAL RENTA S/</b></td>
      <td><b><?php echo $suma - $inversion; ?></b></td>
   </tr>
</table>
