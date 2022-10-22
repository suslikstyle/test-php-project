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
		<form action="/test-php-project/signin.php" method="POST">
			<div class="item-wrapper">
				<input class="item" type="text" name="login" placeholder="Введите ваш логин" value="<?php echo @$data['login'] ?>">
			</div>
			<div class="item-wrapper">
				<input class="item" type="password" name="pass" placeholder="Введите пароль" value="<?php echo @$data['pass'] ?>">
			</div>
			<div class="item-wrapper">
				<button class="item" type="submit" name="is_signin">Войти</button>
			</div>
		</form>

		<div class="user-msg">
			<?php
				$data = $_POST;
				if (isset($data['is_signin'])){
					$err = array();
					if ('' == $data['login']){
						$err[] = "Введите логин";
					}elseif ($db->check_login($data['login'])){
						$hash = $db->get_password_hash($data['login']);
						if (password_verify($data['pass'], $hash)){			
							$userid = $db->get_id($data['login']);
							if ($userid > 0){
								$_SESSION['logged_user'] = $userid;
								print('<span class="info-msg">Приветствуем Вас '.$db->get_name_by_id($userid).'</span>');
								print('<a id="go-main" href="/test-php-project/">на главную</a>');
								print('<script type="text/javascript">setTimeout(()=>{document.getElementById("go-main").click()},3000)</script>');
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
				}
			?>
		</div>
	</div>
		
</body>
</html>
