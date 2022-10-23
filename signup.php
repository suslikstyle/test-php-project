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
	<div class="container ">
    <?php
      $form = '<form action="/test-php-project/signup.php" method="POST">
        <div class="form-item">
          <input class="item" type="text" name="login" placeholder="Введите логин" value="'.@$data['login'].'"><span>*</span>
        </div>
        <div class="form-item">
          <input class="item" type="email" name="email" placeholder="Ваш e-mail" value="'.@$data['email'].'"><span>*</span>
        </div>
        <div class="form-item">
          <input class="item" type="password" name="pass" placeholder="Введите пароль"><span>*</span>
        </div>
        <div class="form-item">
          <input class="item" type="text" name="name" placeholder="Ваше имя" value="'.@$data['name'].'">
        </div>
        <div class="form-item">
          <input class="item" type="text" name="surname" placeholder="Ваша фамилия" value="'.@$data['surname'].'">
        </div>
        <div class="form-item">
          <input class="item" type="text" name="lastname" placeholder="Ваше отчество" value="'.@$data['lastname'].'">
        </div>
        <div class="form-item">
          <button class="item" type="submit" name="issignup">Зарегистрироваться</button>
        </div>
      </form>';
      if (!isset($_SESSION['logged_user'])){
        print($form);
      }
    ?>

    <div class="user-msg">
    <?php      
      $data = $_POST;
      if (isset($data['issignup'])){
        // check valid
        $errors = array();
        if ('' == trim($data['login'])) {
          $errors[] = 'Необходимо ввести логин!';
        }
        if ('' == trim($data['email'])) {
          $errors[] = 'Необходимо ввести e-mail!';
        }
        if ('' == trim($data['pass'])) {
          $errors[] = 'Необходимо ввести пароль!';
        }
        if ($db->check_login($data['login'])) {
          $errors[] = 'Пользователь с этим логином уже существует!';
        }
        
        if(empty($errors)){
          // register
          $user = $data['login'];
          $email = $data['email'];
          $pass = password_hash($data['pass'], PASSWORD_DEFAULT);
          if ($db->register($user, $email, $pass, $data['name'], $data['surname'], $data['lastname'])){
            $text = '<span class="info-msg">Вы успешно зарегистрированы. ';
            if (!is_null($user)) {
              $text .= "Используйте логин: <strong><em>$user</em></strong>";
              $text .= '<a class="link back" style="color:initial" href="/test-php-project/signin.php">войти</a>';
            }
            $text .= '</span>';
            print($text);
          } else {
            print('<span class="error-msg">Что-то пошло не так. Попробуйте позже.</span>');
          }
        } else {
          print('<span class="error-msg">'.array_shift($errors).'</span>');
        }
      }
    ?>
    </div>
	</div>

</body>
</html>