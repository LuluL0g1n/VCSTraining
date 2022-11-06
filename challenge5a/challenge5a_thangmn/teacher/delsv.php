<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Home Page</title>
        <!-- CSS FOR STYLING THE PAGE -->
        <style>
            table {
                margin: 0 auto;
                font-size: large;
                border: 1px solid black;
            }

            h1 {
                text-align: center;
                color: #006600;
                font-size: xx-large;
                font-family: 'Gill Sans', 'Gill Sans MT',
                ' Calibri', 'Trebuchet MS', 'sans-serif';
            }

            td {
                background-color: #E4F5D4;
                border: 1px solid black;
            }

            th,
            td {
                font-weight: bold;
                border: 1px solid black;
                padding: 10px;
                text-align: center;
            }

            td {
                font-weight: lighter;
            }
        </style>
        <?php
        include "../config.php";
        session_start();

        if(!isset($_SESSION["login"])) {
            header("location:Login.php");
        }

        // Username is root
        $user = 'root';
        $password = '';
        $database = 'challenge5a_thangmn';
        $servername='localhost';
        $mysqli = new mysqli($servername, $user,
            $password, $database);

        // Checking for connections
        if ($mysqli->connect_error) {
            die('Connect Error (' .
                $mysqli->connect_errno . ') '.
                $mysqli->connect_error);
        }
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $sql = "DELETE FROM account WHERE username = '$username'";
            $result = $mysqli->query($sql);
            $message = "Delete successfully";
            echo "<script>
            alert('$message');
            window.location.href='home.php';
            </script>";
        }




        ?>
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
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="sv.php">Xem sv</a>
                </li>
            </ul>

            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../Logout.php"><span class="fas fa-sign-in-alt"></span> Log Out</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="login-form " style="width:auto">
        <form action="" method="post">
    <div class="container">
        <div class="row" style="padding-left: 15px">
            <p>Nhập username muốn xóa:</p>

        </div>
        <div class="form-group "style="width:auto;width: 30%;">
            <input type="username" class="form-control" placeholder="Username" required="required" name="username">
        </div>

            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Xóa</button>

        </div>
    </div>
        </form>
    </div>



    </body>

    </html>
<?php
