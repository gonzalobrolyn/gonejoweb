
<?php
  session_start();
  require_once "../../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();

  $idCaja = $_SESSION['cajaID'];
  $suma = 0;
  $hoy = date('Y-m-d');

  $sql = "SELECT mov.movimiento_nombre,
                 mov.movimiento_monto,
                 mov.movimiento_fecha,
                 per.persona_nombre,
                 per.persona_apellido,
                 per.persona_razon,
                 usu.persona_nombre,
                 usu.persona_apellido,
                 mov.movimiento_efectivo,
                 mov.movimiento_nuevoefe
            from movimiento as mov
      inner join persona as per
              on mov.movimiento_persona = per.persona_id
      inner join persona as usu
              on mov.movimiento_persona_usu = usu.persona_id
           where mov.movimiento_caja = '$idCaja'";
  $result = mysqli_query($conexion, $sql);
?>
<h4 style="text-align: center">Cuenta del <?php echo $hoy; ?></h4>
<table class="table table-hover table-condensed table-bordered" style="text-align: center">
   <tr>
      <td><b>Hora</b></td>
      <td><b>Movimiento</b></td>
      <td><b>A Nombre</b></td>
      <td><b>Monto</b></td>
      <td><b>Efectivo</b></td>
      <td><b>Usuario</b></td>
   </tr>
   <?php while($ver=mysqli_fetch_row($result)):
      $dia = explode(" ", $ver[2]);

      if ($hoy == $dia[0] && $ver[0]==('Venta' || 'Adelanto')):
         if ($ver[8] < $ver[9]) {
            $suma = $suma + $ver[1];
         } else {
            $suma = $suma - $ver[1];
         }
   ?>
         <tr>
            <td><?php echo $dia[1]; ?></td>
            <td><?php echo $ver[0]; ?></td>
            <td><?php echo $ver[3]." ".$ver[4]." ".$ver[5]; ?></td>
            <td><?php echo $ver[1]; ?></td>
            <td><?php echo $suma.".00"; ?></td>
            <td><?php echo $ver[6]." ".$ver[7]; ?></td>

         </tr>
      <?php endif;
   endwhile; ?>
</table>