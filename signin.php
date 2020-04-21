<?php
	require_once ".conf.php";
	require_once "connection.php";



	$db = DBConnection::getInstance($sql_base, $sql_host, $sql_user, $sql_pswd);

	$data = $_POST;
	if (isset($data['is_signin'])){
		$err = array();
		if ('' == $data['login']){
			$err[] = "Введите логин";
		}elseif ($db->check_login($data['login'])){
			$hash = $db->get_password_hash($data['login']);
			if (password_verify($data['pass'], $hash)){			
				$userid = $db->get_id($data['login']);
				if ($userid>0){
					$_SESSION['logged_user'] = $userid;
					print('<span style="color: #4f4;">Приветствуем Вас '.$db->get_name_by_id($userid).'</span><br><a href="/test/">на главную</a>');
				} else {
					print('<span style="color: #4f4;">Этого не может быть!</span><br>');
				}
			} else {
				$err[] = "Пароль не верный";
			}
		} else {
			$err[] = "Пользователь с таким логином не найден!";
		}
		// var_dump($err);
		if(!empty($err)){
			print('<span style="color: #f44;">'.array_shift($err).'</span><br>');
		}
	}
?>

<form action="/test/signin.php" method="POST">
	<p>
		<span><strong>Логин</strong>:</span>
		<input type="text" name="login" value="<?php echo @$data['login'] ?>">
	</p>
	<p>
		<span><strong>пароль</strong>:</span>
		<input type="password" name="pass" value="<?php echo @$data['pass'] ?>">
	</p>
	<p>
		<button type="submit" name="is_signin">Войти</button>
	</p>
</form>
<a href="/test/signin.php">создать пользователя</a>