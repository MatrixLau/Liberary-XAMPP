<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>图书管理系统</b></big></font></h2></div>
        <div align="center">
            <?php
                header("Content-Type:text/html;charset=utf-8");
                date_default_timezone_set('Asia/Shanghai');
                $hour = date("H");
                $greeting;
                if($hour < 6){$greeting="🌌 还不睡就要猝死了！";}
                    else if ($hour < 8){$greeting="🌅 你起的很早呢";}
                    else if ($hour < 12){$greeting="☀️ 早上好呀";}
                    else if ($hour < 14){$greeting="🏝 午安";}
                    else if ($hour < 18){$greeting="🌤 下午好哦";}
                    else if ($hour < 22){$greeting="🌃 晚上好";}
                    else if ($hour < 24){$greeting="🌑 夜深了，晚安~";}

                    $username = "请登录";

                    require_once"conn.php";

                    $query = "select * from user where status=1";

                    mysqli_query($conn,$query);
                    $result = mysqli_query($conn,$query);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $username = $row["username"];
                        }
                    }

                    if($username != "请登录"){
                ?>
                <form name="logout" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <?php echo $greeting; echo " ";?><big><a href="javascript:logout.submit();"><?php echo $username?></a></big>
                    <input type="hidden" name="logout" value="1">
                </form>
                <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if(isset($_POST["logout"]) && $_POST["logout"] == "1"){
                            ?>
                            <script>
                                alert("已成功退出登录");
                            </script>
                            <?php
                                $query = "update user set status=0 where username='".$username."'";
                                mysqli_query($conn,$query);
                                header("Refresh:0");
                            ?>
                            <meta http-equiv='refresh'/>
                            <?php
                        }
                    }
                ?>
                <a href="book.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:310px;height:33px;font-size:13px;"><font color="#fff">图书信息</font></button></a>
                <br>
                </br>
                <a href="reader.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:310px;height:33px;font-size:13px;"><font color="#fff">读者信息</font></button></a>
                <br>
                </br>
                <a href="record.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:310px;height:33px;font-size:13px;"><font color="#fff">阅证信息</font></button></a>
                <br>
                </br>
                <a href="status.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:310px;height:33px;font-size:13px;"><font color="#fff">信息统计</font></button></a>
                <br>
                </br>
                <a href="changepwd.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:310px;height:33px;font-size:13px;"><font color="#fff">修改管理员密码</font></button></a>
                <?php
                    }else{
                        ?>
                        <form name="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="input-group"><div class="input-group-addon">账号</div>
                            <input type="text" name="username" value="" class="form-control" placeholder="请输入您的账号"/></div>
                            <div class="input-group"><div class="input-group-addon">密码</div>
                            <input type="password" name="password" value="" class="form-control" placeholder="请输入您的密码"/></div>
                            <br>
                            <input type="hidden" name="login" value="1">
                            <button type="submit" class="btn btn-danger btn-block" style="background:#337ab7;">立即登录</button>
                        </form>
                        <?php
                    }

                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if(isset($_POST["login"]) && $_POST["login"] == "1"){
                            if(empty($_POST["username"])){
                                ?>
                                <script>
                                    alert("请输入账号");
                                </script>
                                <?php
                            }elseif(empty($_POST["password"])){
                                ?>
                                <script>
                                    alert("请输入密码");
                                </script>
                                <?php
                            }else{
                                $query = "select * from user where username='".$_POST["username"]."'";
                                mysqli_query($conn,$query);
                                $result = mysqli_query($conn,$query);
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()){
                                        if($_POST["password"] != $row["password"]){
                                            ?>
                                            <script>
                                                alert("账号与密码不匹配");
                                            </script>
                                            <?php
                                        }else{
                                            ?>
                                            <script>
                                                alert("已成功登录");
                                            </script>
                                            <?php
                                                $query = "update user set status=1 where username='".$_POST["username"]."'";
                                                mysqli_query($conn,$query);
                                                header("Refresh:0");
                                            ?>
                                            <meta http-equiv='refresh'/>
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                    }
                ?>    
        </div>
</html>