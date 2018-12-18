
<?php
  session_start();
  require_once "../../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();
  $idCaja = $_SESSION['cajaID'];
  $sql = "SELECT per.persona_dni,
                 per.persona_nombre,
                 per.persona_apellido,
                 per.persona_celular,
                 usu.usuario_nombre,
                 usu.usuario_cargo,
                 usu.usuario_sueldo,
                 usu.usuario_diapago,
                 usu.usuario_fecha
            from persona as per
      inner join usuario as usu
              on usu.usuario_persona = per.persona_id
           where usu.usuario_caja = '$idCaja'";
  $result = mysqli_query($conexion, $sql);
?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center">
  <tr>
    <td><b>DNI</b></td>
    <td><b>Nombre</b></td>
    <td><b>Celular</b></td>
    <td><b>Usuario</b></td>
    <td><b>Cargo</b></td>
    <td><b>Sueldo</b></td>
    <td><b>Dia D Pago</b></td>
    <td><b>Fecha D Inicio</b></td>
  </tr>
  <?php while($ver=mysqli_fetch_row($result)): ?>
    <tr>
      <td><?php echo $ver[0]; ?></td>
      <td><?php echo $ver[1]." ".$ver[2]; ?></td>
      <td><?php echo $ver[3]; ?></td>
      <td><?php echo $ver[4]; ?></td>
      <td><?php echo $ver[5]; ?></td>
      <td><?php echo $ver[6]; ?></td>
      <td><?php echo $ver[7]; ?></td>
      <td><?php echo $ver[8]; ?></td>
    </tr>
  <?php endwhile; ?>
</table>
