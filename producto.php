<?php 
  require_once "./clases/Gonexion.php";
      $c = new conectar();
      $conexion = $c->conexion();

      $idProAlm = $_GET['idProducto'];

      $sql = "SELECT img.imagen_ruta,
                     gru.grupo_nombre,
                     mar.marca_nombre,
                     pro.producto_modelo,
                     pro.producto_descripcion,
                     pro.producto_detalle,
                     alm.almacen_cantidad,
                     alm.almacen_precioempresa,
                     alm.almacen_preciotraspaso,
                     alm.almacen_preciocantidad,
                     alm.almacen_preciorebaja,
                     alm.almacen_precioventa,
                     alm.almacen_producto
                from almacen as alm
          inner join producto as pro
                  on alm.almacen_producto = pro.producto_id
          inner join imagen as img
                  on pro.producto_imagen = img.imagen_id
          inner join grupo as gru
                  on pro.producto_grupo = gru.grupo_id
          inner join marca as mar
                  on pro.producto_marca = mar.marca_id
               where alm.almacen_id = '$idProAlm'";
      $consulta = mysqli_query($conexion, $sql);
      $ver = mysqli_fetch_row($consulta);

      $sqlEsp = "SELECT especifi_id,
                        especifi_nombre,
                        especifi_detalle
                   from especifi
                  where especifi_producto = '$ver[12]'";
      $consultaEsp = mysqli_query($conexion, $sqlEsp);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NextGo</title>
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
        <img class="header__img" src="./assets/logo-nextgo.png" alt="Logo">
      </a>
    </div>
    <div class="header__list">
      <ul>
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Clientes</a></li>
        <li><a href="#">Trabaja con Nosotros</a></li>
        <li><a href="#">Libro de Reclamaciones</a></li>
        <li><a href="#">Modalidades de Pago</a></li>
        <li><a href="#">Politicas de Garantia</a></li>
        <li><a href="#">Quienes Somos</a></li>
      </ul>
    </div>
    <div class="header__social">
      <ul>
        <li><a href="#"><img src="./assets/icon-whatsapp-b.png" alt="whatsapp-icon"></a></li>
        <li><a href="#"><img src="./assets/icon-facebook-b.png" alt="facebook-icon"></a></li>
        <li><a href="#"><img src="./assets/icon-instagram-b.png" alt="instagram-icon"></a></li>
        <li><a href="#"><img src="./assets/icon-twitter-b.png" alt="twitter-icon"></a></li>
        <li><a href="#"><img src="./assets/icon-youtube-b.png" alt="youtube-icon"></a></li>
        <li><a href="#"><img src="./assets/icon-entrega-b.png" alt="entrega-icon"></a></li>
        <li><a href="#" data-toggle="modal" data-target="#modalIngreso"><img src="./assets/icon-user-b.png" alt="user-icon"></a></li>
      </ul>
    </div>
    <div class="header__menu">
      <ul>
        <li><a href="#">PRODUCTOS</a></li>
        <li><a href="#">MARCAS</a></li>
        <li><a href="#">OFERTAS</a></li>
        <li><a href="#">NOVEDADES</a></li>
        <li><a href="#">PROMOCIONES</a></li>
        <li><a href="#">EXCLUSIVOS</a></li>
        <li><a href="#">CATALOGOS</a></li>
        <li><a href="#">NOTICIAS</a></li>
        <li><a href="#">CONTACTENOS</a></li>
        <li><a href="#">CARRITO</a></li>
        <li><a href="#">SUCURSALES</a></li>
      </ul>
    </div> 
  </header>

  <section class="main" style="background: white">
    <div class="row" style="text-align: center">
      <div class="col-sm-12">
        <h4><?php echo $ver[1]." - ".$ver[2]." ".$ver[3]; ?></h4>
        <p><?php echo $ver[4]; ?></p>
      </div>
    </div>
    <div class="row" style="text-align: center">
      <div class="col-sm-4">
        <p>DESCRIPCION GENERAL:</p>
        <p><?php echo $ver[5]; ?></p>
      </div>
      <div class="col-sm-4">
        <?php
          $img = explode("/",$ver[0]);
          $ruta = "./".$img[2]."/".$img[3];
        ?>
        <img src="<?php echo $ruta; ?>" class="img-responsive" />
      </div>
      <div class="col-sm-4">
        <P>ESPECIFICACIONES TECNICAS:</P>
        <ul>
        <?php 
          while ($verEsp = mysqli_fetch_row($consultaEsp)):
        ?>
          <li style="list-style: none"><?php echo $verEsp[1].": ".$verEsp[2] ?></li>
        <?php 
          endwhile;
        ?>
        </ul>
      </div>
    </div>
    <div class="row" style="text-align: center">
      <div class="col-md-12">
        <p><?php echo "Disponible: ".$ver[6]; ?></p>
        <p><?php echo "Precio: S/ ".ceil($ver[11]).".00"; ?></p>
      </div>
    </div>
    
  </section>

  <section class="contact">
    <div class="contact__item">
      <div class="contact__item--logo">
        <img src="./assets/icon-whatsapp.png" alt="WhatsApp">
      </div>
      <div class="contact__item--dato">
        <p>WhatsApp</p>
        <p>998808010</p>
      </div>
    </div>
    <div class="contact__item">
      <div class="contact__item--logo">
        <img src="./assets/icon-telefono.png" alt="Celular">
      </div>
      <div class="contact__item--dato">
        <p>FonoCompras</p>
        <p>998808010</p>
      </div>
    </div>
    <div class="contact__item">
      <div class="contact__item--logo">
        <img src="./assets/icon-auricular.png" alt="Soporte">
      </div>
      <div class="contact__item--dato">
        <p>Soporte Tecnico</p>
        <p>051-350505</p>
      </div>
    </div>
    <!-- <div class="contact__item">
      <div class="contact__item--logo">
        <img src="./assets/icon-mensaje.png" alt="Correo">
      </div>
      <div class="contact__item--dato">
        <p>Ventas Online</p>
        <p>nextgo-ventas@gmail.com</p>
      </div>
    </div> -->
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
            <input type="text" class="form-control input-sm" name="usuario" id="usuario" title="Usuario" placeholder="Usuario"><p></p>
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
      <a href="#">Centro de atención: Jr. Moquegua # 169 - Ciudad de Puno </a>
      <a href="#">Horario de atención: Lunes a Sábado de 9:00 a.m. a 9:00 p.m.</a>
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