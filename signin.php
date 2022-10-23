<?php
	require_once ".conf.php";
	require_once "connection.php";
	$db = DBConnection::getInstance($sql_base, $sql_host, $sql_user, $sql_pswd);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>test-php-project</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="container">
		<?php
      $form = '<form action="/test-php-project/signin.php" method="POST">
          <div class="form-item">
            <input type="text" name="login" placeholder="Введите ваш логин" value="'. @$data['login']. '">
          </div>
          <div class="form-item">
            <input type="password" name="pass" placeholder="Введите пароль" value="'. @$data['pass']. '">
          </div>
          <div class="form-item">
            <button type="submit" name="is_signin">Войти</button>
          </div>
        </form>';
      
      if (!isset($_SESSION['logged_user'])){
        print($form);
      }
		?>

    <div class="user-msg">
      <?php
        function helloText(DBConnection $db = null){
          if (is_null($db) || !isset($_SESSION['logged_user'])) return;

          $username = $db->get_name_by_id($_SESSION['logged_user']);
          print('<span class="info-msg">Приветствуем Вас '. $username .'</span>
            <a id="go-main" class="back" href="/test-php-project/">на главную</a>
            <script type="text/javascript">
              const link = document.getElementById("go-main")
              const animateNext = () => {
                link.text += "."
                if (link.text.endsWith("...")) document.getElementById("go-main").click()
              }
              const animateAuto = () => {
                animateNext()
                setTimeout(animateAuto, 800);
              }
              setTimeout(animateAuto, 800);
            </script>'
          );
        }

        $data = $_POST;
        if (isset($data['is_signin'])){
          $err = array();
          if ('' == $data['login']){
            $err[] = "Введите логин";
          } elseif ($db->check_login($data['login'])){
            $hash = $db->get_password_hash($data['login']);
            if (password_verify($data['pass'], $hash)){			
              $userid = $db->get_id($data['login']);
              if ($userid > 0){
                $_SESSION['logged_user'] = $userid;
                helloText($db);
              } else {
                print('<span class="error-msg">Возникла непредвиденная ситуация</span>');
              }
            } else {
              $err[] = "Пароль не верный";
            }
          } else {
            $err[] = "Пользователь с таким логином не найден!";
          }
          // var_dump($err);
          if(!empty($err)){
            print('<span class="error-msg">'.array_shift($err).'</span>');
          }
        } else {
          helloText($db);
        }
      ?>
		</div>
	</div>
</body>
</html>
