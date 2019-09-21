<?php
    $connection =	mysqli_connect('localhost' , 'root' ,'' ,'users');
    if(isset($_POST['submit'])) 
    {   
        $name = $_POST['firstName'];
        $last = $_POST['lastName'];
        $email = $_POST['email'];

        mysqli_query($connection, "INSERT INTO user (firstName, lastName, email) VALUES ('$name', '$last', '$email')");
        header('location: index.php');
        echo "<div>Your data vas submited</div>";
    }

?>
