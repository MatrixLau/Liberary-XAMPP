<?php require_once"checklogin.php" ?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>图书管理系统 - 阅证信息</b></big></font></h2></div>
        <div align="center">
            <a href="lend.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:150px;height:33px;font-size:13px;"><font color="#fff">借书</font></button></a>
            <a href="return.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:150px;height:33px;font-size:13px;"><font color="#fff">还书</font></button></a>
            <a href="menu.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:150px;height:33px;font-size:13px;"><font color="#fff">返回</font></button></a>
            </br>
            <br>
            <form name="checkrecord" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                记录ID<input type="radio" name="choice" value="A">
                书ID<input type="radio" name="choice" value="B">
                读者ID<input type="radio" name="choice" value="C">
                <br>
                <input type="text" name="content" value="" class="form-control" style="width:120px;height:30px;font-size:13px;" placeholder="请输入查询内容"/>
                <button type="submit" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">查询</font></button>
            </form>
            <?php
                header("Content-Type:text/html;charset=utf-8");

                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    if(empty($_POST["content"])){
                        require_once"conn.php";
                        $query = "select * from record";
                        if(!mysqli_query($conn,$query)){
                            echo "查询失败：".mysqli_error($conn);
                        }else{
                            $result = mysqli_query($conn,$query);
                            if($result->num_rows > 0){
                                echo "<table style='border-color: #efefef;' border='1px' cellpadding='5px' cellspacing='0px'>";
                                echo "<tr><td>记录ID</td><td>读者姓名</td><td>书名</td><td>借书时间</td><td>还书时间</td></tr>";
                                while($row = $result->fetch_assoc()){
                                    $queryreader = "select readername from reader where readerid='".$row["recordreaderid"]."'";
                                    $rowreader = mysqli_query($conn,$queryreader)->fetch_assoc();
                                    $querybook = "select bookname from book where bookid='".$row["recordbookid"]."'";
                                    $rowbook = mysqli_query($conn,$querybook)->fetch_assoc();
                                    echo "<tr><td>".$row["recordid"]."</td><td>".$rowreader["readername"]."</td><td>".$rowbook["bookname"]."</td><td>".$row["lendtime"]."</td><td>".$row["returntime"]."</td></tr>";
                                }
                                echo "</table>";
                            }else{
                                echo "无数据";
                            }
                        }
                    }else{
                        require_once"conn.php";
                        if(!isset($_POST["choice"])){
                            ?>
                            <script>
                                alert("直接空值查询 或者 请选择查询方式！");
                            </script>
                            <?php
                            exit();
                        }
                        if($_POST["choice"] == 'A'){
                            $query = "select * FROM record WHERE recordid like '".$_POST["content"]."'";
                        }else if($_POST["choice"] == 'B'){
                            $query = "select * FROM record WHERE recordbookid like '".$_POST["content"]."'";
                        }else{
                            $query = "select * FROM record WHERE recordreaderid like '".$_POST["content"]."'";
                        }
                        if(!mysqli_query($conn,$query)){
                            echo "查询失败：".mysqli_error($conn);
                        }else{
                            $result = mysqli_query($conn,$query);
                            if($result->num_rows > 0){
                                echo "<table style='border-color: #efefef;' border='1px' cellpadding='5px' cellspacing='0px'>";
                                echo "<tr><td>记录ID</td><td>读者姓名</td><td>书名</td><td>借书时间</td><td>还书时间</td></tr>";
                                while($row = $result->fetch_assoc()){
                                    $queryreader = "select readername from reader where readerid='".$row["recordreaderid"]."'";
                                    $rowreader = mysqli_query($conn,$queryreader)->fetch_assoc();
                                    $querybook = "select bookname from book where bookid='".$row["recordbookid"]."'";
                                    $rowbook = mysqli_query($conn,$querybook)->fetch_assoc();
                                    echo "<tr><td>".$row["recordid"]."</td><td>".$rowreader["readername"]."</td><td>".$rowbook["bookname"]."</td><td>".$row["lendtime"]."</td><td>".$row["returntime"]."</td></tr>";
                                }
                                echo "</table>";
                            }else{
                                echo "无数据";
                            }
                        }
                    }
                }
            ?>
        </div>
</html>