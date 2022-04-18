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
        <select name="calidad" id="calidad">
            <?php include("includes/selectCalidad.php") ?>
        </select>


        <label for="brix">Brix</label>
        <input type="number" id="brix" name="brix" placeholder="brix">
        <br>

        <label for="proveedor">Proveedor</label>
        <select name="proveedor" id="proveedor">
            <?php include("includes/selectProveedor.php") ?>
        </select>

        <input type="submit" name="save_register" value="Agregar">
    </form>
</div>

<div class="registros">
    <table border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Materia prima</th>
                <th>Cantidad</th>
                <th>Calidad</th>
                <th>Brix</th>
                <th>Proveedor</th>
        </thead>
    </table>
</div>
<?php include("includes/footer.php") ?>