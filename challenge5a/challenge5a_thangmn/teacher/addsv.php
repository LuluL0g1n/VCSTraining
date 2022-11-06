<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>addsv</title>
</head>

<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['name'];
    $username = $_POST['username'];
    $email =  $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $type = 'student';
    $password_confirm = $_POST['password_confirm'];
    $ok = true;

    if (!preg_match("/^[a-zA-Z0-9]+$/",$fullname)) {
        $name_error = "Name must contain only alphabets,numbers and space";
        $ok = false;
    }

    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please Enter Valid Email ID";
        $ok = false;
    }

    if(strlen($password) < 6) {
        $password_error = "Password must be minimum of 6 characters";
        $ok = false;
    }

    if($password != $password_confirm) {
        $password_confirm_error = "Password and Confirm Password doesn't match";
        $ok = false;
    }

    if($ok){
        $select = mysqli_query($mysqli, "SELECT `username` FROM `account` WHERE `username` = '".$_POST['username']."'");
        if(mysqli_num_rows($select)) {
            $username_error = "This username is already being used";
            $ok = false;
        }
    }

    if($ok) {
        #$password = md5($password);
        $query = "INSERT INTO account (fullname,username, email,phone, password,type) VALUES ('$fullname','$username','$email','$phone', '$password','$type')";
        mysqli_query($mysqli,$query);
        $message = "Add successfully";
        echo "<script>
        alert('$message');
        window.location.href='sv.php';
        </script>";
    }
}

?>


<body>
<form action="" method="post">
    <section class="vh-100 bg-image" style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Create an account</h2>

                                <form>

                                    <div class="form-outline mb-4">
                                        <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="name"/>
                                        <label class="form-label" for="form3Example1cg">Your Name</label>
                                        <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="username"/>
                                        <label class="form-label" for="form3Example1cg">Your Userame</label>
                                        <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="email" id="form3Example3cg" class="form-control form-control-lg" name="email"/>
                                        <label class="form-label" for="form3Example3cg">Your Email</label>
                                        <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="phone"/>
                                        <label class="form-label" for="form3Example1cg">Your Phone</label>

                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="form3Example4cg" class="form-control form-control-lg" name="password"/>
                                        <label class="form-label" for="form3Example4cg">Password</label>
                                        <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="form3Example4cdg" class="form-control form-control-lg" name="password_confirm"/>
                                        <label class="form-label" for="form3Example4cdg">Repeat your password</label>
                                        <span class="text-danger"><?php if (isset($password_confirm_error)) echo $password_confirm_error; ?></span>
                                    </div>

                                    <div class="form-check d-flex justify-content-center mb-5">
                                        <input
                                            class="form-check-input me-2"
                                            type="checkbox"
                                            value=""
                                            id="form2Example3cg"
                                        />
                                        <label class="form-check-label" for="form2Example3g">
                                            I agree all statements in <a href="#!" class="text-body"><u>Terms of service</u></a>
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Add</button>
                                    </div>


                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</html><?php
