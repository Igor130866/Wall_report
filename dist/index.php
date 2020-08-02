<?php
    session_start();
    
    define("FORMAT_DATE", "d.m.y");
    require_once('db.php');
    require_once('header.php');
?>

    <div class="blog-header">
        <div class="container">
            <h1 class="blog-title">Стена</h1>
            <p class="lead blog-description">Место, где каждый может высказаться</p>
        </div>
    </div>

    <div class="container">

        <div class="row mb-5">

            <div class="col-sm-8 blog-main">


                <form id = "report" class="mb-5 <?php if (!(isset($_SESSION["mail"]))){echo 'd-none';}?>" action = "report_obr.php" method = "POST">
                    <h3>Написать на стене</h3>
                    
                    <div class="form-group">
                        <label for="title">Заголовок сообщение</label>
                        <input type="text" class="form-control" id="title" name = "headreport">
                    </div>
                    
                    <div class="form-group">
                        <label for="text">Текст сообщения</label>
                        <textarea id="text" class="form-control" rows="5" name = "textreport"></textarea>
                    </div>

                    <p class = "d-none text-danger error-report"></p>
                    <button type="submit" class="btn btn-primary">Написать</button>
                </form>

                <?php
                    $result = $mysqli->query("SELECT * FROM `report` WHERE 1 ORDER BY id DESC"); 
                    $row_cnt = mysqli_num_rows($result);
                    
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_array($result);  
                    } 
                    
                    do {

                    echo"
                        <div class='blog-post'>
                            <h2 class='blog-post-title'>".$row['wall_title']."</h2>
                            <p class='blog-post-meta'>Опубликован   ".date(FORMAT_DATE, $row['date']).". Автор:".$row['name_report']."</p>
                            <p>".$row['text']."</p>
                        </div>
                    ";
                    } while ($row = mysqli_fetch_array($result));

                    
                ?>
            </div>
            <!-- /.blog-main -->

            <div class="col-sm-3 offset-sm-1 blog-sidebar">
                <div class="sidebar-module sidebar-module-inset">
                    <h4>Статистика</h4>
                    <p>Всего постов:<?php echo"  $row_cnt";?>.</p>
                    <p>Дата первого:
                <?php
                    $result = $mysqli->query("SELECT MIN(`date`) AS `mindate` FROM `report`");
                    $row = mysqli_fetch_array($result);
                    $mind = date(FORMAT_DATE, $row['mindate']);
                    echo"$mind";
                ?>.</p>
                    <p>Дата последнего: 
                <?php
                    $result = $mysqli->query("SELECT MAX(`date`) AS `maxdate` FROM `report`");
                    $row = mysqli_fetch_array($result);
                    $maxd = date(FORMAT_DATE, $row['maxdate']);
                    echo"$maxd";
                ?>.</p>
                    <p>Автор первого: 
                <?php
                    $result = $mysqli->query("SELECT `name_report` FROM `report` WHERE `date`=(SELECT MIN(`date`) FROM `report`)");
                    $row = mysqli_fetch_array($result);
                    $minname = $row['name_report'];
                    echo"$minname";
                ?> </p>
                    <p>Автор последнего: 
                <?php
                    $result = $mysqli->query("SELECT `name_report` FROM `report` WHERE `date`=(SELECT MAX(`date`) FROM `report`)");
                    $row = mysqli_fetch_array($result);
                    //print_r($row);
                    $maxname = $row['name_report'];
                    echo"$maxname";
                ?>
                    </p>
                </div>
                <!-- /.blog-sidebar -->

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->
    <script>
        let form = document.querySelector('form[action = "report_obr.php"]');
        form.onsubmit = (e) => {
          e.preventDefault();
          
          let text = document.querySelector('textarea[name = "textreport"]');
          let head = document.querySelector('input[name = "headreport"]');
      
          let textcheck = text.value;
          let headcheck = head.value;
          textcheck = textcheck.trim();
          headcheck = headcheck.trim();

          //console.log("h",headcheck);
          //console.log("t",textcheck);
        
          if (textcheck == '' || headcheck == '') {
            let messageReport = form.querySelector('.error-report');
                messageReport.classList.remove("d-none");
                messageReport.innerHTML = "Сообщение не может быть пустым";
                messageReport.style.fontSize = "1.5rem";
          } else {
            let messageReport = form.querySelector('.error-report');
                messageReport.classList.remove("d-none");
                messageReport.innerHTML = "";
          }
          
          if (textcheck !== '' && headcheck !== '') {
            let formData = new FormData(form);  

            fetch('report_obr.php', {
                method: "POST",
                body: formData,
            })
            .then(response => response.text())

            .then(result => {
               // console.log("response",result);
                window.location.href = "index.php";
            });  
          }
        }  
    </script>
    <?php
        require_once('footer.php');
    ?>
    