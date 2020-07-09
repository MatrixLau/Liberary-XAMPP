<?php require_once"checklogin.php" ?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div class="panel panel-info">
        <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>图书管理系统 - 图书信息</b></big></font></h2></div>
            <div align="center">
                <form name="delbook" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="input-group"><div class="input-group-addon">书ID</div>
                    <input type="text" name="bookid" value="" class="form-control" style="width:120px;height:30px;font-size:13px;" placeholder="请输入图书ID"/>
                    </br>
                    </br>
                    <button type="submit" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">删除</font></button>
                    <a href="book.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">返回</font></button></a>
                </form>
                <?php
                    header("Content-Type:text/html;charset=utf-8");

                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if(empty($_POST["bookid"])){
                            ?>
                            <script>
                                alert("书ID是必须填的！");
                            </script>
                            <?php
                        }else{
                            $bookid = $_POST["bookid"];
                            require_once"conn.php";
                            $query = "select * from book where bookid='$bookid'";
                            if(!mysqli_query($conn,$query)){
                                echo "删除失败：".mysqli_error($conn);
                            }else{
                                $result = mysqli_query($conn,$query);
                                if($result->num_rows > 0){
                                    $row = $result->fetch_assoc();
                                    $lendbook = $row["lendcount"] - $row["returncount"];
                                    $stockbook = $row["stockcount"] - $lendbook;
                                    if($stockbook != $row["stockcount"]){
                                        ?>
                                        <script>
                                            alert("本书还在出借！");
                                        </script>
                                        <?php
                                        exit();
                                    }
                                    $querye = "delete from book where bookid='$bookid'";
                                    if(!mysqli_query($conn,$querye)){
                                        echo "删除失败：".mysqli_error($conn);
                                    }else{
                                        ?>
                                        <script>
                                            alert("删除成功");
                                        </script>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <script>
                                        alert("无此书");
                                    </script>
                                    <?php
                                }
                            }
                        }
                    }
                ?>
            </div>
</html>
