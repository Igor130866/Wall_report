<?php
  session_start();
   define("FORMAT_DATE", "d.m.y");
   require_once('header.php');
   require_once('db.php');
?>

    <div class="blog-header">
        <div class="container">
            <h1 class="blog-title">Авторизация</h1>
            <p class="lead blog-description">С возвращением в большое сообщество имени великой стены</p>
        </div>
    </div>

    <div class="container">

        <div class="row mb-5">

            <div class="col-sm-8 blog-main">

                <form id="admin" action = "login_obr.php" method = "POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="mail">
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" name="pass">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">
                        Запомнить меня
                      </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Войти</button>
                    <p class = "d-none text-danger mt-2 error-message"></p>
                </form>
                
            </div>
            <!-- /.blog-main -->
            <?php
                    $result = $mysqli->query("SELECT * FROM `report` WHERE 1 ORDER BY id DESC"); 
                    $row_cnt = mysqli_num_rows($result);
            ?>

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
            let form = document.querySelector('form[action = "login_obr.php"]');
            
            form.onsubmit = (e) => {
                e.preventDefault();

            let formData = new FormData(form);

                fetch('login_obr.php', {
                    method: 'POST',
                    body: formData,
                })  
                    .then(response => response.text())
                    
                    .then(result => {
                        if (result == "ok") {
                            window.location.href = "index.php";
                        } else {
                            showErrorMessageLogin(result);
                        }
                    });
            }
              
        </script>   
        <?php
             require_once('footer.php');
        ?>