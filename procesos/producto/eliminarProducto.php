<?php 


require_once "../../clases/Conexion.php";
require_once "../../clases/Producto.php";
$idprod=$_POST['idproducto'];

	$obj=new producto();

	echo $obj->eliminaProducto($idprod);
	


 ?> 

 

 
	