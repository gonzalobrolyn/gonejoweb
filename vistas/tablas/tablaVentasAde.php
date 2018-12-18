
<?php session_start(); ?>

<table class="table table-bordered table-hover table-condensed" style="text-align: center">
  <tr>
    <td><b>Cant.</b></td>
    <td><b>Grupo</b></td>
    <td><b>Marca</b></td>
    <td><b>Modelo</b></td>
    <td><b>Descripción</b></td>
    <td><b>P. Unidad</b></td>
    <td><b>Importe</b></td>
    <td><b>Quitar</b></td>
  </tr>
  <?php
  $total = 0;
  if (isset($_SESSION['listaCompraDep'])):
    $i = 0;
    foreach (@$_SESSION['listaCompraDep'] as $key) {
      $d = explode("||", @$key);
  ?>
      <tr>
        <td><?php echo $d[5]; ?></td>
        <td><?php echo $d[1]; ?></td>
        <td><?php echo $d[2]; ?></td>
        <td><?php echo $d[3]; ?></td>
        <td><?php echo $d[4]; ?></td>
        <td><?php echo $d[6]; ?></td>
        <td><?php echo $d[5]*$d[6]; ?></td>
        <td>
          <span class="btn btn-danger btn-xs" onclick="quitarProducto('<?php echo $i; ?>')">
            <span class="glyphicon glyphicon-remove"></span>
          </span>
        </td>
      </tr>
  <?php
      $total = $total + $d[5]*$d[6];
      $i++;
    }
  endif;
  ?>
  <tr>
    <td colspan="5" style="text-align: right"><b>TOTAL</b></td>
    <td colspan="2"><?php echo "S/ ".$total; ?></td>
  </tr>
</table>
