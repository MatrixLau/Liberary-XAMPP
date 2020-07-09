<?php require_once"checklogin.php" ?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>图书管理系统 - 读者信息</b></big></font></h2></div>
    <div align="center">
        <a href="addreader.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:150px;height:33px;font-size:13px;"><font color="#fff">添加</font></button></a>
        <a href="editreader.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:150px;height:33px;font-size:13px;"><font color="#fff">修改</font></button></a>
        <a href="delreader.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:150px;height:33px;font-size:13px;"><font color="#fff">删除</font></button></a>
        <a href="menu.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:150px;height:33px;font-size:13px;"><font color="#fff">返回</font></button></a>
        </br>
        <br>
        <form name="checkreader" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            ID<input type="radio" name="choice" value="A">
            姓名<input type="radio" name="choice" value="B">
            <br/>
            <input type="text" name="content" value="" class="form-control" style="width:120px;height:30px;font-size:13px;" placeholder="请输入查询内容"/>
            <button type="submit" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">查询</font></button>
        </form>
        <?php
            header("Content-Type:text/html;charset=utf-8");

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(empty($_POST["content"])){
                    require_once"conn.php";
                    $query = "select * FROM reader";
                    if(!mysqli_query($conn,$query)){
                        echo "查询失败：".mysqli_error($conn);
                    }else{
                        $result = mysqli_query($conn,$query);
                        if($result->num_rows > 0){
                            echo "<table style='border-color: #efefef;' border='1px' cellpadding='5px' cellspacing='0px'>";
                            echo "<tr><td>ID</td><td>姓名</td><td>借书次数</td><td>还书次数</td><td>目前在借图书数量</td></tr>";
                            while($row = $result->fetch_assoc()){
                                echo "<tr><td>".$row["readerid"]."</td><td>".$row["readername"]."</td><td>".$row["lendcount"]."</td><td>".$row["returncount"]."</td>";
                                $query2 = "select * FROM record WHERE recordreaderid like '".$row["readerid"]."' and returntime is NULL";
                                $result2 = mysqli_query($conn,$query2);
                                echo "<td>".$result2->num_rows."</td></tr>";
                            }
                            echo "</table>";
                        }else{
                            echo "无数据";
                        }

                    }
                }else{
                    $content = $_POST["content"];
                    require_once"conn.php";
                    if(!isset($_POST["choice"])){
                        ?>
                        <script>
                            alert("直接空值查询 或者 请选择查询方式！");
                        </script>
                        <?php
                        exit();
                    }
                    $queryreader = "select readername from reader where readerid='".$_POST["content"]."'";
                    if($_POST["choice"] == 'A'){
                        $query = "select * FROM reader WHERE readerid like '".$content."'";
                    }else{
                        $query = "select * FROM reader WHERE readername like '%".$content."%'";
                    }
                    if(!mysqli_query($conn,$query)){
                        echo "查询失败：".mysqli_error($conn);
                    }else{
                        $result = mysqli_query($conn,$query);
                        if($result->num_rows > 0){
                            echo "<table style='border-color: #efefef;' border='1px' cellpadding='5px' cellspacing='0px'>";
                            echo "<tr><td>读者ID</td><td>姓名</td><td>借书次数</td><td>还书次数</td><td>目前在借图书数量</td></tr>";
                            while($row = $result->fetch_assoc()){
                                echo "<tr><td>".$row["readerid"]."</td><td>".$row["readername"]."</td><td>".$row["lendcount"]."</td><td>".$row["returncount"]."</td>";
                                $query2 = "select * FROM record WHERE recordreaderid like '".$row["readerid"]."' and returntime is NULL";
                                $result2 = mysqli_query($conn,$query2);
                                echo "<td>".$result2->num_rows."</td></tr>";
                                if($result2->num_rows > 0){
                                    echo "<table style='border-color: #efefef;' border='1px' cellpadding='5px' cellspacing='0px'>";
                                    echo "<tr><td>日志ID</td><td>姓名</td><td>书名</td><td>借书时间</td><td>还书时间</td></tr>";
                                    while($row2 = $result2->fetch_assoc()){
                                        $recordbookname = "select bookname from book where bookid like '".$row2["recordbookid"]."'";
                                        $resultbook = mysqli_query($conn,$recordbookname);
                                        $bookrow = $resultbook->fetch_assoc();
                                        echo "<tr><td>".$row2["recordid"]."</td><td>".$row["readername"]."</td><td>".$bookrow["bookname"]."</td><td>".$row2["lendtime"]."</td></tr>";
                                    }
                                    echo "</table>";
                                }
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