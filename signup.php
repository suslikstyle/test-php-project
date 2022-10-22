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
					print('<span style="color: #4f4;">Вы успешно зарегистрированы как '.$user.'</span><a style="padding: 0 5px 0 10px;text-decoration: none;color: #333;text-shadow: 1px 1px 2px #555;" href="/test-php-project/login.php">войти</a><br>');
				} else {
					print('<span style="color: #44f;">Что-то пошло не так. Попробуйте позже. </span><br>');
				}
			} else {
				print('<span style="color: #f44;">'.array_shift($errors).'</span><br>');
			}
		}
	?>

	<div class="container ">

		<form action="/test-php-project/signup.php" method="POST">
			<div class="item-wrapper">
				<input class="item" type="text" name="login" placeholder="Введите логин" value="<?php echo(@$data['login']); ?>"><span>*</span>
			</div>
			<div class="item-wrapper">
				<input class="item" type="email" name="email" placeholder="Ваш e-mail" value="<?php echo(@$data['email']); ?>"><span>*</span>
			</div>
			<div class="item-wrapper">
				<input class="item" type="password" name="pass" placeholder="Введите пароль"><span>*</span>
			</div>
			<div class="item-wrapper">
				<input class="item" type="text" name="name" placeholder="Ваше имя" value="<?php echo(@$data['name']); ?>">
			</div>
			<div class="item-wrapper">
				<input class="item" type="text" name="surname" placeholder="Ваша фамилия" value="<?php echo(@$data['surname']); ?>">
			</div>
			<div class="item-wrapper">
				<input class="item" type="text" name="lastname" placeholder="Ваше отчество" value="<?php echo(@$data['lastname']); ?>">
			</div>
			<div class="item-wrapper">
				<button class="item" type="submit" name="issignup">Зарегистрироваться</button>
			</div>
		</form>
	</div>

</body>
</html>