<?php require_once"checklogin.php" ?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>图书管理系统 - 管理员密码修改</b></big></font></h2></div>
        <div align="center">
            <form name="changepwd" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <script>
                    function chg(){
                        if(document.getElementById("oldpwd").type!="password"){
                            document.getElementById("oldpwd").type="password";
                            document.getElementById("newpwd").type="password";
                        }else{
                            document.getElementById("oldpwd").type="text";
                            document.getElementById("newpwd").type="text";
                        }
                    }
                </script>
                <div class="input-group"><div class="input-group-addon">账号</div>
                <input type="text" id="username" name="username" value="" class="form-control" style="width:130px;height:30px;font-size:13px;" placeholder="请输入账号"/>
                <div class="input-group"><div class="input-group-addon">当前密码</div>
                <input type="password" id="oldpwd" name="oldpwd" value="" class="form-control" style="width:130px;height:30px;font-size:13px;" placeholder="请输入当前密码"/>
                <div class="input-group"><div class="input-group-addon">新密码</div>
                <input type="password" id="newpwd" name="newpwd" value="" class="form-control" style="width:130px;height:30px;font-size:13px;" placeholder="请输入新密码"/>
                </br>
                </br>
                <button type="submit" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">修改密码</font></button>
                <button type="button" id="pwd" onClick="chg()" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">查看/隐藏密码</font></button>
                <a href="menu.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">返回</font></button></a>
            </form>
        </div>
</html>

<?php
    header("Content-Type:text/html;charset=utf-8");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($_POST["oldpwd"]) | empty($_POST["newpwd"])){
            ?>
            <script>
                alert("密码是必须填的！");
            </script>
            <?php
            exit();
        }else{
            if($_POST["oldpwd"] == $_POST["newpwd"]){
                ?>
                <script>
                    alert("两次密码不能一样！");
                </script>
                <?php
                exit();
            }
            require_once"conn.php";
            $query = "select * from user where username='".$_POST["username"]."' and password='".$_POST["oldpwd"]."'";
            if(mysqli_query($conn,$query)->num_rows <= 0){
                ?>
                <script>
                    alert("账号与密码不匹配！");
                </script>
                <?php
                exit();
            }
            $query = "update user set password='".$_POST["newpwd"]."',status=0 where username='".$_POST["username"]."' and password='".$_POST["oldpwd"]."'";
            if(!mysqli_query($conn,$query)){
                echo "修改失败：".mysqli_error($conn);
            }else{
                ?>
                <script>
                alert("密码修改成功，请重新登录！");
                window.location.href="menu.php";
                </script>
                <?php
            }
        }
    }
?>
