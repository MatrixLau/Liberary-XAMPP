<?php require_once"checklogin.php" ?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>图书管理系统 - 读者信息</b></big></font></h2></div>
    <div align="center">
        <form name="delreader" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="input-group"><div class="input-group-addon">读者ID</div>
            <input type="text" name="readerid" value="" class="form-control" style="width:120px;height:30px;font-size:13px;" placeholder="请输入读者ID"/>
            </br>
            </br>
            <button type="submit" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">删除</font></button>
            <a href="reader.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">返回</font></button></a>
        </form>
        <?php
            header("Content-Type:text/html;charset=utf-8");

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(empty($_POST["readerid"])){
                    ?>
                    <script>
                        alert("读者ID是必须填的！");
                    </script>
                    <?php
                }else{
                    $readerid = $_POST["readerid"];
                    require_once"conn.php";
                    $query = "select * from reader where readerid='$readerid'";
                    $queryrecord = "select * from record where recordreaderid='$readerid' and returntime is NULL";
                    $resultrecord = mysqli_query($conn,$queryrecord);
                    if($resultrecord->num_rows > 0){
                        ?>
                        <script>
                            alert("读者还有未归还图书！");
                        </script>
                        <?php
                        exit();
                    }
                    if(!mysqli_query($conn,$query)){
                        echo "删除失败：".mysqli_error($conn);
                    }else{
                        $result = mysqli_query($conn,$query);
                        if($result->num_rows > 0){
                            $querye = "delete from reader where readerid='$readerid'";
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
                                alert("无此读者");
                            </script>
                            <?php
                        }
                    }
                }
            }
        ?>
    </div>
</html>
