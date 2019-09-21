<?php 
  $connection =	mysqli_connect('localhost' , 'root' ,'' ,'users');

    if(isset($_POST['email'])){
        $id = $_POST['id'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
    
      //  query to update data 
       
      $result  = mysqli_query($connection , "UPDATE user SET firstName='$firstName' , lastName='$lastName' , email = '$email' WHERE id='$id'");
      if($result){
          echo 'data updated';
      }

  }
?> 
