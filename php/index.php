<?php
    
	session_start();

	$error = "";

	if (array_key_exists("logout",$_GET)) {
	
		unset($_SESSION);
	
		setcookie("id","",time() - 60*60);
	
		$_COOKIE['id'] = "";
	
	}elseif ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
	
		header("location:loggedin.php");
	
	}

	 if (array_key_exists("submit",$_POST)) {
		
		include('connection.php');
	


		if (!$_POST['email']) {
	
			$error .= "An Email is required<br>";
		
		}
		
		if (!$_POST['password']) {
		
			$error .= "A Password is required<br>";
		
		}
		
		if ($error != "") {
		
			$error = "<p>There were error(s) in your form: </p>".$error;
		
		}else{

			if ($_POST['signup'] == '1') {
				
			    $query = "SELECT id FROM `users` WHERE email='".mysqli_escape_string($link,$_POST['email'])."'";
				
				$res = mysqli_query($link,$query);
           
          		if (mysqli_num_rows($res)>0) {
              
               		$error = "the email is alredy exists";
        	   
        	    }else{
	     	
	           	    $query = "INSERT INTO `users`  (`email`,`password`) VALUES('".mysqli_escape_string($link,$_POST['email'])."','".mysqli_escape_string($link,$_POST['password'])."')";         
	        
	               if (!mysqli_query($link,$query)) {
	               
	                	 $error = "<p>Could not sign up - please try again leter ;)</p>";
	               
	                }else{

	                	$query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE  id = 
	                		".mysqli_insert_id($link)." LIMIT 1";

	                	mysqli_query($link,$query);
	                	
	                	$_SESSION['id'] = mysqli_insert_id($link);

	                	if ($_POST['stayLoggedIn'] == '1') {
	    				
	    					setcookie("id",mysqli_insert_id($link),time()+60*60*24*365);
	                
	                	}
			        	
			        	header("Location:loggedin.php");
	               
	                }
	            
	            }
	        
	        } else {
	        	
	        	$query = "SELECT * FROM `users` where email ='".mysqli_escape_string($link,$_POST['email'])."'";
	        	$res = mysqli_query($link,$query);
           		$row = mysqli_fetch_array($res);
           		
           		if (isset($row)) {
           		
           			 $hashedPassword = md5(md5($row['id']).$_POST['password']);

           			 if ($hashedPassword == $row['password']) {
                            
                            $_SESSION['id'] = $row['id'];
           				
           				if ($_POST['stayLoggedIn'] == '1') {
           				
           					setcookie("id",$row['id'],time() + 60*60*24*365);
           			   
           			    }

           			    header("location:loggedin.php");
           			}else{

           			$error =  "Email or Password doesn't Match";
           		}
           		}else{

           			$error =  "Email or Password doesn't Match";

           		}
           	}
      
	        } 


		}
	



?>
<?php  include('header.php')  ?>
    
 <div class="container" id="homepagec">

 	<h1>Secret Diary</h1>
 	<br>
 	<p><h5><strong>Store Your Thoughts</strong></h5></p>
 	<div id="error"><?php  if($error != ""){
 		echo '<div class="alert alert-danger" role="alert">
  '.$error.'
</div>';}
 	 ?></div>

<form method="POST" id="signupForm">

	<p>Intrested, sign Up now!!</p>
	
	<div class="form-group">
	
		<input type="email" class="form-control" name="email" placeholder="abc@gmail.com">
	
	</div>
	
	<div class="form-group">
	
		<input type="password" class="form-control" name="password" placeholder="password">
   
    </div>
	
	<div class="checkbox">
		
		<input type="checkbox"  name="stayLoggedIn" value="1">
        <label>Stay me logged In!</label>

	</div>
	<br>

	<div class="form-group">
	
		<input type="hidden" name="signup" value="1">
	
	</div>

	<div class="form-group">
	
		<input type="submit" class="btn btn-success" name="submit" value="Sign Up!">
    </div>

	<p><a class="toggleForm">Log In</a></p>


</form>

<form method="POST" id="signinForm">
	
	<p>Login With Email and Password</p>

	<div class="form-group">
	
		<input type="email" class="form-control" name="email" placeholder="abc@gmail.com">
	
	</div>
	
	<div class="form-group">
	
		<input type="password" class="form-control" name="password" placeholder="password">
   
    </div>
	
	<div class="checkbox">
		
		<input type="checkbox"  name="stayLoggedIn" value="1">
        <label>Stay me logged In!</label>

	</div>
	<br>

	<div class="form-group">
	
		<input type="hidden" name="signup" value="0">
	
	</div>

	<div class="form-group">
	
		<input type="submit" class="btn btn-success" name="submit" value="Sign In!">
    </div>
    <p><a class="toggleForm">Sign Up</a></p>

</form>
 </div>
 
<?php  include('footer.php')  ?>