<?php
    include("db.php");
    if (isset($_POST['save_register'])){
        $materia_prima = $_POST['materia_prima'];
        $calidad = $_POST['calidad'];
        $proveedor = $_POST['proveedor'];
        $cantidad = $_POST['cantidad'];
        $brix = $_POST['brix'];
        $query = "INSERT INTO registros(materia_prima, cantidad, calidad, brix, proveedor) 
                                VALUES ('$materia_prima', '$cantidad', '$calidad', '$brix', '$proveedor')";

        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("query fail");
        }
        echo 'guardado';
    }
?>