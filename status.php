<?php require_once"checklogin.php" ?>
<?php require_once"conn.php" ?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>图书管理系统 - 信息统计</b></big></font></h2>
        <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>本站目前有
            <?php
                $query = "select * from book";
                $result = mysqli_query($conn,$query);
                $total = 0;
                echo $result->num_rows
            ?>
            种图书 总有图书
            <?php
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $total += $row["stockcount"];
                    }
                }   
                echo $total;
                
            ?>
            本</b></big></font></h2></div></div>
            <div align="center">
            <form name="status" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <script>
                    function chg(){
                        if(document.getElementById("way").value=="rankbook"){
                            document.getElementById("rankbook").style.display="";
                            document.getElementById("rankreader").style.display="none";
                        }else if(document.getElementById("way").value=="rankreader"){
                            document.getElementById("rankbook").style.display="none";
                            document.getElementById("rankreader").style.display="";
                        }else{
                            document.getElementById("rankbook").style.display="none";
                            document.getElementById("rankreader").style.display="none";
                        }
                    }
                </script>
                <select id="way" style="width:160px;height:30px;font-size:13px;" name="way" onChange="chg()">
                    <option value="plz">请选择</option>
                    <option value="rankbook">最热图书</option>
                    <option value="rankreader">最勤读者</option>
                </select>
                <a href="menu.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:100px;height:30px;font-size:13px;"><font color="#fff">返回</font></button></a>
            </form>
            <div name="rankbook" id="rankbook" class="list-group-item" style="display:none;">
                <?php
                    $queryrankbook = "select * from book order by lendcount DESC";
                    $resultrankbook = mysqli_query($conn,$queryrankbook);
                    if($resultrankbook->num_rows > 0){
                        echo "<table style='border-color: #efefef;' border='1px' cellpadding='5px' cellspacing='0px'>";
                        echo "<tr><td>ID</td><td>书名</td><td>作者</td><td>出借次数</td><td>归还次数</td><td>库存</td></tr>";
                        while($rowrankbook = $resultrankbook->fetch_assoc()){
                            $lendbook = $rowrankbook["lendcount"] - $rowrankbook["returncount"];
                            $stockbook = $rowrankbook["stockcount"] - $lendbook;
                            echo "<tr><td>".$rowrankbook["bookid"]."</td><td>".$rowrankbook["bookname"]."</td><td>".$rowrankbook["author"]."</td><td>".$rowrankbook["lendcount"]."</td><td>".$rowrankbook["returncount"]."</td><td>".$stockbook."/".$rowrankbook["stockcount"]."</td></tr>";
                        }
                        echo "</table>";
                    } 
                ?>
            </div>
            <div name="rankreader" id="rankreader" class="list-group-item" style="display:none;">
                <?php
                    $queryrankreader = "select * from reader order by lendcount DESC";
                    $resultrankreader = mysqli_query($conn,$queryrankreader);
                    if($resultrankreader->num_rows > 0){
                        echo "<table style='border-color: #efefef;' border='1px' cellpadding='5px' cellspacing='0px'>";
                        echo "<tr><td>ID</td><td>姓名</td><td>借书次数</td><td>还书次数</td><td>目前在借图书数量</td></tr>";
                        while($rowrankreader = $resultrankreader->fetch_assoc()){
                            echo "<tr><td>".$rowrankreader["readerid"]."</td><td>".$rowrankreader["readername"]."</td><td>".$rowrankreader["lendcount"]."</td><td>".$rowrankreader["returncount"]."</td>";
                            $queryrankbook2 = "select * FROM record WHERE recordreaderid like '".$rowrankreader["readerid"]."' and returntime is NULL";
                            $resultrankbook2 = mysqli_query($conn,$queryrankbook2);
                            echo "<td>".$resultrankbook2->num_rows."</td></tr>";
                        }
                        echo "</table>";
                    } 
                ?>
            </div>
        </div>
</html>