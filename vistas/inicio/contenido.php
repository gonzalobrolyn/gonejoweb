
<?php
require_once "../clases/Gonexion.php";

	function contenido(){
		$c = new conectar();
		$conexion = $c->conexion();
		$idGrupo = $_GET['grupo'];
		$idCaja = $_SESSION['cajaID'];
		$sql = "SELECT img.imagen_ruta,
							gru.grupo_nombre,
							mar.marca_nombre,
							pro.producto_modelo,
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
					where alm.almacen_caja = '$idCaja'
					  and gru.grupo_id = '$idGrupo'";
		$result = mysqli_query($conexion, $sql);
		$datos=array();
		$i=0;
		while($ver=mysqli_fetch_row($result)):
			$img = explode("/",$ver[0]);
			$ruta = $img[1]."/".$img[2]."/".$img[3];
			$datos[$i] = $ruta."||".
					  		 $ver[1]."||".
							 $ver[2]."||".
							 $ver[3]."||".
					  		 $ver[4]."||".
							 $ver[5]."||".
					  		 $ver[6];
			$i++;
		endwhile;
		return $datos;
	}
?>
