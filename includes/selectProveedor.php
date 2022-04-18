<?php
    include("db.php");
    $getProveedores1 = "select * from proveedores order by id_proveedor";
    $getProveedores2 = mysqli_query($conn, $getProveedores1);
    while($row = mysqli_fetch_array($getProveedores2))
    {
        $id_proveedor = $row['id_proveedor'];
        $nombre = $row['nombre'];
        ?> 
        <option value="<?php echo $id_proveedor;?>"><?php echo $id_proveedor, ' - ', $nombre;?></option>
        <?php
    }
?>