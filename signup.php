<?php
	
	require_once ".conf.php";
	require_once "connection.php";
	$db = DBConnection::getInstance($sql_base, $sql_host, $sql_user, $sql_pswd);

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
		// if ($db->check_email($data['email'])) {
		// 	$errors[] = 'Пользователь с таким email уже существует!';
		// }


		if(empty($errors)){
			// register
			$user = $data['login'];
			$email = $data['email'];
			$pass = password_hash($data['pass'], PASSWORD_DEFAULT);
			if ($db->register($user, $email, $pass, $data['name'], $data['surname'], $data['lastname'])){
				print('<span style="color: #4f4;">Вы успешно зарегистрированы как '.$user.'</span><a style="padding: 0 5px 0 10px;text-decoration: none;color: #333;text-shadow: 1px 1px 2px #555;" href="/test/login.php">войти</a><br>');
			} else {
				print('<span style="color: #44f;">Что-то пошло не так. Попробуйте позже. </span><br>');
			}
		} else {
			print('<span style="color: #f44;">'.array_shift($errors).'</span><br>');
		}
	}
?>

<form action="/test/signup.php" method="POST">
	<p>
		<!-- <span><strong>Логин</strong>:</span> -->
		<input type="text" name="login" placeholder="Введите логин" value="<?php echo(@$data['login']); ?>"><span>*</span>
	</p>
	<p>
		<!-- <span><strong>e-mail</strong>:</span> -->
		<input type="email" name="email" placeholder="Ваш e-mail" value="<?php echo(@$data['email']); ?>"><span>*</span>
	</p>
	<p>
		<!-- <span><strong>Пароль</strong>:</span> -->
		<input type="password" name="pass" placeholder="Введите пароль"><span>*</span>
	</p>

	<p>
		<!-- <span><strong>Имя</strong>:</span> -->
		<input type="text" name="name" placeholder="Ваше имя" value="<?php echo(@$data['name']); ?>">
	</p>
	<p>
		<!-- <span><strong>Фамилия</strong>:</span> -->
		<input type="text" name="surname" placeholder="Ваша фамилия" value="<?php echo(@$data['surname']); ?>">
	</p>
	<p>
		<!-- <span><strong>Отчество</strong>:</span> -->
		<input type="text" name="lastname" placeholder="Ваше отчество" value="<?php echo(@$data['lastname']); ?>">
	</p>

	<p>
		<button type="submit" name="issignup">Зарегистрироваться</button>
	</p>
</form>