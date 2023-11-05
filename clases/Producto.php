

<?php 
	
	class producto
	{
		public function agregaImagen($datos)
		{
			$c = new conectar();
			$conexion = $c->conexion();
	
			$fecha = date('Y-m-d');
	
			$sql = "INSERT into imagenes (id_categoria,
											nombre,
											ruta,
											fechaSubida)
								values ('$datos[0]',
										'$datos[1]',
										'$datos[2]',
										'$fecha')";
			$result = mysqli_query($conexion, $sql);
	
			return mysqli_insert_id($conexion);
		}
	
		public function insertaProducto($datos)
		{
			$c = new conectar();
			$conexion = $c->conexion();
	
			$fecha = date('Y-m-d');
	
			$sql = "INSERT into producto (id_categoria,
											id_imagen,
											id_usuario,
											nombre,
											descripcion,
											cantidad,
											precio,
											fechaCaptura)
								values ('$datos[0]',
										'$datos[1]',
										'$datos[2]',
										'$datos[3]',
										'$datos[4]',
										'$datos[5]',
										'$datos[6]',
										'$fecha')";
			return mysqli_query($conexion, $sql);
		}
	
		public function obtenDatosProducto($idproducto)
		{
			$c = new conectar();
			$conexion = $c->conexion();
	
			$sql = "SELECT id_producto, 
							id_categoria, 
							nombre,
							descripcion,
							cantidad,
							precio 
				from producto 
				where id_producto='$idproducto'";
			$result = mysqli_query($conexion, $sql);
	
			if ($result && mysqli_num_rows($result) > 0) {
				$ver = mysqli_fetch_row($result);
	
				$datos = array(
					"id_producto" => $ver[0],
					"id_categoria" => $ver[1],
					"nombre" => $ver[2],
					"descripcion" => $ver[3],
					"cantidad" => $ver[4],
					"precio" => $ver[5]
				);
	
				return $datos;
			} else {
				return null; // Manejar el caso en el que no se encontraron datos
			}
		}
	
		public function actualizaProducto($datos)
		{
			$c = new conectar();
			$conexion = $c->conexion();
	
			$sql = "UPDATE producto set id_categoria='$datos[1]', 
										nombre='$datos[2]',
										descripcion='$datos[3]',
										cantidad='$datos[4]',
										precio='$datos[5]'
						where id_producto='$datos[0]'";
	
			return mysqli_query($conexion, $sql);
		}
	
		public function eliminaProducto($idproducto)
		{
			$c = new conectar();
			$conexion = $c->conexion();
	
			$idimagen = self::obtenIdImg($idproducto);
	
			$sql = "DELETE from producto 
					where id_producto='$idproducto'";
			$result = mysqli_query($conexion, $sql);
	
			if ($result) {
				$ruta = self::obtenRutaImagen($idimagen);
	
				if (file_exists($ruta)) {
					if (unlink($ruta)) {
						// Archivo eliminado con éxito
						$sql = "DELETE from imagenes 
								where id_imagen='$idimagen'";
						$result = mysqli_query($conexion, $sql);
						if ($result) {
							return 1;
						} else {
							// Manejar el error al eliminar de la tabla de imágenes
						}
					} else {
						// Manejar el error al eliminar el archivo
					}
				} else {
					// Manejar el caso en el que el archivo no existe
				}
			} else {
				// Manejar el error al eliminar de la tabla de productos
			}
		}
	
		public function obtenIdImg($idProducto)
		{
			$c = new conectar();
			$conexion = $c->conexion();
	
			$sql = "SELECT id_imagen 
					from producto 
					where id_producto='$idProducto'";
			$result = mysqli_query($conexion, $sql);
	
			if ($result) {
				$row = mysqli_fetch_row($result);
				if ($row) {
					return $row[0];
				}
			}
			return null; // Manejar el caso en el que no se encontró la imagen
		}
	
		public function obtenRutaImagen($idImg)
		{
			$c = new conectar();
			$conexion = $c->conexion();
	
			$sql = "SELECT ruta 
					from imagenes 
					where id_imagen='$idImg'";
			$result = mysqli_query($conexion, $sql);
	
			if ($result) {
				$row = mysqli_fetch_row($result);
				if ($row) {
					return $row[0];
				}
			}
			return null; // Manejar el caso en el que no se encontró la ruta de la imagen
		}
	}
	?>
	