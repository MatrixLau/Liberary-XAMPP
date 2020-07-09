<?php
    header("Content-Type:text/html;charset=utf-8");
    require_once"conn.php";
    $query = "select * from user where status=1";
    mysqli_query($conn,$query);
    $result = mysqli_query($conn,$query);
    if($result->num_rows <= 0){
        ?>
        <script>
            alert("请登录！");
            window.location.href="menu.php";
            </script>
        <?php
    }
?>