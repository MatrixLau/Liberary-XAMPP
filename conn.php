<?php
    $conn = mysqli_connect("localhost:3316","root","0113","liberary");        //值依次为mySQL服务器地址、账号名、密码、数据库名
    if(!$conn){
        echo "连接失败：".mysqli_connect_error();
        exit();
    }
    //设置设置编码
    mysqli_set_charset($conn,"UFT8");                    
    mysqli_query($conn,"SET NAMES utf8");
?>