<?php
	
	session_start();

	if (array_key_exists("id",$_COOKIE)) {

		$_SESSION['id'] = $_COOKIE['id'];

	}

	if (array_key_exists("id",$_SESSION)) {

      	include('connection.php');
        
	}else{

		header("location:index.php");

	}

	include("header.php");

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top ">
  <a class="navbar-brand" href="#">Secret Diary</a>
 
  <div class="pull-xs-right">
     <a href='index.php?logout=1'> <button class="btn btn-outline-success" type="submit">LogOut</button></a>
  </div>

</nav>


	<div class="container-fluid" id="fluid">
		
		<textarea id="diary" rows="24" class="form-control"></textarea>

	</div>

<?php

	include("footer.php");

?>