<?php
    $conn = mysqli_connect("localhost:3316","root","0113","liberary");
    if(!$conn){
        echo "连接失败：".mysqli_connect_error();
        exit();
    }
    mysqli_set_charset($conn,"UFT8");
    mysqli_query($conn,"SET NAMES utf8");
?>