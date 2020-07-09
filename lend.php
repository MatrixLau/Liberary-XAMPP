<?php require_once"checklogin.php" ?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>图书管理系统 - 阅证信息</b></big></font></h2></div>
        <div align="center">
            <form name="lend" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="input-group"><div class="input-group-addon">书ID</div>
                <input type="text" name="bookid" value="" class="form-control" style="width:120px;height:30px;font-size:13px;" placeholder="请输入图书ID"/>
                <div class="input-group"><div class="input-group-addon">读者ID</div>
                <input type="text" name="readerid" value="" class="form-control" style="width:120px;height:30px;font-size:13px;" placeholder="请输入读者ID"/>
                </br>
                <br>
                <button type="submit" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">借书</font></button>
                <a href="record.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">返回</font></button></a>
            </form>
            <?php
                header("Content-Type:text/html;charset=utf-8");
                date_default_timezone_set('Asia/Shanghai');

                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    if(empty($_POST["bookid"]) | empty($_POST["readerid"])){
                        ?>
                        <script>
                            alert("请不要有留空！");
                        </script>
                        <?php
                    }else{
                    $bookid = $_POST["bookid"];
                    $readerid = $_POST["readerid"];
                    require_once"conn.php";
                    $getbook = "select lendcount,returncount,stockcount from book where bookid='".$bookid."'";
                    $resultbook = mysqli_query($conn,$getbook);
                    $getreader = "select lendcount from reader where readerid='".$readerid."'";
                    if($resultbook->num_rows > 0){
                        $rowbook = $resultbook->fetch_assoc();
                        $resultreader = mysqli_query($conn,$getreader);
                        if($resultreader->num_rows > 0){
                            $rowreader = $resultreader->fetch_assoc();
                            $lendcount1 = $rowbook["lendcount"]+1;
                            $lendbook = "update book set lendcount='".$lendcount1."' where bookid='".$bookid."'";
                            $lendcount2 = $rowreader["lendcount"]+1;
                            $lendreader = "update reader set lendcount='".$lendcount2."' where readerid='".$readerid."'";
                            $query = "INSERT INTO record VALUES(NULL,'".$readerid."','".$bookid."',DEFAULT,DEFAULT)";
                            $lendbookc = $rowbook["lendcount"] - $rowbook["returncount"];
                            $stockbook = $rowbook["stockcount"] - $lendbookc;
                            if($stockbook <= 0){
                                ?>
                                <script>
                                    alert("本书已无库存");
                                </script>
                                <?php
                                exit();
                            }
                            if(!mysqli_query($conn,$query) & mysqli_query($conn,$lendbook) & mysqli_query($conn,$lendreader)){
                                echo "借书失败：".mysqli_error($conn);
                            }else{
                                ?>
                            <script>
                                alert("借书成功");
                            </script>
                            <?php
                            }
                        }else{
                            ?>
                            <script>
                                alert("无此人");
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
            ?>
        </div>
</html>
