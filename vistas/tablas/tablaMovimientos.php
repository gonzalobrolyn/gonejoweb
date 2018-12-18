
<?php
  session_start();
  require_once "../../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();
  $idCaja = $_SESSION['cajaID'];
  $sql = "SELECT mov.movimiento_nombre,
                 mov.movimiento_efectivo,
                 mov.movimiento_monto,
                 mov.movimiento_nuevoefe,
                 mov.movimiento_detalle,
                 mov.movimiento_fecha,
                 per.persona_nombre,
                 per.persona_apellido,
                 per.persona_razon,
                 usu.persona_nombre,
                 usu.persona_apellido,
                 usu.persona_celular
            from movimiento as mov
      inner join persona as per
              on mov.movimiento_persona = per.persona_id
      inner join persona as usu
              on mov.movimiento_persona_usu = usu.persona_id
           where mov.movimiento_caja = '$idCaja'";
  $result = mysqli_query($conexion, $sql);
?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center">
  <tr>
      <td><b>Fecha</b></td>
      <td><b>Movimiento</b></td>
      <td><b>¿Quien?</b></td>
      <td><b>Caja Efectivo</b></td>
      <td><b>Monto</b></td>
      <td><b>Nuevo Efectivo</b></td>
      <td><b>Descripción</b></td>
      <td><b>Usuario</b></td>
      <td><b>Celular</b></td>
  </tr>
  <?php while($ver=mysqli_fetch_row($result)): ?>
    <tr>
      <td><?php echo $ver[5]; ?></td>
      <td><?php echo $ver[0]; ?></td>
      <td><?php echo $ver[6]." ".$ver[7]." ".$ver[8]; ?></td>
      <td><?php echo $ver[1]; ?></td>
      <td><?php echo $ver[2]; ?></td>
      <td><?php echo $ver[3]; ?></td>
      <td><?php echo $ver[4]; ?></td>
      <td><?php echo $ver[9]." ".$ver[10]; ?></td>
      <td><?php echo $ver[11]; ?></td>
    </tr>
  <?php endwhile; ?>
</table>
