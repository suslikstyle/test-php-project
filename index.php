<?php
  setlocale(LC_ALL, "ru");

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
  <div class="container main-data">
    <div class="auth">
      <?php
        // var_dump($_SESSION);
        if (isset($_SESSION['logged_user'])){
          // для залогиненного пользователя показать:
          $name = $db->get_name_by_id($_SESSION['logged_user']);

          print('<div class="menu link"><span">Привет, '.$name.'</span>
                <a href="/test-php-project/logout.php">выход</a>
                <a href="/test-php-project/changename.php">изменить данные</a></div>'
          );
        } else {
          // для не залогиненного:
          print('<div class="menu link"><span>Привет гость!</span>
                <a href="signin.php">войти</a>
                <a href="signup.php">регистрация</a></div>'
          );
        }

      ?>
    </div>

    <div class="data">
      <h1>Тестовое задание</h1>

      <H2>PHP</H2>
      <p>Создать страницу с авторизацией пользователя: логин и пароль и реализовать в ней:
      возможность регистрации пользователя (email, логин, пароль, ФИО),
      при входе в "личный кабинет" возможность сменить пароль и ФИО.
      использовать "чистый" PHP 5.6 и выше (без фреймворков) и MySQL 5.5 и выше, дизайн не важен, верстка тоже простая. Наворотов не нужно, хотим посмотреть просто Ваш код.</p>

      <H2>SQL</H2>

      <span>Есть 2 таблицы</span>

      <h5>таблица пользователей:</h5>
      <div class="data-list">
          <p>users</p>
          <p>----------</p>
          <p>`id` int(11)</p>
          <p>`email` varchar(55)</p>
          <p>`login` varchar(55)</p>
      </div>

      <h5>и таблица заказов</h5>
      <div class="data-list">
          <p>orders</p>
          <p>--------</p>
          <p>`id` int(11)</p>
          <p>`user_id` int(11)</p>
          <p>`price` int(11)</p>
      </div>


      <span><strong>Необходимо:</strong> составить запрос, который выведет список email'лов 
          встречающихся более чем у одного пользователя вывести список логинов пользователей, 
          которые не сделали ни одного заказа вывести список логинов пользователей которые сделали 
          более двух заказов
      </span>

      <p>Cрок на выполнение - 1 день.</p>
    </div>
      <?php
        if (isset($_SESSION['logged_user'])){
          $query = "SELECT `email` FROM `users` GROUP BY `email` HAVING count(*)>1";
          $res = $db->query($query);
          $num_rows = mysqli_num_rows($res);
          if ($num_rows > 0){
              print('<div class="data"><hr><h2>Результаты</h2><h3>Cписок email\'лов</h3><span>Cписок email\'лов встречающихся более чем у одного пользователя</span>');
              print('<div class="data-list"><ol>');
              while ($row = $res->fetch_assoc()) {
                  print('<li>'.$row['email'].'</li>');
              }
              print('</ol></div>');
          } else {
              print('<br><h3>Cписок email\'лов</h3><span>email\'лов встречающихся более чем у одного пользователя нет!</span>');
          }
          
          $query = "SELECT `users`.*
                  FROM `users` LEFT JOIN `orders` ON `users`.`id`=`orders`.`user_id`
                  WHERE `orders`.`user_id` IS NULL";
          $res = $db->query($query);
          $num_rows = mysqli_num_rows($res);
          if ($num_rows > 0){
              print('<br><h3>Список логинов</h3><span>Список логинов пользователей, которые не сделали ни одного заказа</span>');
              print('<div class="data-list"><ol>');
              while ($row = $res->fetch_assoc()) {
                  print('<li>[id='.$row['id']."] ".$row['login'].'</li>');
              }
              print('</ol></div>');
          } else {
              print('<br><h3>Список логинов</h3><span>Логинов пользователей, которые не сделали ни одного заказа нет!</span>');
          }
          
          $query = "SELECT c.`id`, c.`login` FROM 
                  (SELECT `users`.`id`, `users`.`login`, COUNT(`orders`.`user_id`) AS counter FROM `users` INNER JOIN
                  `orders` ON `users`.`id`=`orders`.`user_id` 
                  GROUP BY `users`.`id`, `users`.`login`) AS c WHERE c.`counter`>2";
          $res = $db->query($query);
          $num_rows = mysqli_num_rows($res);
          if ($num_rows > 0){
              print('<br><h3>Список логинов</h3><span>Список логинов пользователей которые сделали более двух заказов</span>');
              print('<div class="data-list"><ol>');
              while ($row = $res->fetch_assoc()) {
                  print('<li>[id='.$row['id'].'] '.$row['login'].'</li>');
              }
              print('</ol></div>');
          } else {
              print('<br><h3>Список логинов</h3><span>логинов пользователей которые сделали более двух заказов нет!</span>');
          }
        } else {
            print('<span>Доступны после регистрации</span>');
        }

      ?>
    </div>
  </div>
</body>
</html>