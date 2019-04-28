
<?php session_start(); ?>

<table class="table table-bordered table-hover table-condensed" style="text-align: center">
  <tr>
    <td><b>Codigo</b></td>
    <td><b>Producto</b></td>
    <td><b>Modelo</b></td>
    <td><b>Descripción</b></td>
    <td><b>Caracteristicas</b></td>
    <td><b>Cantidad</b></td>
    <td><b>P. Factura</b></td>
    <td><b>P. Empresa</b></td>
    <td><b>P. Traspaso</b></td>
    <td><b>P. Rebaja</b></td>
    <td><b>P. Venta</b></td>
    <td><b>Importe</b></td>
    <td><b>Quitar</b></td>
  </tr>
  <?php
  $total = 0;
  if (isset($_SESSION['listaCompraTmp'])):
    $i = 0;
    foreach (@$_SESSION['listaCompraTmp'] as $key) {
      $d = explode("||", @$key);
  ?>
      <tr>
        <td><?php echo $d[5]; ?></td>
        <td><?php echo $d[1]." / ".$d[2]." / ".$d[3]; ?></td>
        <td><?php echo $d[4]; ?></td>
        <td><?php echo $d[6]; ?></td>
        <td><?php echo $d[7]; ?></td>
        <td><?php echo $d[8]; ?></td>
        <td><?php echo $d[9]; ?></td>
        <td><?php echo $d[10]; ?></td>
        <td><?php echo $d[11]; ?></td>
        <td><?php echo $d[12]; ?></td>
        <td><?php echo $d[13]; ?></td>
        <td><?php echo $d[8]*$d[9]; ?></td>
        <td>
          <span class="btn btn-danger btn-xs" onclick="quitarProducto('<?php echo $i; ?>')">
            <span class="glyphicon glyphicon-remove"></span>
          </span>
        </td>
      </tr>
  <?php
      $total = $total + $d[8]*$d[9];
      $i++;
    }
  endif;
  ?>
  <tr>
    <td colspan="11" style="text-align: right"><b>TOTAL S/ </b></td>
    <td colspan="2"><b><?php echo $total; ?></b></td>
  </tr>
</table>
<P style="text-align: right">
   <span class="btn btn-success" onclick="compra()"> Generar Compra
      <span class="glyphicon glyphicon-usd"></span>
   </span>
   <span class="btn btn-danger" onclick="vaciarLista()"> Vaciar Lista
    <span class="glyphicon glyphicon-trash"></span>
   </span>
</P>
