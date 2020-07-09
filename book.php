<?php require_once"checklogin.php" ?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>图书管理系统 - 图书信息</b></big></font></h2></div>
        <div align="center">
            <a href="addbook.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:150px;height:33px;font-size:13px;"><font color="#fff">录入</font></button></a>
            <a href="editbook.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:150px;height:33px;font-size:13px;"><font color="#fff">修改</font></button></a>
            <a href="delbook.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:150px;height:33px;font-size:13px;"><font color="#fff">删除</font></button></a>
            <a href="menu.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:150px;height:33px;font-size:13px;"><font color="#fff">返回</font></button></a>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <br>
            ID<input type="radio" name="choice" value="A">
            书名<input type="radio" name="choice" value="B">
            作者<input type="radio" name="choice" value="C">
            <br>
            <input type="text" name="content" value="" class="form-control" style="width:120px;height:30px;font-size:13px;" placeholder="请输入查询内容"/>
            <button type="submit" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">查询</font></button>
            </form>
            <?php
                header("Content-Type:text/html;charset=utf-8");

                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    if(empty($_POST["content"])){
                        require_once"conn.php";
                        $query = "select * FROM book";
                        if(!mysqli_query($conn,$query)){
                            echo "查询失败：".mysqli_error($conn);
                        }else{
                            $result = mysqli_query($conn,$query);
                            if($result->num_rows > 0){
                                echo "<table style='border-color: #efefef;' border='1px' cellpadding='5px' cellspacing='0px'>";
                                echo "<tr><td>ID</td><td>书名</td><td>作者</td><td>出借次数</td><td>归还次数</td><td>库存</td></tr>";
                                while($row = $result->fetch_assoc()){
                                    $lendbook = $row["lendcount"] - $row["returncount"];
                                    $stockbook = $row["stockcount"] - $lendbook;
                                    echo "<tr><td>".$row["bookid"]."</td><td>".$row["bookname"]."</td><td>".$row["author"]."</td><td>".$row["lendcount"]."</td><td>".$row["returncount"]."</td><td>".$stockbook."/".$row["stockcount"]."</td></tr>";
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
                        $content = $_POST["content"];
                        if($_POST["choice"] == 'A'){
                            $query = "select * FROM book WHERE bookid like '".$content."'";
                        }else if($_POST["choice"] == 'B'){
                            $query = "select * FROM book WHERE bookname like '%".$content."%'";
                        }else{
                            $query = "select * FROM book WHERE author like '%".$content."%'";
                        }
                        if(!mysqli_query($conn,$query)){
                            echo "查询失败：".mysqli_error($conn);
                        }else{
                            $result = mysqli_query($conn,$query);
                            if($result->num_rows > 0){
                                echo "<table style='border-color: #efefef;' border='1px' cellpadding='5px' cellspacing='0px'>";
                                echo "<tr><td>ID</td><td>书名</td><td>作者</td><td>出借次数</td><td>归还次数</td><td>库存</td></tr>";
                                while($row = $result->fetch_assoc()){
                                    $lendbook = $row["lendcount"] - $row["returncount"];
                                    $stockbook = $row["stockcount"] - $lendbook;
                                    echo "<tr><td>".$row["bookid"]."</td><td>".$row["bookname"]."</td><td>".$row["author"]."</td><td>".$row["lendcount"]."</td><td>".$row["returncount"]."</td><td>".$stockbook."/".$row["stockcount"]."</td></tr>";
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