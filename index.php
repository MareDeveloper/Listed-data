<?php
  include('edit.php');
  include('delete.php');
  include('insert_data.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Web Application</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
 
</head>
<body>
  
  <!-- show and hide table -->
    <div class="text-show">
      <p>Show all users</p>
    </div>
<div class="form-container">
  <div>
    <h3>Welcome, please add your data to the form.</h3>
  </div>
<form action="insert_data.php" method="post" id="form">
  <input type="hidden" name="id" value="">
  <label for="">First Name</label>
  <input type="text" name="firstName" palaceholder="First Name">
  <label for="">Last Name</label>
  <input type="text" name="lastName" palaceholder="Last Name">
  <label for="">Email</label>
  <input type="email" name="email" palaceholder="Email"><br>
  <input type="submit" name="submit" value="Add data">
</form>
</div>
<!-- Main container start -->
<div class="container">

<!-- Button for removing all users from the table -->
  <div id="table-container">
    <div align="right">
          <button type="button" name="del_btn" id="del_btn" class="btn">Delete</button>
    </div>


      <!-- Table data -->
    <table class="table">
      <thead>
        <tr>
          <th>Firstname</th>
          <th>Lastname</th>
          <th>Email</th>
          <th>Action</th>
          <th>Remove</th>
        </tr>
      </thead>


      <tbody>
        <?php
        // List of all users in the table
            $table  = mysqli_query($connection ,'SELECT * FROM user');
            
            while($row  = mysqli_fetch_array($table))
            { ?>
            
              <tr id="<?php echo $row['id'];?>">
                    <td data-target="firstName"><?php echo $row['firstName']; ?></td>

                    <td data-target="lastName"><?php echo $row['lastName']; ?></td>
                    
                    <td data-target="email"><?php echo $row['email']; ?></td>
                    
                    <td><a href="#" data-role="update" data-id="<?php echo $row['id'];?>">Update</a></td>
                    
                    <td><input type="checkbox" user_id[] class="delete_user" value="<?php echo $row['id']; ?>"></td>
              </tr>
                
    <?php } ?>
      </tbody>

    </table>

  
    </div>

   <!-- Bootstrap Modal -->
      <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edit data</h4>
                  </div>
                  <div class="modal-body">
                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" id="firstName" class="form-control">
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" id="lastName" class="form-control">
                      </div>

                      <div class="form-group">
                          <label>Email</label>
                          <input type="text" id="email" class="form-control">
                      </div>
                      <input type="hidden" id="userId" class="form-control">
                  </div>
                  <div class="modal-footer">
                      <a href="" id="save" class="btn btn-primary pull-right">Update</a>
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                  </div>
            </div>
        </div>
  </div> 
</div>

    <script>
    $(document).ready(function(){

        //  append values in input fields in modal
        $(document).on('click','a[data-role=update]',function(){
                var id  = $(this).data('id');
                var firstName  = $('#'+id).children('td[data-target=firstName]').text();
                var lastName  = $('#'+id).children('td[data-target=lastName]').text();
                var email  = $('#'+id).children('td[data-target=email]').text();

                $('#firstName').val(firstName);
                $('#lastName').val(lastName);
                $('#email').val(email);
                $('#userId').val(id);
                $('#myModal').modal('toggle');
        });

        // create event to get data from fields and update in database 

        $('#save').click(function(){
                var id  = $('#userId').val(); 
                var firstName =  $('#firstName').val();
                var lastName =  $('#lastName').val();
                var email =   $('#email').val();

            $.ajax({
                url      : 'edit.php',
                method   : 'post', 
                data     : {firstName : firstName , lastName: lastName , email : email , id: id},
                success  : function(response){
                        // update user record in table 
                        $('#'+id).children('td[data-target=firstName]').text(firstName);
                        $('#'+id).children('td[data-target=lastName]').text(lastName);
                        $('#'+id).children('td[data-target=email]').text(email);
                        $('#myModal').modal('toggle'); 
                        }
            });
        });
       
        // Delete user from table
        $('#del_btn').click(function(){
              if(confirm("Are you sure about this?")) 
              {
                  var id = [];

                  $(':checkbox:checked').each(function(i){
                    id[i] = $(this).val();
                  }); 
                  if(id.length === 0) 
                  {
                    alert("You must select last one checkbox");
                  }
                  else 
                  {
                      $.ajax({
                          url     :   'delete.php',
                          method  :   'post',
                          data    :   {id:id},
                          success :   function()
                          {
                            for(let i = 0; i<id.length; i++) 
                            {
                              $('tr#'+id[i]+'').css('background-color', 'red');
                              $('tr#'+id[i]+'').hide('slow');
                            }
                          }
                      });
                  }
              }
              else 
              {
                return false;
              }
          });
          // Show or hide table 
          $('.text-show').click(function(){
              $('#table-container').toggle();          
          });
    });
</script>
</body>
</html>
