<?php

 
    $user= 'root';
    $pass = '';
    $db = 'phpsql';

    $conn = mysqli_connect("localhost",$user,$pass,$db) or die('unable to connect');
 
 $query = "INSERT INTO `user`  (`email`,`pass`) VALUES('123@gmail.com','1223')";         
    mysqli_query($conn,$query);

?>
