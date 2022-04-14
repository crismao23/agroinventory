<?php include("db.php") ?>

<?php include("includes/header.php") ?>
<h1>Agroinventory</h1>
<div class="formulario">
    <form action="save_register.php" method="POST">
        <label for="materia_prima">Materia prima</label>
        <select id="materia_prima" name="materia_prima">
            <option value="1">Platano Harton</option>
            <option value="2">Platano Comino</option>
            <option value="3">Platano FHIA21</option>
        </select>

        <label for="cantidad">Cantidad</label>
        <input type="number" id="cantidad" name="cantidad" placeholder="Cantidad en kilogramos">
        <br>

        <label for="calidad">Calidad</label>
        <select id="calidad" name="calidad">
            <option value="1">1-Calidad primera - Extra</option>
            <option value="2">2-Segunda</option>
            <option value="3">3-Muestra</option>
        </select>

        <label for="brix">Brix</label>
        <input type="number" id="brix" name="brix" placeholder="brix">
        <br>

        <label for="proveedor">Proveedor</label>
        <select name="proveedor" id="proveedor">
        <?php
            include("db.php");
            $getProveedores1 = "select * from proveedores order by id_proveedor";
            $getProveedores2 = mysqli_query($conn, $getProveedores1);
            while($row = mysqli_fetch_array($getProveedores2))
            {
                $id_proveedor = $row['id_proveedor'];
                $nombre = $row['nombre'];
                ?> 
                <option value="<?php echo $id_proveedor;?>"><?php echo $nombre;?></option>
                <?php
            }
        ?>
        <!--<input type="number" id="proveedor" name="proveedor" placeholder="proveedor">-->
        </select>

        <input type="submit" name="save_register" value="Agregar">
    </form>
</div>
<div class="registros">

</div>
<?php include("includes/footer.php") ?>