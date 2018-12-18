
<?php
  require_once "../../clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();

  $familiaID = $_GET['familia'];

  $sql = "SELECT gru.grupo_id,
                 gru.grupo_nombre,
                 gru.grupo_fecha,
                 per.persona_nombre,
                 per.persona_apellido
            from grupo as gru
      inner join persona as per
              on gru.grupo_persona = per.persona_id
           where gru.grupo_familia = '$familiaID'";
  $result = mysqli_query($conexion, $sql);
?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center">
  <tr>
    <td><b>Nombre de grupo</b></td>
    <td><b>Editado</b></td>
    <td><b>Editor</b></td>
    <td><b>Editar</b></td>
  </tr>
  <?php while($ver=mysqli_fetch_row($result)): ?>
    <tr>
      <td>
         <a href="producto.php?grupo=<?php echo $ver[0]; ?>"><?php echo $ver[1]; ?></a>
      </td>
      <td><?php echo $ver[2]; ?></td>
      <td><?php echo $ver[3]." ".$ver[4]; ?></td>
      <td>
         <span class="btn btn-danger btn-sm" data-toggle="modal" data-target="#actualizaGrupo" onclick="agregaDato('<?php echo $ver[0] ?>','<?php echo $ver[1] ?>')">
				<span class="glyphicon glyphicon-pencil"></span>
			</span>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
