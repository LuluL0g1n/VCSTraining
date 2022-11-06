<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap Simple Login Form</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

<style>
	.login-form {
		width: 340px;
    	margin: 50px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
</style>
</head>

<?php
include "config.php";
session_start();


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username =  $_POST['username'];
    $password = $_POST['password'];
    $ok = true;

    /*if(!filter_var($username,FILTER_VALIDATE_USERNAME)) {
        $ok = false;
        $err = "Username or Password is invalid";
    }*/

    if($ok) {

        #$password = md5($password);
        $query = "SELECT * FROM account WHERE username = '$username' and password = '$password'";

        $result = mysqli_query($mysqli,$query);

        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        $count = mysqli_num_rows($result);

        $query2 = "SELECT * FROM account WHERE username = '$username' and type = 'student'";
        $result2 = mysqli_query($mysqli,$query2);
        $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
        $count2 = mysqli_num_rows($result2);
        if($count == 1) {

            $_SESSION['login'] = $row;
            $message = "Login successfully";
            echo "<script>
            alert('$message');
            if($count2 == 1){
            window.location.href='student/home2.php';}
            else{
                window.location.href='teacher/home.php';
            }
            </script>";
        }
        else {
            $err = "Email or Password is invalid";
        }
    }

    


}

?>

<body>
<div class="login-form">
    <form action="" method="post">
        <h2 class="text-center">Log in</h2>       
        <div class="form-group">
            <input type="username" class="form-control" placeholder="Username" required="required" name="username">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" required="required" name="password">
            <span class="text-danger"><?php if (isset($err)) echo $err; ?></span>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </div>
        <div class="clearfix">
            <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
            <a href="#" class="pull-right">Forgot Password?</a>
        </div>        
    </form>

</div>
</body>
</html>                                		