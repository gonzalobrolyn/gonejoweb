<?php
  require_once "./clases/Gonexion.php";
  $c = new conectar();
  $conexion = $c->conexion();
 
  $sqlLaptop = "SELECT alm.almacen_cantidad,
                       alm.almacen_precioventa,
                       mar.marca_nombre,
                       pro.producto_modelo,
                       pro.producto_descripcion,
                       img.imagen_ruta,
                       alm.almacen_id
                  from almacen as alm
            inner join producto as pro
                    on alm.almacen_producto = pro.producto_id
            inner join imagen as img
                    on pro.producto_imagen = img.imagen_id
            inner join grupo as gru
                    on pro.producto_grupo = gru.grupo_id
            inner join marca as mar
                    on pro.producto_marca = mar.marca_id
                    where gru.grupo_familia = '1'
                --  where gru.grupo_familia = '29'
                ";
  $queryLaptop = mysqli_query($conexion, $sqlLaptop);

  $sqlImpresora = "SELECT alm.almacen_cantidad,
                          alm.almacen_precioventa,
                          mar.marca_nombre,
                          pro.producto_modelo,
                          pro.producto_descripcion,
                          img.imagen_ruta,
                          alm.almacen_id
                     from almacen as alm
               inner join producto as pro
                       on alm.almacen_producto = pro.producto_id
               inner join imagen as img
                       on pro.producto_imagen = img.imagen_id
               inner join grupo as gru
                       on pro.producto_grupo = gru.grupo_id
               inner join marca as mar
                       on pro.producto_marca = mar.marca_id
                    where gru.grupo_familia = '2'
                    -- where gru.grupo_familia = '18'
                    ";
  $queryImpresora = mysqli_query($conexion, $sqlImpresora);

  $sqlCamara = "SELECT alm.almacen_cantidad,
                       alm.almacen_precioventa,
                       mar.marca_nombre,
                       pro.producto_modelo,
                       pro.producto_descripcion,
                       img.imagen_ruta,
                       alm.almacen_id
                  from almacen as alm
            inner join producto as pro
                    on alm.almacen_producto = pro.producto_id
            inner join imagen as img
                    on pro.producto_imagen = img.imagen_id
            inner join grupo as gru
                    on pro.producto_grupo = gru.grupo_id
            inner join marca as mar
                    on pro.producto_marca = mar.marca_id
                 where gru.grupo_familia = '8'
                --  where gru.grupo_familia = '14'
                 ";
  $queryCamara = mysqli_query($conexion, $sqlCamara);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SpaceTec</title>
  <link rel="icon" type="image/png" href="imagenes/mifavicon.png" />
  <link href="https://fonts.googleapis.com/css2?family=Muli:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
  <script src="librerias/jquery-3.2.1.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.js"></script>
  <script src="js/funciones.js"></script>
  <link rel="stylesheet" href="./css/general.css">
  <link rel="stylesheet" href="./css/principal.css">
</head>

<body>
  <header class="header">
    
    <div class="header__logo">
      <a href="./">
        <img class="header__img" src="./imagenes/monitor.png" alt="Logo">
      </a>
    </div>
    <div class="header__social">
      <span>Horario de atención: Lunes a Sábado de 9:00 a.m. a 8:00 p.m.</span>
      <ul>
        <!-- <li><a href="#"><img src="./assets/icon-facebook-b.png" alt="facebook-icon"></a></li> -->
        <!-- <li><a href="#"><img src="./assets/icon-instagram-b.png" alt="instagram-icon"></a></li> -->
        <!-- <li><a href="#"><img src="./assets/icon-youtube-b.png" alt="youtube-icon"></a></li> -->
        <!-- <li><a href="#"><img src="./assets/icon-entrega-b.png" alt="entrega-icon"></a></li> -->
        <li><a href="#" data-toggle="modal" data-target="#modalIngreso"><img src="./assets/icon-user-b.png" alt="user-icon"></a></li>
      </ul>
    </div>
  </header>

  <section class="main">
    <div id="slider" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#slider" data-slide-to="0" class="active"></li>
        <li data-target="#slider" data-slide-to="1"></li>
        <li data-target="#slider" data-slide-to="2"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="imagenes/fondo1.png" alt="fondo1">
          <div class="carousel-caption">
            <h3></h3>
          </div>
        </div>
        <div class="item">
          <img src="imagenes/fondo2.png" alt="fondo2">
          <div class="carousel-caption">
            <h3></h3>
          </div>
        </div>
        <div class="item">
          <img src="imagenes/fondo3.png" alt="fondo3">
          <div class="carousel-caption">
            <h3></h3>
          </div>
        </div>
      </div>

      <!-- Controles -->
      <a class="left carousel-control" href="#slider" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
      </a>
      <a class="right carousel-control" href="#slider" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Siguiente</span>
      </a>
    </div>
  </section>

  <section class="contact">
    <div class="contact__item">
      <div class="contact__item--logo">
        <img src="./assets/icon-whatsapp.png" alt="WhatsApp">
      </div>
      <div class="contact__item--dato">
        <p>WhatsApp</p>
        <p>923 903 399</p>
      </div>
    </div>
    <div class="contact__item">
      <div class="contact__item--logo">
        <img src="./assets/icon-whatsapp.png" alt="WhatsApp">
      </div>
      <div class="contact__item--dato">
        <p>WhatsApp</p>
        <p>948 904 886</p>
      </div>
    </div>
    <div class="contact__item">
      <div class="contact__item--logo">
        <img src="./assets/icon-whatsapp.png" alt="WhatsApp">
      </div>
      <div class="contact__item--dato">
        <p>WhatsApp</p>
        <p>959 792 871</p>
      </div>
    </div>
  </section>
    
  <h2 class="section-title">Oferta de Laptops</h2>

  <section class="section">

    <?php
      while($verLaptop = mysqli_fetch_row($queryLaptop)):
        $imagenLaptop = explode("/", $verLaptop[5]);
    ?>
    
    <div class="section-item">
      <a href="./producto.php?idProducto=<?php echo $verLaptop[6]?>">
        <img class="section-item__img" src="<?php echo "./".$imagenLaptop[2]."/".$imagenLaptop[3]?>" alt="">
        <div class="section-item__details">
          <p class="section-item__details--title">
          <?php 
            echo $verLaptop[2]." ".$verLaptop[3]." ".$verLaptop[4];
          ?>
          </p>
          <p class="section-item__details--subtitle">
          <?php 
            echo "Cantidad: ".$verLaptop[0];
          ?>
          </p>
          <p class="section-item__details--subtitle">
          <?php 
            echo "Precio: S/ ".$verLaptop[1];
          ?>
          </p>
        </div>
      </a>
    </div>
    <?php
      endwhile
    ?>
  </section>

  <h2 class="section-title">Oferta de Impresoras</h2>

  <section class="section">

    <?php
      while($verImpresora = mysqli_fetch_row($queryImpresora)):
        $imagenImpresora = explode("/", $verImpresora[5]);
    ?>
    
    <div class="section-item">
      <a href="./producto.php?idProducto=<?php echo $verImpresora[6]?>">
        <img class="section-item__img" src="<?php echo "./".$imagenImpresora[2]."/".$imagenImpresora[3]?>" alt="">
        <div class="section-item__details">
          <p class="section-item__details--title">
          <?php 
            echo $verImpresora[2]." ".$verImpresora[3]." ".$verImpresora[4];
          ?>
          </p>
          <p class="section-item__details--subtitle">
          <?php 
            echo "Cantidad: ".$verImpresora[0];
          ?>
          </p>
          <p class="section-item__details--subtitle">
          <?php 
            echo "Precio: S/ ".$verImpresora[1];
          ?>
          </p>
        </div>
      </a>
    </div>
    <?php
      endwhile
    ?>
  </section>

  <h2 class="section-title">Oferta de Camaras Web</h2>

  <section class="section">

    <?php
      while($verCamara = mysqli_fetch_row($queryCamara)):
        $imagenCamara = explode("/", $verCamara[5]);
    ?>
    
    <div class="section-item">
      <a href="./producto.php?idProducto=<?php echo $verCamara[6]?>">
        <img class="section-item__img" src="<?php echo "./".$imagenCamara[2]."/".$imagenCamara[3]?>" alt="">
        <div class="section-item__details">
          <p class="section-item__details--title">
          <?php 
            echo $verCamara[2]." ".$verCamara[3]." ".$verCamara[4];
          ?>
          </p>
          <p class="section-item__details--subtitle">
          <?php 
            echo "Cantidad: ".$verCamara[0];
          ?>
          </p>
          <p class="section-item__details--subtitle">
          <?php 
            echo "Precio: S/ ".$verCamara[1];
          ?>
          </p>
        </div>
      </a>
    </div>
    <?php
      endwhile
    ?>
  </section>

  <div class="modal fade" id="modalIngreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="panel panel-primary">
        <div class="panel panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <b>Bienvenido</b>
        </div>
        <div class="panel panel-body" style="text-align: center">
          <p><img src="imagenes/monitor.png" height="222"></p>
          <form id="frmEntrar">
            <input type="text" class="form-control input-sm" name="usuario" id="usuario" title="Usuario" placeholder="Usuario" autofocus><p></p>
            <input type="password" class="form-control input-sm" name="clave" id="clave" title="Contraseña" placeholder="Contraseña"><p></p>
            <input type="password" class="form-control input-sm" name="llave" id="llave" title="Llave" placeholder="Llave"><p></p>
            <input type="reset" class="btn btn-default" name="limpiar" value="Limpiar" >
            <a href="registro.php">
              <span class="btn btn-info">
                 Registro
             </span>
           </a>
            <span class="btn btn-primary" id="entrarSoftware">Entrar</span>
          </form>
        </div>
      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="footer__utility">
      <a href="#">Modalidades de Pago</a>
      <a href="#">Politicas de Garantia</a>
      <a href="#">Quienes Somos</a>
    </div>
    <div class="footer__copyright">
      <a href="#">Todos los derechos reservados <span class="glyphicon glyphicon-copyright-mark"></span> Bermejo Devs.</a> 
    </div>
  </footer>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#entrarSoftware').click(function(){

  		vacios=validarFrmVacio('frmEntrar');
  			if(vacios > 0){
  				alert("Debes llenar todos los datos.");
  				return false;
  			}

  		datos=$('#frmEntrar').serialize();
  		$.ajax({
  			type:"POST",
  			data:datos,
  			url:"procesos/entrar.php",
  			success:function(r){
  				if(r==1){
            $('#frmEntrar')[0].reset();
            window.location="vistas/inicio.php";
  				}else{
  					alert("Acceso denegado.");
  				}
  			}
  		});
	  });
	});
</script>