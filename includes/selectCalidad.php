<?php
    include("db.php");
    $getcalidad1 = "select * from calidad order by id_calidad";
    $getcalidad2 = mysqli_query($conn, $getcalidad1);
    while($row = mysqli_fetch_array($getcalidad2))
    {
        $id_calidad = $row['id_calidad'];
        $descripcion = $row['descripcion'];
        ?> 
        <option value="<?php echo $id_calidad;?>"><?php echo $id_calidad, ' - ', $descripcion;?></option>
        <?php
    }
?>