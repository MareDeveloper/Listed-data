<?php 
    // Query for deleting data from mysql table.
    $connection =	mysqli_connect('localhost' , 'root' ,'' ,'users');

    if($connection->connect_error) 
    {
        die("Error: " . $connection->connect_error);
    }
    if(isset($_POST['id']))
    {
        foreach($_POST['id'] as $id) 
        {
            $sql = "DELETE FROM user WHERE id = $id";
            mysqli_query($connection,$sql);
        }
    }
?>