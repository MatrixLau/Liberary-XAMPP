<?php require_once"checklogin.php" ?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>图书管理系统 - 图书信息</b></big></font></h2></div>
            <div align="center">
                <form name="addbook" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="input-group"><div class="input-group-addon">书名</div>
                    <input type="text" name="bookname" value="" class="form-control" style="width:130px;height:30px;font-size:13px;" placeholder="请输入图书名称"/>
                    <div class="input-group"><div class="input-group-addon">作者</div>
                    <input type="text" name="author" value="" class="form-control" style="width:130px;height:30px;font-size:13px;" placeholder="请输入作者名称"/>
                    <div class="input-group"><div class="input-group-addon">库存</div>
                    <input type="text" name="stockcount" value="" class="form-control" style="width:130px;height:30px;font-size:13px;" placeholder="请输入库存(留空为1)"/>
                    </br>
                    </br>
                    <button type="submit" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">录入</font></button>
                    <a href="book.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">返回</font></button></a>
                </form>
            </div>
</html>

<?php
    header("Content-Type:text/html;charset=utf-8");
    $stockcount = 1;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($_POST["bookname"])){
            ?>
            <script>
                alert("书名是必须填的！");
            </script>
            <?php
        }else{
            $bookname = $_POST["bookname"];
            if(!empty($_POST["stockcount"])){
                $stockcount = $_POST["stockcount"];
            }
            require_once"conn.php";
            if(empty($_POST["author"])){
                $query = "INSERT INTO book VALUES(NULL,'".$bookname."',DEFAULT,DEFAULT,DEFAULT,".$stockcount.")";
            }else{
                $author = $_POST["author"];
                $query = "INSERT INTO book VALUES(NULL,'".$bookname."','".$author."',DEFAULT,DEFAULT,".$stockcount.")";
            }
            if(!mysqli_query($conn,$query)){
                echo "录入失败：".mysqli_error($conn);
            }else{
                ?>
                <script>
                alert("录入成功");
                </script>
                <?php
            }
        }
    }
?>
