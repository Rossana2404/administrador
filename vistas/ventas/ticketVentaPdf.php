<?php
require_once "../../clases/Conexion.php";
require_once "../../clases/Ventas.php";

$objv = new ventas();
$c = new conectar();
$conexion = $c->conexion();

$idventa = isset($_GET['idventa']) ? $_GET['idventa'] : null;

if ($idventa) {
    $sql = "SELECT ve.id_venta,
                    ve.fechaCompra,
                    ve.id_cliente,
                    prod.nombre,
                    prod.precio,
                    prod.descripcion
            FROM ventas as ve
            INNER JOIN producto AS prod ON ve.id_producto = prod.id_producto
            AND ve.id_venta = '$idventa'";

    $result = mysqli_query($conexion, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $ver = mysqli_fetch_row($result);

        $folio = $ver[0];
        $fecha = $ver[1];
        $idcliente = $ver[2];
    } else {
        echo "No se encontraron resultados en la consulta.";
    }
} else {
    echo "Falta el parámetro 'idventa' en la URL.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reporte de venta</title>
    <style type="text/css">
        @page {
            margin-top: 0.3em;
            margin-left: 0.6em;
        }

        body {
            font-size: xx-small;
        }
    </style>
</head>
<body>
    <p>Haru Store</p>
    <?php if (isset($fecha)) : ?>
        <p>Fecha: <?php echo $fecha; ?></p>
    <?php endif; ?>
    <?php if (isset($folio)) : ?>
        <p>Folio: <?php echo $folio; ?></p>
    <?php endif; ?>
    <?php if (isset($idcliente)) : ?>
        <p>Cliente: <?php echo $objv->nombreCliente($idcliente); ?></p>
    <?php else : ?>
        <p>Cliente Desconocido</p>
    <?php endif; ?>

    <table style="border-collapse: collapse;" border="1">
        <tr>
            <td>Nombre</td>
            <td>Precio</td>
        </tr>
        <?php
        $sql = "SELECT ve.id_venta,
                    ve.fechaCompra,
                    ve.id_cliente,
                    prod.nombre,
                    prod.precio,
                    prod.descripcion
            FROM ventas as ve
            INNER JOIN producto AS prod ON ve.id_producto = prod.id_producto
            AND ve.id_venta = '$idventa'";

        $result = mysqli_query($conexion, $sql);
        $total = 0;
        if ($result && mysqli_num_rows($result) > 0) {
            while ($mostrar = mysqli_fetch_row($result)) {
                ?>
                <tr>
                    <td><?php echo $mostrar[3]; ?></td>
                    <td><?php echo $mostrar[4] ?></td>
                </tr>
                <?php
                $total = $total + $mostrar[4];
            }
            ?>
            <tr>
                <td>Total: <?php echo "$" . $total ?></td>
            </tr>
        <?php } else {
            echo "No se encontraron resultados en la consulta.";
        }
        ?>
    </table>
</body>
</html>
