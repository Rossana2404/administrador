<?php 
session_start();
if(isset($_SESSION['usuario'])){
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Producto</title>
    <?php require_once "menu.php"; ?>
    <?php require_once "../clases/Conexion.php"; 
    $c = new conectar();
    $conexion = $c->conexion();
    $sql = "SELECT id_categoria, nombre_categoria from categorias";
    $result = mysqli_query($conexion, $sql);
    ?>
</head>
<body style="margin-top: 200px;">
    <div class="container">
        <h1>Productos</h1>
        <div class="row">
            <div class="col-sm-4">
                <form id="frmProducto" enctype="multipart/form-data">
                    <label>Categoría</label>
                    <select class="form-control input-sm" id="categoriaSelect" name="categoriaSelect">
                        <option value="A">Selecciona Categoría</option>
                        <?php while($ver = mysqli_fetch_row($result)): ?>
                            <option value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <label>Nombre</label>
                    <input type="text" class="form-control input-sm" id="nombre" name="nombre">
                    <label>Descripción</label>
                    <input type="text" class="form-control input-sm" id="descripcion" name="descripcion">
                    <label>Cantidad</label>
                    <input type="text" class="form-control input-sm" id="cantidad" name="cantidad">
                    <label>Precio</label>
                    <input type="text" class="form-control input-sm" id="precio" name="precio">
                    <label>Imagen</label>
                    <input type="file" id="imagen" name="imagen">
                    <p></p>
                    <span id="btnAgregaProducto" class="btn btn-primary">Agregar</span>
                </form>
            </div>
            <div class="col-sm-8">
                <div id="tablaProductoLoad"></div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="abremodalUpdateProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Actualizar Producto</h4>
                </div>
                <div class="modal-body">
                    <form id="frmProductoU" enctype="multipart/form-data">
                        <input type="text" id="idProducto" hidden="" name="idProducto">
                        <label>Categoría</label>
                        <select class="form-control input-sm" id="categoriaSelectU" name="categoriaSelectU">
                            <option value="A">Selecciona Categoría</option>
                            <?php 
                            $sql = "SELECT id_categoria, nombre_categoria from categorias";
                            $result = mysqli_query($conexion, $sql);
                            ?>
                            <?php while($ver = mysqli_fetch_row($result)): ?>
                                <option value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label>Nombre</label>
                        <input type="text" class="form-control input-sm" id="nombreU" name="nombreU">
                        <label>Descripción</label>
                        <input type="text" class="form-control input-sm" id="descripcionU" name="descripcionU">
                        <label>Cantidad</label>
                        <input type="text" class="form-control input-sm" id="cantidadU" name="cantidadU">
                        <label>Precio</label>
                        <input type="text" class="form-control input-sm" id="precioU" name="precioU">
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnActualizaproducto" type="button" class="btn btn-warning" data-dismiss="modal">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<script type="text/javascript">
    function agregaDatosProducto(idproducto){
        $.ajax({
            type: "POST",
            data: "idprod=" + idproducto,
            url: "../procesos/producto/obtenDatosProducto.php",
            success: function(r){
                dato = jQuery.parseJSON(r);
                $('#idProducto').val(dato['id_producto']);
                $('#categoriaSelectU').val(dato['id_categoria']);
                $('#nombreU').val(dato['nombre']);
                $('#descripcionU').val(dato['descripcion']);
                $('#cantidadU').val(dato['cantidad']);
                $('#precioU').val(dato['precio']);
            }
        });
    }

    function eliminaProducto(idproducto){
        alertify.confirm('¿Desea eliminar este producto?', function(){ 
            $.ajax({
                type: "POST",
                data: "idproducto=" + idproducto,
                url: "../procesos/productos/eliminarProducto.php",
                success: function(r){
                    if(r == 1){
                        $('#tablaProductoLoad').load("productos/tablaProducto.php");
                        alertify.success("Eliminado con éxito!!");
                    } else {
                        alertify.error("No se pudo eliminar :(");
                    }
                }
            });
        }, function(){ 
            alertify.error('Cancelado')
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#btnActualizaproducto').click(function(){
            datos = $('#frmProductoU').serialize();
            $.ajax({
                type: "POST",
                data: datos,
                url: "../procesos/productos/actualizaProducto.php",
                success: function(r){
                    if(r == 1){
                        $('#tablaProductoLoad').load("productos/tablaProducto.php");
                        alertify.success("Actualizado con éxito :D");
                    } else {
                        alertify.error("Error al actualizar :(");
                    }
                }
            });
        });
    });
</script>

<script type="text/javascript">
$(document).ready(function () {
    $('#tablaProductoLoad').load("producto/tablaProducto.php");

    $('#btnAgregaProducto').click(function () {
        var vacios = validarFormVacio('frmProducto');

        if (vacios > 0) {
            alertify.alert("Debes llenar todos los campos!!");
            return false;
        }

        var formData = new FormData(document.getElementById("frmProducto"));

        $.ajax({
            url: "../procesos/producto/insertaProducto.php",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            success: function (r) {
                if (r == 1) {
                    $('#frmProducto')[0].reset();
                    $('#tablaProductoLoad').load("producto/tablaProducto.php");
                    alertify.success("Agregado con éxito :D");
                } else {
                    alertify.error("Fallo al subir el archivo :(");
                }
            }
        });
    });
});
</script>
