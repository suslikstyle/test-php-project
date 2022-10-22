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
				print('<span style="color: #f44;">'.array_shift($errors).'</span><br>');
			} else {
				// ready
				$id = $_SESSION['logged_user'];
				if ($id > 0){
					if ($db->new_name_by_id($id, $data['name'], $data['surname'], $data['lastname'])){
						print('<span style="color: #4f4;">Успешно! <a href="/test-php-project/">на главную</a></span><br>');
					}
				}
			}
		}
	?>
	<div class="container ">
		<form action="/test-php-project/changename.php" method="POST">
			<div class="item-wrapper">
				<input class="item" type="text" name="name" placeholder="Введите новое имя" value="<?php echo(@$data['name']); ?>"><span>*</span>
			</div>
			<div class="item-wrapper">
				<input class="item" type="text" name="surname" placeholder="Введите новую фамилию" value="<?php echo(@$data['surname']); ?>"><span>*</span>
			</div>
			<div class="item-wrapper">
				<input class="item" type="text" name="lastname" placeholder="Введите новое отчество"><span>*</span>
			</div>
			<div class="item-wrapper">
				<button class="item" type="submit" name="change">изменить</button>
			</div>
		</form>
	</div>

</body>
</html>