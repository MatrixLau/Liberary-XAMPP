<?php require_once"checklogin.php" ?>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div align="center" class="list-group-item reed" style="background:#337ab7;"><h2 class="panel-title"><font size=2 color="#fff"><big><b>图书管理系统 - 阅证信息</b></big></font></h2></div>
        <div align="center">
            <form name="return" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                还书方式
                <script>
                function chg(){
                    if(document.getElementById("way").value=="record"){
                        document.getElementById("recordshow").style.display="";
                        document.getElementById("recordid").style.display="";
                        document.getElementById("bookshow").style.display="none";
                        document.getElementById("bookid").style.display="none";
                        document.getElementById("readershow").style.display="none";
                        document.getElementById("readerid").style.display="none";
                    }else if(document.getElementById("way").value=="book"){
                        document.getElementById("recordshow").style.display="none";
                        document.getElementById("recordid").style.display="none";
                        document.getElementById("bookshow").style.display="";
                        document.getElementById("bookid").style.display="";
                        document.getElementById("readershow").style.display="";
                        document.getElementById("readerid").style.display="";
                    }else{
                        document.getElementById("recordshow").style.display="none";
                        document.getElementById("recordid").style.display="none";
                        document.getElementById("bookshow").style.display="none";
                        document.getElementById("bookid").style.display="none";
                        document.getElementById("readershow").style.display="none";
                        document.getElementById("readerid").style.display="none";
                    }
                }
                </script>
                <select id="way" name="way" onChange="chg()">
                <option value="plz">请选择</option>
                <option value="record">记录ID</option>
                <option value="book">书ID和读者ID</option>
                </select>
                <br>
                <br>

                <div class="input-group"><div class="input-group-addon" style="display:none" id="recordshow">记录ID</div>
                <input type="text" name="recordid" id="recordid" value="" class="form-control" style="width:120px;height:30px;font-size:13px;display:none;" placeholder="请输入记录ID"/>
                <div class="input-group"><div class="input-group-addon" style="display:none" id="bookshow">书ID</div>
                <input type="text" name="bookid" id="bookid" value="" class="form-control" style="width:120px;height:30px;font-size:13px;display:none;" placeholder="请输入图书ID"/>
                <div class="input-group"><div class="input-group-addon" style="display:none" id="readershow">读者ID</div>
                <input type="text" name="readerid" id="readerid" value="" class="form-control" style="width:120px;height:30px;font-size:13px;display:none;" placeholder="请输入读者ID"/>
                </br>
                <div align="center"><h2 class="panel-title"><font size=2><big><b>直接输入记录ID 或者 输入书ID和读者ID 进行还书</b></big></font></h2></div>
                <button type="submit" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">还书</font></button>
                <a href="record.php"><button type="button" class="btn btn-danger btn-block" style="background:#337ab7;width:120px;height:30px;font-size:13px;"><font color="#fff">返回</font></button></a>
            </form>
            <?php
                header("Content-Type:text/html;charset=utf-8");
                date_default_timezone_set('Asia/Shanghai');

                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    if($_POST["way"] == "plz"){
                        ?>
                        <script>
                            alert("请不要有留空！");
                        </script>
                        <?php
                        exit();
                    }elseif($_POST["way"] == "record"){
                        if(empty($_POST["recordid"])){
                            ?>
                            <script>
                                alert("记录ID是必须填的！");
                            </script>
                            <?php
                            exit();
                        }
                    }elseif($_POST["way"] == "book"){
                        if(empty($_POST["bookid"]) | empty($_POST["readerid"])){
                            ?>
                            <script>
                                alert("书ID和读者ID是必须填的！");
                            </script>
                            <?php
                            exit();
                        }
                    }
                    if($_POST["way"] == "record"){
                        require_once"conn.php";
                        $getrecord = "select * from record where recordid='".$_POST["recordid"]."'";
                        $resultrecord = mysqli_query($conn,$getrecord);
                        if($resultrecord->num_rows <= 0){
                            ?>
                            <script>
                                alert("无此记录");
                            </script>
                            <?php
                            exit();
                        }
                        $rowrecord = $resultrecord->fetch_assoc();
                        $bookid = $rowrecord["recordbookid"];
                        $readerid = $rowrecord["recordreaderid"];
                        $getbook = "select returncount from book where bookid='".$bookid."'";
                        $resultbook = mysqli_query($conn,$getbook);
                        $getreader = "select returncount from reader where readerid='".$readerid."'";
                        if($resultbook->num_rows > 0){
                            $rowbook = $resultbook->fetch_assoc();
                            $resultreader = mysqli_query($conn,$getreader);
                            if($resultreader->num_rows > 0){
                                $rowreader = $resultreader->fetch_assoc();
                                $returncount1 = $rowbook["returncount"]+1;
                                $returnbook = "update book set returncount='".$returncount1."' where bookid='".$bookid."'";
                                $returncount2 = $rowreader["returncount"]+1;
                                $returnreader = "update reader set returncount='".$returncount2."' where readerid='".$readerid."'";
                                $query = "update record set returntime=now() where recordbookid = '".$bookid."' and recordreaderid = '".$readerid."'";
                                if(!mysqli_query($conn,$query) & mysqli_query($conn,$returnbook) & mysqli_query($conn,$returnreader)){
                                    echo "还书失败：".mysqli_error($conn);
                                }else{
                                    ?>
                                    <script>
                                        alert("还书成功");
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
                    }else{
                        $bookid = $_POST["bookid"];
                        $readerid = $_POST["readerid"];
                        require_once"conn.php";
                        $getbook = "select returncount from book where bookid='".$bookid."'";
                        $resultbook = mysqli_query($conn,$getbook);
                        $getreader = "select returncount from reader where readerid='".$readerid."'";
                        $querye = "select * from record where recordbookid = '".$bookid."' and recordreaderid = '".$readerid."' and returntime is NULL";
                        if(mysqli_query($conn,$querye)->num_rows <= 0){
                            ?>
                            <script>
                                alert("无此记录");
                            </script>
                            <?php
                            exit();
                        }
                        if($resultbook->num_rows > 0){
                            $rowbook = $resultbook->fetch_assoc();
                            $resultreader = mysqli_query($conn,$getreader);
                            if($resultreader->num_rows > 0){
                                $rowreader = $resultreader->fetch_assoc();
                                $returncount1 = $rowbook["returncount"]+1;
                                $returnbook = "update book set returncount='".$returncount1."' where bookid='".$bookid."'";
                                $returncount2 = $rowreader["returncount"]+1;
                                $returnreader = "update reader set returncount='".$returncount2."' where readerid='".$readerid."'";
                                $query = "update record set returntime=now() where recordbookid = '".$bookid."' and recordreaderid = '".$readerid."'";
                                if(!mysqli_query($conn,$query) & mysqli_query($conn,$returnbook) & mysqli_query($conn,$returnreader)){
                                    echo "还书失败：".mysqli_error($conn);
                                }else{
                                    ?>
                                <script>
                                    alert("还书成功");
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
