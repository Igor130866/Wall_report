<?php
  session_start();
  define("FORMAT_DATE", "d.m.y");
  require_once('header.php');
  require_once('db.php');
?>

    <div class="blog-header">
        <div class="container">
            <h1 class="blog-title">Регистрация</h1>
            <p class="lead blog-description">Присоединяйтесь к большому сообществу</p>
        </div>
    </div>

    <div class="container">

        <div class="row mb-5">

            <div class="col-sm-8 blog-main">

                <form id = "admin" action = "reg_obr.php" method = "POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="mail">
                        <p class = "d-none text-danger error-email"></p>
                    </div>
                    <div class="form-group">
                        <label for="username">Имя пользователя</label>
                        <input type="text" class="form-control" id="username" placeholder="Имя пользователя"  name="name">
                        <p class = "d-none text-danger error-name"></p>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" class="form-control" id="password" placeholder="Пароль" name="pass">
                        <p class = "d-none text-danger error-pass"></p>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Повторите пароль</label>
                        <input type="password" class="form-control" id="confirm_password" placeholder="Повторите пароль"  name="passrepeat">
                        <p class = "d-none text-danger error-passrepeat"></p>
                    </div>

                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
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
    let form = document.querySelector('form[action = "reg_obr.php"]');
     form.onsubmit = (e) => {
        e.preventDefault();
       
       let formData = new FormData(form);
      
       fetch('reg_obr.php', {
         method: "POST",
         body: formData,
       })
       .then(response => response.text())

       .then(result => {

        switch (result) {
            case "Не заполнен адрес !!!":
                showErrorMessageMail(result);
                break;
            case "Не заполнено имя пользователя !!!":
                showErrorMessageName(result);
                break;
            case "ok":
                    window.location.href = "reg_success.php";
                break;
            case "Вы забыли пароль ???":
                showErrorMessagePass(result);
                break;   
            case "Пароль повторите, если вспомнили !!!":
                showErrorMessagePassrepeat(result);
                break;
            default:
                    alert("Что то пошло не так...");
        }
      });
    } 
    </script>
    <?php
        require_once('footer.php');
    ?>