<?php 

require_once "../../clases/Conexion.php";
require_once "../../clases/Producto.php";

$obj= new producto();

$datos=array(
		$_POST['idProducto'],
	    $_POST['categoriaSelectU'],
	    $_POST['nombreU'],
	    $_POST['descripcionU'],
	    $_POST['cantidadU'],
	    $_POST['precioU']
			);

    echo $obj->actualizaProducto($datos);

 ?>