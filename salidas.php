<?php include("db.php") ?>
<?php include("includes/header.php") ?>
<h1>Histórico de salidas</h1>
<div class="registros">
    <div class="formulario">
        <h3>Buscador</h3>
        <form action="salidas.php" method="POST">
            <label for="mes">Mes de ingreso</label>
            <select id="mes" name="mes">
                <option value="">Todos los meses</option>
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>

            <label for="dia">Dia de ingreso</label>
            <input type="number" id="dia" min=1 max=31 name="dia" placeholder="Todos los dias">
            <hr>
            <label for="mesOut">Mes de salida</label>
            <select id="mesOut" name="mesOut">
                <option value="">Todos los meses</option>
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>

            <label for="diaOut">Dia de salida</label>
            <input type="number" id="diaOut" min=1 max=31 name="diaOut" placeholder="Todos los dias">
            <hr>
            <label for="prov">Proveedor</label>
            <input type="text" id="prov" name="prov" placeholder="Todos los proveedores">

            <input type="submit" id="buscar" name="buscar" value="Buscar">
        </form>
    </div>
    <h2>Salidas</h2>
    <table border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Materia prima</th>
                <th>Cantidad</th>
                <th>Calidad</th>
                <th>Brix</th>
                <th>Proveedor</th>
                <th>Recibe</th>
                <th>Fecha de ingreso</th>
                <th>Fecha de salida</th>
        </thead>
        <tbody>
        <?php
                $mes ="";
                $dia ="";
                $mesOut ="";
                $diaOut ="";
                $prov="";
                if (isset($_POST['buscar'])){
                    $mes = $_POST['mes'];
                    $dia = $_POST['dia'];
                    $mesOut = $_POST['mesOut'];
                    $diaOut = $_POST['diaOut'];
                    $prov = $_POST['prov'];
                }

                if ($mes == null){
                    $mes = " ";
                }else{
                    $mes =" AND month(fecha_ingreso) = $mes";
                }
                if ($dia == null){
                    $dia = " ";
                }else{
                    $dia =" AND day(fecha_ingreso) = $dia";
                }

                if ($mesOut == null){
                    $mesOut = " ";
                }else{
                    $mesOut =" AND month(fecha_salida) = $mesOut";
                }
                if ($diaOut == null){
                    $diaOut = " ";
                }else{
                    $diaOut =" AND day(fecha_salida) = $diaOut";
                }

                if ($prov == null){
                    $prov = " ";
                }else{
                    $prov =" AND proveedores.nombre LIKE '%$prov%'";
                }
            $query ="SELECT id_salida, id_registro, materias_primas.nombre as mp, cantidad_salida, calidad, brix, proveedores.nombre as proveedor, usuarios.nombre as recibe, fecha_ingreso, fecha_salida
                    FROM salidas
                    INNER JOIN usuarios ON salidas.realizo = usuarios.id_usuario
                    INNER JOIN proveedores ON salidas.proveedor = proveedores.id_proveedor
                    INNER JOIN materias_primas ON salidas.materia_prima = materias_primas.id_mp
                    WHERE id_salida <> 0 ".$dia.$mes.$diaOut.$mesOut.$prov."
                    ORDER BY fecha_salida DESC;";
            $resultado = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($resultado)){ ?>
                <tr>
                    <td><?php echo $row['id_registro'] ?></td>
                    <td><?php echo $row['mp'] ?></td>
                    <td><?php echo $row['cantidad_salida'] ?></td>
                    <td><?php echo $row['calidad'] ?></td>
                    <td><?php echo $row['brix'] ?></td>
                    <td><?php echo $row['proveedor'] ?></td>
                    <td><?php echo $row['recibe'] ?></td>
                    <td><?php echo $row['fecha_ingreso'] ?></td>
                    <td><?php echo $row['fecha_salida'] ?></td>
                </tr>
            <?php }?>
        </tbody>
    </table>
</div>
<?php include("includes/footer.php") ?>