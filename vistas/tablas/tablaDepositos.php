
<?php
  session_start();
  require_once "../../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();
  $idCaja = $_SESSION['cajaID'];
  $sql = "SELECT per.persona_ruc,
                 per.persona_razon,
                 per.persona_celular,
                 mov.movimiento_monto,
                 mov.movimiento_numerocom,
                 mov.movimiento_detalle,
                 mov.movimiento_fecha,
                 mov.movimiento_id
            from movimiento as mov
      inner join persona as per
              on mov.movimiento_persona = per.persona_id
           where mov.movimiento_caja = '$idCaja'
             and mov.movimiento_nombre = 'Deposito'";
  $result = mysqli_query($conexion, $sql);
?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center">
  <tr>
    <td><b>RUC</b></td>
    <td><b>Proveedor</b></td>
    <td><b>Celular</b></td>
    <td><b>Monto</b></td>
    <td><b>Boucher N°</b></td>
    <td><b>Concepto</b></td>
    <td><b>Fecha</b></td>
    <td><b>Usar</b></td>
  </tr>
  <?php while($ver=mysqli_fetch_row($result)): ?>
    <tr>
      <td><?php echo $ver[0]; ?></td>
      <td><?php echo $ver[1]; ?></td>
      <td><?php echo $ver[2]; ?></td>
      <td><?php echo $ver[3]; ?></td>
      <td><?php echo $ver[4]; ?></td>
      <td><?php echo $ver[5]; ?></td>
      <td><?php echo $ver[6]; ?></td>
      <td>
        <a href="usaDeposito.php?idMov=<?php echo $ver[7]?>" class="btn btn-danger btn-xs">
          <?php echo $ver[7]; ?>
          <span class="glyphicon glyphicon-shopping-cart">
          </span>
        </a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
