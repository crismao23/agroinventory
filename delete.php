<?php
    include("db.php");
    if(isset($_GET['id_registro'])){
        $id=$_GET['id_registro'];
        $query = "UPDATE registros
                SET registro_activo = 0
                WHERE id_registro = $id
        ";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("query fail");
        }
        header("Location: index.php");
    }
?>