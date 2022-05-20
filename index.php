<?php include("db.php") ?>

<?php include("includes/header.php") ?>
<h1>Sistema de inventario</h1>
<div class="formulario">
    <h2>Registro de entradas</h2>
    <form action="save_register.php" method="POST">
        <label for="materia_prima">Materia prima</label>
        <select id="materia_prima" name="materia_prima">
            <option value="1">Platano Harton</option>
            <option value="2">Platano Comino</option>
            <option value="3">Platano FHIA21</option>
        </select>

        <label for="cantidad">Cantidad</label>
        <input type="number" id="cantidad" min=0 name="cantidad" placeholder="Cantidad en kilogramos">
        
        <br>

        <label for="calidad">Calidad</label>
        <select name="calidad" id="calidad">
            <?php include("includes/selectCalidad.php") ?>
        </select>

        <label for="brix">Brix</label>
        <input type="number" id="brix" min=0 max=40 step="0.1" name="brix" placeholder="brix">
        <br>

        <label for="proveedor">Proveedor</label>
        <select name="proveedor" id="proveedor">
            <?php include("includes/selectProveedor.php") ?>
        </select>

        <label for="realizo">Realizo</label>
        <select name="realizo" id="realizo">
            <?php include("includes/selectRealizo.php") ?>
        </select>

        <input type="submit" id="agregar" name="save_register" value="Agregar">
    </form>
</div>

<div class="formulario">
    <h2>Resumen</h2>
    <?php
        $query ="SELECT sum(cantidad) as tot
            FROM registros
            WHERE registro_activo = 1 AND stock = 1;";
        $resultado = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($resultado);
    ?>
    <h4>Total en bodega</h4>
    <div class="formulario">
        <div>Total: <b><?php echo $row['tot'] ?> kg</b></div>
    </div>
    <h4>Total en bodega filtrado por: Materia prima</h4>
    <table border="1">
        <thead>
            <tr>
                <th>Materia prima</th>
                <th>Cantidad Total (kg)</th>
                <th>°Brix Promedio</th>
        </thead>
        <tbody>
        <?php
            $query ="SELECT materias_primas.nombre as materia_prima, sum(cantidad) as cant, round(avg(brix),1) as brix_prom
                    FROM registros
                    INNER JOIN usuarios ON registros.realizo = usuarios.id_usuario
                    INNER JOIN proveedores ON registros.proveedor = proveedores.id_proveedor
                    INNER JOIN materias_primas ON registros.materia_prima = materias_primas.id_mp
                    WHERE registro_activo = 1 AND stock = 1
                    GROUP BY materia_prima
                    ORDER BY materia_prima ASC;";
            $resultado = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($resultado)){ ?>
                <tr>
                    <td><?php echo $row['materia_prima'] ?></td>
                    <td><?php echo $row['cant'] ?></td>
                    <td><?php echo $row['brix_prom'] ?></td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    <br>
    <h4>Total en bodega filtrado por: Materia prima - Calidad</h4>
    <table border="1">
        <thead>
            <tr>
                <th>Materia prima</th>
                <th>Cantidad Total (kg)</th>
                <th>Calidad</th>
                <th>°Brix Promedio</th>
        </thead>
        <tbody>
        <?php
            $query ="SELECT materias_primas.nombre as materia_prima, sum(cantidad) as cant, calidad.descripcion as calidad, round(avg(brix),1) as brix_prom
                    FROM registros
                    INNER JOIN usuarios ON registros.realizo = usuarios.id_usuario
                    INNER JOIN proveedores ON registros.proveedor = proveedores.id_proveedor
                    INNER JOIN materias_primas ON registros.materia_prima = materias_primas.id_mp
                    INNER JOIN calidad ON id_calidad = registros.calidad
                    WHERE registro_activo = 1 AND stock = 1
                    GROUP BY materia_prima, calidad
                    ORDER BY materia_prima, calidad ASC;";
            $resultado = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($resultado)){ ?>
                <tr>
                    <td><?php echo $row['materia_prima'] ?></td>
                    <td><?php echo $row['cant'] ?></td>
                    <td><?php echo $row['calidad'] ?></td>
                    <td><?php echo $row['brix_prom'] ?></td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    
</div>

<div class="registros">
    <h2>En stock</h2>
    <div class="formulario">
        <h3>Buscador</h3>
        <form action="index.php" method="POST">
            <label for="mes">Mes</label>
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
            <label for="dia">Dia</label>
            <input type="number" id="dia" min=1 max=31 name="dia" placeholder="Todos los dias">
            
            <label for="prov">Proveedor</label>
            <input type="text" id="prov" name="prov" placeholder="Todos los proveedores">

            <input type="submit" id="buscar" name="buscar" value="Buscar">
        </form>
    </div>
    <hr>
    <table border="1">
        <thead>
            <tr>
            <h3>Resultados Stock</h3>
                <th>No.</th>
                <th>Materia prima</th>
                <th>Cantidad (kg)</th>
                <th>Calidad</th>
                <th>°Brix</th>
                <th>Proveedor</th>
                <th>Recibe</th>
                <th>Fecha de ingreso</th>
                <th>Acciones</th>
        </thead>
        <tbody>
        <?php
            $mes ="";
            $dia ="";
            $prov="";
            if (isset($_POST['buscar'])){
                $mes = $_POST['mes'];
                $dia = $_POST['dia'];
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
            if ($prov == null){
                $prov = " ";
            }else{
                $prov =" AND proveedores.nombre LIKE '%$prov%'";
            }

            $query ="SELECT id_registro, materias_primas.nombre as mp, cantidad, calidad, brix, proveedores.nombre as proveedor, usuarios.nombre as recibe, fecha_ingreso
                    FROM registros
                    INNER JOIN usuarios ON registros.realizo = usuarios.id_usuario
                    INNER JOIN proveedores ON registros.proveedor = proveedores.id_proveedor
                    INNER JOIN materias_primas ON registros.materia_prima = materias_primas.id_mp
                    WHERE registro_activo = 1 AND stock = 1 ".$dia.$mes.$prov."
                    ORDER BY id_registro DESC;";
            $resultado = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($resultado)){ ?>
                <tr>
                    <td><?php echo $row['id_registro'] ?></td>
                    <td><?php echo $row['mp'] ?></td>
                    <td><?php echo $row['cantidad'] ?></td>
                    <td><?php echo $row['calidad'] ?></td>
                    <td><?php echo $row['brix'] ?></td>
                    <td><?php echo $row['proveedor'] ?></td>
                    <td><?php echo $row['recibe'] ?></td>
                    <td><?php echo $row['fecha_ingreso'] ?></td>
                    <td>
                        <a href="edit.php?id_registro=<?php echo $row['id_registro']?>">
                            <i class="fa fa-sign-out"></i>
                        </a>
                        <a href="delete.php?id_registro=<?php echo $row['id_registro']?>">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
</div>
<script src="./js/in.js"></script>
<?php include("includes/footer.php") ?>