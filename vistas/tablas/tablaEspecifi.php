
<?php
  require_once "../../clases/Gonexion.php";

  $idProd = $_GET['idProd'];

  $c = new conectar();
  $conexion = $c->conexion();
  $sql = "SELECT especifi_id,
                 especifi_nombre,
                 especifi_detalle
            from especifi
           where especifi_producto = '$idProd'";
  $result = mysqli_query($conexion, $sql);
?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center">

  <?php while($ver=mysqli_fetch_row($result)): ?>
    <tr>
      <td><?php echo $ver[1]; ?></td>
      <td><?php echo $ver[2]; ?></td>
      <td>
         <span class="btn btn-success btn-sm" data-toggle="modal" data-target="#actualizaMarca" onclick="agregaDato('<?php echo $ver[0] ?>','<?php echo $ver[1] ?>')">
            <span class="glyphicon glyphicon-pencil"></span>
         </span>
      </td>
      <td>
         <span class="btn btn-danger btn-sm" data-toggle="modal" data-target="#actualizaMarca" onclick="agregaDato('<?php echo $ver[0] ?>','<?php echo $ver[1] ?>')">
            <span class="glyphicon glyphicon-trash"></span>
         </span>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
