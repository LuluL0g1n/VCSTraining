<?php
    $mysqli = mysqli_connect('localhost','root','','challenge5a_thangmn');
	mysqli_set_charset($mysqli,"utf8");
if ($mysqli->connect_error) {
    die('Connect Error (' .
        $mysqli->connect_errno . ') '.
        $mysqli->connect_error);
}
?>