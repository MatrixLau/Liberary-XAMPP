<?php
    header("Content-Type:text/html;charset=utf-8");       //设置编码
    require_once"conn.php";
    $query = "select * from user where status=1";       //user为库中管理员的表 status是登陆状态
    mysqli_query($conn,$query);
    $result = mysqli_query($conn,$query);
    if($result->num_rows <= 0){                //result->num_rows要是>0就是有结果 就等于已经有管理登录了就不用重新登录 否则要登陆
        ?>
        <script>
            alert("请登录！");
            window.location.href="menu.php";
            </script>
        <?php
    }
?>