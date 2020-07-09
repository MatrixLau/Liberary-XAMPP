<?php require_once"checklogin.php" ?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>图书管理系统 - 图书信息</b></big></font></h2></div>
        <div div align="center">
            <form name="editbook" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="input-group"><div class="input-group-addon">书ID</div>
                <input type="text" name="bookid" value="" class="form-control" style="width:120px;height:30px;font-size:13px;" placeholder="请输入图书ID"/>
                <div class="input-group"><div class="input-group-addon">书名</div>
                <input type="text" name="bookname" value="" class="form-control" style="width:120px;height:30px;font-size:13px;" placeholder="请输入图书名称"/>
                <div class="input-group"><div class="input-group-addon">作者</div>
                <input type="text" name="author" value="" class="form-control" style="width:120px;height:30px;font-size:13px;" placeholder="请输入作者名称"/>
                <div class="input-group"><div class="input-group-addon">库存</div>
                <input type="text" name="stockcount" value="" class="form-control" style="width:120px;height:30px;font-size:13px;" placeholder="请输入库存"/>
                <div align="center"><h2 class="panel-title"><font size=2><big><b>留空即为不修改</b></big></font></h2></div>
                <button type="submit" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">修改</font></button>
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
                    }elseif(empty($_POST["bookname"]) & empty($_POST["author"]) & empty($_POST["stocksount"])){
                        ?>
                        <script>
                            alert("必须修改至少一项内容！");
                        </script>
                        <?php
                    }else{
                        $bookid = $_POST["bookid"];                       
                        require_once"conn.php";
                        $query = "select * from book where bookid='".$bookid."'";
                        if(!mysqli_query($conn,$query)){
                            echo "查询失败：".mysqli_error($conn);
                        }else{
                            $result = mysqli_query($conn,$query);
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if(empty($_POST["bookname"])){
                                        $bookname = $row["bookname"];
                                    }else{
                                        $bookname = $_POST["bookname"];
                                    }
                                    if(empty($_POST["author"])){
                                        $author = $row["author"];
                                    }else{
                                        $author = $_POST["author"];
                                    }
                                    if(empty($_POST["stockcount"])){
                                        $stockcount = $row["stockcount"];
                                    }else{
                                        $stockcount = $_POST["stockcount"];
                                    }
                                    $query2 = "update book set bookname='$bookname' ,author='$author' ,stockcount='.$stockcount.' where bookid='".$bookid."'";
                                    if(!mysqli_query($conn,$query2)){
                                        echo "修改失败：".mysqli_error($conn);
                                    }else{
                                        ?>
                                        <script>
                                            alert("修改成功");
                                        </script>
                                        <?php
                                    }
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