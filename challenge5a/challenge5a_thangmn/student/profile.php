<?php
session_start();
include("../config.php");
require_once("../user.php");

$msg = "";
$id = $_SESSION["login"]["id"];
$sql = "SELECT * FROM account WHERE id = '$id'";
$result = $mysqli->query($sql);
$row = $result->fetch_array(MYSQLI_NUM);
$name = $row["3"];
$username = $row["1"];
$phone = $row["5"];
$email = $row["4"];
$avatar = $row["8"];
$username_err = $name_err = $phone_err = $email_err = "";

// click change info
if(isset($_POST["change"])){

    $filename = $_FILES["uploadFile"]["name"];
    $tempname = $_FILES["uploadFile"]["tmp_name"];
    $targetFilePath = "../uploads/".$filename;
    // $targetFilePath = $targetDir.$fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'gif', 'jpeg');

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email";
    } else{
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter phone";
    } else{
        $phone = trim($_POST["phone"]);
    }

    // check if information is in the right format
    if(!empty(trim($_POST["email"])) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_err = "*Invalid email format";
        echo "<script type='text/javascript'>alert('$email_err');</script>";
    }

    if(!empty(trim($_POST["phone"])) && !preg_match("/^[0]{1}[0-9]{9}$/", $phone)){
        $phone_err = "*Invalid phone number format";
        echo "<script type='text/javascript'>alert('$phone_err');</script>";
    }

    if (!$username_err && !$name_err && !$email_err && !$phone_err ){
        if(!empty($filename) && in_array($fileType, $allowTypes)){
            $sql = "UPDATE account SET email = '$email', phone = '$phone', avatar = '$filename' WHERE id = '$id'";
            //check file upload
            if($mysqli->query($sql) == true && move_uploaded_file($tempname, $targetFilePath)){
                $msg = "Avatar uploaded successfully!";
                echo "<script type='text/javascript'>alert('$msg');</script>";
                echo '<script language="javascript">alert("Change info successfully!"); window.location="home2.php";</script>';
            }else {
                $err = "Change info failed!";
                echo "<script type='text/javascript'>alert('$err');</script>";
            }
        }else if (!empty($filename)) {
            $err = "Only jpg, png, jpeg, gif avatar files are allowed to upload.";
            echo "<script type='text/javascript'>alert('$err');</script>";
        }else {
            $sql = "UPDATE account SET email = '$email', phone = '$phone' WHERE id = '$id'";
            if($mysqli->query($sql) == true){
                echo '<script language="javascript">alert("Change info successfully!"); window.location="home2.php";</script>';
            }else {
                $err = "Change info failed!";
                echo "<script type='text/javascript'>alert('$err');</script>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change infomation</title>

</head>
<body>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>


<nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
    <a class="navbar-brand" href="#"><?php echo "<span>"."Hi " . $_SESSION["login"]["username"] . "</span>"; ?></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb" aria-expanded="true">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navb" class="navbar-collapse collapse hide">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="home2.php">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="xemall.php">Xem user</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="profile.php">Profile</a>
            </li>
        </ul>

        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="../Logout.php"><span class="fas fa-sign-in-alt"></span> Log Out</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container" style=" padding-left: 500px">

    <form action="profile.php" method="post" enctype="multipart/form-data">
        <!-- <span class="err"> <?php echo $err; ?> </span><br><br> -->
        <div class="row" style="padding-left: 50px" >
            <?php
            $id = $_SESSION["login"]["id"];
            $sql = "SELECT * FROM account WHERE id = '$id'";
            $result = $mysqli->query($sql);
            $row = $result->fetch_array(MYSQLI_NUM);
            if($row['8'])
                echo ' <img src="../uploads/'.$row["8"].'" style="height: 64px;width: 64px;" >';
            else
                echo ' <img src="../uploads/default.jpg" > ';
            ?>
        </div>
        <label for="username">Username</label><br>
        <input type="text" class="username-readonly" name="username" value="<?php echo $username?>" disabled><br>
        <label for="name">Name</label><br>
        <input type="text" class="name-readonly" name="name" value="<?php echo $name?>" disabled><br>
        <label for="email">Email</label><br>
        <input type="text" name="email" value="<?php echo $email?>"><br>
        <label for="phone">Phone number</label><br>
        <input type="text" name="phone" value="<?php echo $phone?>"><br>
        <label for="avatar">Upload avatar</label>
        <input type="file" name="uploadFile" value="<?php echo $avatar?>"><br><br>
        <input type="submit" class="changeInfo" value="Save info" name="change">
    </form>
</div>


</body>
</html>


