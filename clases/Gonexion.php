
<?php
	class conectar{
		private $servidor="localhost";
		private $usuario="super";
		private $password="ozLEwN3idTbAg9Zr";
		private $bd="gunidad";

		public function conexion(){
			$conexion = mysqli_connect($this->servidor,
									         $this->usuario,
									         $this->password,
									         $this->bd);
			return $conexion;
		}
	}
?>
