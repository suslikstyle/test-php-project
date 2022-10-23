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
      $form = '<label for="change-data">Изменение данных пользователя: <strong><em>'.$db->get_name_by_id($_SESSION['logged_user']).'</em></strong></label>
      <form id="change-data" action="/test-php-project/changename.php" method="POST">
        <div class="form-item">
          <input type="text" name="name" placeholder="Введите новое имя" value="'. @$data['name'].'"><span>*</span>
        </div>
        <div class="form-item">
          <input type="text" name="surname" placeholder="Введите новую фамилию" value="'. @$data['surname'].'"><span>*</span>
        </div>
        <div class="form-item">
          <input type="text" name="lastname" placeholder="Введите новое отчество"><span>*</span>
        </div>
        <div class="form-item">
          <button type="submit" name="change">изменить</button>
        </div>
      </form>';
      
      print($form);
    ?>

    <div class="user-msg">
      <?php
        $data = $_POST;
        if (isset($data['change'])){
          $errors = array();
          if ('' == trim($data['name'])) {
            $errors[] = 'Поле имени пустое!';
          }
          if ('' == trim($data['surname'])) {
            $errors[] = 'Поле фамилии пустое!';
          }
          if ('' == trim($data['lastname'])) {
            $errors[] = 'Поле отчества пустое!';
          }
          if(!empty($errors)){
            print('<span class="error-msg">'.array_shift($errors).'</span>');
          } else {
            // ready
            $id = $_SESSION['logged_user'];
            if ($id > 0){
              if ($db->new_name_by_id($id, $data['name'], $data['surname'], $data['lastname'])){
                print('<span class="info-msg">Успешно!</span>');
              }
            }
          }
        }
      ?>
      <a class="back" href="/test-php-project/">На главную</a>
	</div>

</body>
</html>