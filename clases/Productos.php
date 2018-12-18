
<?php
  require_once "Gonexion.php";

  class productos{

    public function guardaProducto($datos){
      $c = new conectar();
      $conexion = $c->conexion();

      $sqlFamilia = "SELECT grupo_familia
                       from grupo
                      where grupo_id = '$datos[1]'";
      $queryFam = mysqli_query($conexion, $sqlFamilia);
      $resultFam = mysqli_fetch_row($queryFam)[0];

      $sqlCodigo = "SELECT *
                      from producto as pro
                inner join grupo as gru
                        on pro.producto_grupo = gru.grupo_id
                inner join familia as fam
                        on gru.grupo_familia = fam.familia_id
                     where fam.familia_id = '$resultFam'";
      $queryCodigo = mysqli_query($conexion, $sqlCodigo);
      $countCodigo = mysqli_num_rows($queryCodigo);

      if ($countCodigo > 0) {
         $codigo = $resultFam * 1000 + $countCodigo + 1;
      } else {
         $codigo = $resultFam * 1000 + 1;
      }

      $fecha = date('Y-m-d H:i:s');

      $sqlPersona = "SELECT usuario_persona
                       from usuario
                      where usuario_id = '$datos[6]'";
      $consulta = mysqli_query($conexion, $sqlPersona);
      $resultadoPersona = mysqli_fetch_row($consulta)[0];

      $sql = "INSERT into producto (
                          producto_codigo,
                          producto_imagen,
                          producto_grupo,
                          producto_marca,
                          producto_modelo,
                          producto_descripcion,
                          producto_detalle,
                          producto_fecha,
                          producto_persona)
                  values ('$codigo',
                          '$datos[0]',
                          '$datos[1]',
                          '$datos[2]',
                          '$datos[3]',
                          '$datos[4]',
                          '$datos[5]',
                          '$fecha',
                          '$resultadoPersona')";
      return mysqli_query($conexion, $sql);
    }

    public function traeDatosProducto($idProducto){
      $c = new conectar();
      $conexion = $c->conexion();

      $sql = "SELECT ima.imagen_ruta,
                     fam.familia_nombre,
                     gru.grupo_nombre,
                     mar.marca_nombre,
                     pro.producto_descripcion,
                     pro.producto_detalle
                from producto as pro
          inner join imagen as ima
                  on pro.producto_imagen = ima.imagen_id
          inner join grupo as gru
                  on pro.producto_grupo = gru.grupo_id
          inner join familia as fam
                  on gru.grupo_familia = fam.familia_id
          inner join marca as mar
                  on pro.producto_marca = mar.marca_id
               where pro.producto_id = '$idProducto'";
      $result = mysqli_query($conexion, $sql);
      $ver = mysqli_fetch_row($result);
      $d = explode('/', $ver[0]);
      $img = $d[1].'/'.$d[2].'/'.$d[3];
      $data = array(
        'ruta' => $img,
        'familia' => $ver[1],
        'grupo' => $ver[2],
        'marca' => $ver[3],
        'descripcion' => $ver[4],
        'detalle' => $ver[5]);
      return $data;
    }

    public function traeDatosProducto2($idProducto){
      $c = new conectar();
      $conexion = $c->conexion();

      $sql = "SELECT img.imagen_ruta,
							gru.grupo_nombre,
							mar.marca_nombre,
							pro.producto_detalle,
							alm.almacen_cantidad,
							alm.almacen_precio
					 from almacen as alm
			 inner join producto as pro
						on alm.almacen_producto = pro.producto_id
			 inner join imagen as img
				  	 	on pro.producto_imagen = img.imagen_id
			 inner join grupo as gru
						on pro.producto_grupo = gru.grupo_id
			 inner join marca as mar
						on pro.producto_marca = mar.marca_id
					where alm.almacen_id = $idProducto";
      $result = mysqli_query($conexion, $sql);
      $ver = mysqli_fetch_row($result);
      $d = explode('/', $ver[0]);
      $img = $d[1].'/'.$d[2].'/'.$d[3];
      $precio = round($ver[5]*1.1,2);
      $data = array(
        'ruta' => $img,
        'grupo' => $ver[1],
        'marca' => $ver[2],
        'detalle' => $ver[3],
        'cantidad' => $ver[4],
        'precio' => $precio);
      return $data;
    }
  }
?>
