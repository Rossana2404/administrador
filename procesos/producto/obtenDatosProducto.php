<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Producto.php";

	$obj= new producto();


	$idprod=$_POST['idprod'];

	echo json_encode($obj->obtenDatosProducto($idprod));

 ?>