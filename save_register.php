<?php
    include("db.php");
    if (isset($_POST['save_register'])){
        $materia_prima = $_POST['materia_prima'];
        $calidad = $_POST['calidad'];
        $cantidad = $_POST['cantidad'];
        $proveedor = $_POST['proveedor'];
        $brix = $_POST['brix'];
        $realizo = $_POST['realizo'];
        $query = "INSERT INTO registros(realizo, materia_prima, cantidad, calidad, brix, proveedor) 
                                VALUES ( '$realizo','$materia_prima', '$cantidad', '$calidad', '$brix', '$proveedor')";

        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("query fail");
        }
        header("Location: index.php");
    }
?>