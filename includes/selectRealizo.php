<?php
    include("db.php");
    $getUsuarios1 = "select * from usuarios order by id_usuario";
    $getUsuarios2 = mysqli_query($conn, $getUsuarios1);
    while($row = mysqli_fetch_array($getUsuarios2))
    {
        $id_usuario = $row['id_usuario'];
        $nombre = $row['nombre'];
        ?> 
        <option value="<?php echo $id_usuario;?>"><?php echo $id_usuario, ' - ', $nombre;?></option>
        <?php
    }
?>