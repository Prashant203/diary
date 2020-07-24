
<?php

if (array_key_exists('email',$_POST)) {
    $user= 'root';
    $pass = '';
    $db = 'phpsql';

    $conn = mysqli_connect("localhost",$user,$pass,$db) or die('unable to connect');

    if ($_POST['email'] == '') {
        echo "Email is required"; 
     }
    elseif($_POST['pass'] == '') {
        echo "Password is required"; 
     }
    else{

        $query = "SELECT * FROM `user` WHERE email='".mysqli_escape_string($conn,$_POST['email'])."'";

        $res = mysqli_query($conn,$query);
        if (mysqli_num_rows($res)>0) {
            echo "the email has already taken";
        }
        else{
                $query = "INSERT INTO `user`  (`email`,`pass`) VALUES('".mysqli_escape_string($conn,$_POST['email'])."','".mysqli_escape_string($conn,$_POST['pass'])."')";         
                mysqli_query($conn,$query);
                 echo "the email has WILL BE taken";
        }

     }
}



?>
<!DOCTYPE html>
<html>
<body>
	<form method="POST">
        <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" name="email" placeholder="name@example.com">
        </div>
        <div class="form-group">
        <label for="pass">Password</label>
        <input type="pass" class="form-control" name="pass">
        </div>
        <div class="col-sm-10">
          <button type="submit" class="btn btn-primary">Sign in</button>
        </div>
  
  
  
  
</form>
</body>
</html>

