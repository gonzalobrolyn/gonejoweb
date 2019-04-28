
<?php require_once "dependencias.php" ?>

<!DOCTYPE html>
<html>
<head>
  <title>Gonejo Web</title>
  <link rel="icon" type="image/png" href="../imagenes/mifavicon.png" />

</head>
<body>

  <!-- Begin Navbar -->
  <nav class="navbar navbar-fixed-top navbar-inverse" data-spy="affix" id="barra-nav" role="navigation">
    <div class="container-fluid">

      <div class="nav navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">MENU</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <a class="navbar-brand" href="inicio.php">
          <span class="btn btn-primary btn-lg">
            <span class="glyphicon glyphicon-fire" style="color: #22d0ff"></span> GonejoWeb</span>
        </a>
      </div>

      <div id="main-nav" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-left">
          <li><a href="adelanto.php">
            <span class="glyphicon glyphicon-piggy-bank"></span> Adelanto</a>
          </li>
          <li><a href="inicio.php">
            <span class="glyphicon glyphicon-shopping-cart"></span> Venta</a>
          </li>
          <li><a href="servicio.php">
            <span class="glyphicon glyphicon-hdd"></span> Servicio</a>
          </li>
          <li><a href="diario.php">
             <span class="glyphicon glyphicon-list-alt"></span> Diario</a>
          </li>
          <?php if ($_SESSION['usuarioCargo']=="Empresa" || $_SESSION['usuarioCargo']=="Administrador"): ?>
             <li><a href="compra.php">
               <span class="glyphicon glyphicon-credit-card"></span> Compras</a>
            </li>
          <!--<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-credit-card"></span> Compras y mas <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="deposito.php">Depositar y Comprar</a></li>
              <li><a href="compra.php">Compra en Efectivo</a></li>
              <li><a href="#">Compra por Pagar</a></li>
              <li><a href="#">Venta por Cobrar</a></li>
              <li><a href="#">Pagos Diversos</a></li>
            </ul>
         </li>-->
          <?php endif; ?>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <?php if ($_SESSION['usuarioCargo']=="Empresa" || $_SESSION['usuarioCargo']=="Administrador"): ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-tasks"></span> Reportes <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="movimientos.php">Movimientos</a></li>
              <li><a href="inventario.php">Inventario</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-edit"></span> Base de Datos<span class="caret"></span></a>
            <ul class="dropdown-menu">
               <li><a href="familia.php">Productos</a></li>
               <li><a href="marca.php">Marcas</a></li>
               <li><a href="usuario.php">Usuarios</a></li>
               <?php if ($_SESSION['usuarioCargo']=="Empresa"): ?>
               <li><a href="caja.php">Cajas</a></li>
               <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>
          <?php if ($_SESSION['usuarioNombre']=="gonzalobrolyn"): ?>
            <li><a href="../cu/index.php">Codigos</a></li>
          <?php endif; ?>
          <li>
            <a href="#">
              <span class="glyphicon glyphicon-user"></span>
              <?php echo $_SESSION['usuarioNombre']; ?></a>
          </li>
          <li>
            <a style="color: red" href="../procesos/salir.php">
              <span class="glyphicon glyphicon-off"></span> Cerrar Sesión</a>
          </li>
        </ul>

      </div>
    </div>
  </nav>

</body>
</html>
