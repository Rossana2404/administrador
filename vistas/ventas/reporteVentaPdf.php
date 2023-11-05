<?php 
require_once "../../clases/Conexion.php";
require_once "../../clases/Ventas.php";

$objv = new ventas();

$c = new conectar();
$conexion = $c->conexion();
$idventa = $_GET['id'];

$sql = "SELECT ve.id_venta,
        ve.fechaCompra,
        ve.id_cliente,
        prod.nombre,
        prod.precio,
        prod.descripcion
        FROM ventas as ve 
        INNER JOIN producto as prod
        ON ve.id_producto = prod.id_producto
        WHERE ve.id_venta = '$idventa'";

$result = mysqli_query($conexion, $sql);

$fecha = ""; // Inicializamos la variable $fecha
$folio = ""; // Inicializamos la variable $folio
$idcliente = ""; // Inicializamos la variable $idcliente

if ($result && mysqli_num_rows($result) > 0) {
    $ver = mysqli_fetch_row($result);
    $folio = $ver[0];
    $fecha = $ver[1];
    $idcliente = $ver[2];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Reporte de venta</title>
    <link rel="stylesheet" type="text/css" href="../../librerias/bootstrap/css/bootstrap.css">
</head>
<body>
        <img src="../../assents/img/logo.jpg" width="200" height="200">
        <br>
        <table class="table">
            <tr>
                <td>Fecha: <?php echo $fecha; ?></td>
            </tr>
            <tr>
                <td>Folio: <?php echo $folio; ?></td>
            </tr>
            <tr>
                <td>Cliente: <?php echo $objv->nombreCliente($idcliente); ?></td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <td>Nombre producto</td>
                <td>Precio</td>
                <td>Cantidad</td>
                <td>Descripción</td>
            </tr>

            <?php 
            $sql = "SELECT ve.id_venta,
                    ve.fechaCompra,
                    ve.id_cliente,
                    prod.nombre,
                    prod.precio,
                    prod.descripcion
                    FROM ventas as ve 
                    INNER JOIN producto as prod
                    ON ve.id_producto = prod.id_producto
                    WHERE ve.id_venta = '$idventa'";

            $result = mysqli_query($conexion, $sql);
            $total = 0;

            while ($mostrar = mysqli_fetch_row($result)) {
             ?>

            <tr>
                <td><?php echo $mostrar[3]; ?></td>
                <td><?php echo $mostrar[4]; ?></td>
                <td>1</td>
                <td><?php echo $mostrar[5]; ?></td>
            </tr>

            <?php 
                $total = $total + $mostrar[4];
            }

            if (mysqli_num_rows($result) > 0) {
                ?>

            <tr>
                <td>Total = <?php echo "$" . $total; ?></td>
            </tr>

            <?php } ?>
        </table>
</body>
</html>
