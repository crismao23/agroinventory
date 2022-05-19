<?php include("db.php") ?>
<?php include("includes/header.php") ?>
<h1>Proveedores</h1>
<div class="formulario">
    <h2>Crear nuevo proveedor</h2>
    <form action="proveedores.php" method="POST">

        <label for="nombre">Nombre del proveedor</label>
        <input type="text" id="nombre" name="nombre" placeholder="nombre">
        <br>
        <label for="nit">NIT</label>
        <input type="number" min=0 id="nit" name="nit" placeholder="nit">
        <br>
        <label for="telefonos">Telefonos</label>
        <input type="text" min=0 id="telefonos" name="telefonos" placeholder="telefonos separados por guion">
        <br>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="email">
        <br>

        <input type="submit" id="agregar" name="proveedores" value="Agregar">
    </form>
</div>
<?php
    include("db.php");
    if (isset($_POST['proveedores'])){
        $nombre = $_POST['nombre'];
        $nomMay= strtoupper($nombre);
        $nit = $_POST['nit'];
        $telefonos = $_POST['telefonos'];
        $email = $_POST['email'];
        $query = "INSERT INTO proveedores(nombre, nit, telefonos, email)
                                VALUES ('$nomMay', '$nit', '$telefonos', '$email')";

        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("query fail");
        }
        header("Location: proveedores.php");
    }
?>
<div class="registros">
    <h2>Listado</h2>
    <table border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nombre</th>
                <th>Nit</th>
                <th>Telefonos</th>
                <th>Email</th>
        </thead>
        <tbody>
        <?php
            $query ="SELECT *
                    FROM proveedores;";

            $resultado = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($resultado)){ ?>
                <tr>
                    <td><?php echo $row['id_proveedor'] ?></td>
                    <td><?php echo $row['nombre'] ?></td>
                    <td><?php echo $row['nit'] ?></td>
                    <td><?php echo $row['telefonos'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                </tr>
            <?php }?>
        </tbody>
    </table>
</div>
<?php include("includes/footer.php") ?>