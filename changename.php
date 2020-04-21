<?php
	require_once ".conf.php";
	require_once "connection.php";
	$db = DBConnection::getInstance($sql_base, $sql_host, $sql_user, $sql_pswd);

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
					print('<span style="color: #4f4;">Успешно! <a href="/test/">на главную</a></span><br>');
				}
			}
		}
	}
?>
<form action="/test/changename.php" method="POST">
	<p>
		<!-- <span><strong>Логин</strong>:</span> -->
		<input type="text" name="name" placeholder="Введите новое имя" value="<?php echo(@$data['name']); ?>"><span>*</span>
	</p>
	<p>
		<!-- <span><strong>e-mail</strong>:</span> -->
		<input type="text" name="surname" placeholder="Введите новую фамилию" value="<?php echo(@$data['surname']); ?>"><span>*</span>
	</p>
	<p>
		<!-- <span><strong>Пароль</strong>:</span> -->
		<input type="text" name="lastname" placeholder="Введите новое отчество"><span>*</span>
	</p>
	<p>
		<button type="submit" name="change">изменить</button>
	</p>
</form>