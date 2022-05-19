<?php
    include("db.php");

    if(isset($_GET['id_registro'])){
        $id_registro=$_GET['id_registro'];
        $query = "SELECT id_registro, materias_primas.nombre as mp, cantidad, calidad, brix, proveedores.nombre as proveedor, usuarios.nombre as recibe, fecha_ingreso
        FROM registros
        INNER JOIN usuarios ON registros.realizo = usuarios.id_usuario
        INNER JOIN proveedores ON registros.proveedor = proveedores.id_proveedor
        INNER JOIN materias_primas ON registros.materia_prima = materias_primas.id_mp
        WHERE registro_activo = 1 AND stock = 1 AND id_registro = '$id_registro'";

        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $id_registro = $row['id_registro'];
            $mp = $row['mp'];
            $cantidad = $row['cantidad'];
            $calidad = $row['calidad'];
            $brixOut = $row['brix'];
            $proveedor = $row['proveedor'];
            $recibe = $row['recibe'];
            $fecha_ingreso = $row['fecha_ingreso'];
        }
        $cantidadAntes=$cantidad;
    }
    if (isset($_POST['update'])){
        $id_registro =$_GET['id_registro'];
        $cantidad =$_POST['cantidadOut'];
        $query = "UPDATE registros 
                SET cantidad = $cantidadAntes-$cantidad
                WHERE id_registro = $id_registro";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("query fail");
        }
        header("Location: index.php");
    }
?>
<?php include("includes/header.php") ?>
<div class="formulario">
    <form action="edit.php?id_registro=<?php echo $_GET['id_registro'];?>" method="POST">
        <label for="id_registro">ID</label>
        <input type="number" id="id_registro" min=0 name="id_registro" value="<?php echo $id_registro;?>" disabled>
        <br>
        <label for="mp">Materia prima</label>
        <input type="text" id="mp" name="mp" value="<?php echo $mp;?>" disabled>
        <br>
        <label for="brixOut">Brix</label>
        <input type="number" id="brixOut" step="0.1" name="brixOut" placeholder="brixOut" value="<?php echo $brixOut;?>" disabled>
        <br>
        <label for="proveedor">Proveedor</label>
        <input type="text" id="proveedor" name="proveedor" placeholder="proveedor" value="<?php echo $proveedor;?>" disabled>
        <br>
        <label for="recibe">Recibio</label>
        <input type="text" id="recibe" name="recibe" placeholder="recibe" value="<?php echo $recibe;?>" disabled>
        <br>
        <label for="fecha_ingreso">Fecha ingreso</label>
        <input type="text" id="fecha_ingreso" name="fecha_ingreso" placeholder="fecha_ingreso" value="<?php echo $fecha_ingreso;?>" disabled>
        <br>
        <label for="cantidad">Cantidad</label>
        <input type="number" id="cantidadOut" min=0 max="<?php echo $cantidad;?>" name="cantidadOut" placeholder="Cantidad en kilogramos" value="<?php echo $cantidad;?>">
        <br>
        <input type="submit" name="update" id="update" value="Retirar">
        <input type="button" name="cancel" id="cancel" value="Cancelar" onclick="location.href='http://localhost/agroinventory/index.php';">
        <a href=""></a>
    </form>
</div>
<script src="./js/out.js"></script>
<?php include("includes/footer.php") ?>