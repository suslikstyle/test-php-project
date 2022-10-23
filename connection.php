<?php
class DBConnection {

	private static $instance;
	protected $db_conn;

	private function __construct($sql_base, $sql_host, $sql_user, $sql_pswd){		
		$this->db_conn = new mysqli($sql_host, $sql_user, $sql_pswd, $sql_base);
		$this->db_conn->set_charset("utf8");
		if (!mysqli_connect_errno()){
			is_null(self::$instance);
		}

	}

	public static function getInstance($sql_base, $sql_host, $sql_user, $sql_pswd){
		if( is_null(self::$instance) ){
			self::$instance = new DBConnection($sql_base, $sql_host, $sql_user, $sql_pswd);	
		}
		return self::$instance;
	}

	public function query($sql) {
		if(!$this->db_conn) return 0;
		return $this->db_conn->query($sql);
	}

	public function register($user, $email, $pass, $name, $surname, $lastname){
		if(!$this->db_conn) return 0;
		return $this->db_conn->query("INSERT INTO `users`(`email`, `login`, `password`, `name`, `surname`, `lastname`) VALUES ('$email', '$user', '$pass', '$name', '$surname', '$lastname')");
	}

	public function check_login($login){
		if(!$this->db_conn) return 0;
		if (0 == mysqli_num_rows($this->db_conn->query("SELECT `id` FROM `users` WHERE `login` = '".$login."'"))){
			return 0;
		}
		return 1;
	}

	public function check_email($email){
		if(!$this->db_conn) return 0;
		if (0 == mysqli_num_rows($this->db_conn->query("SELECT `id` FROM `users` WHERE `email` = '".$email."'"))){
			return 0;
		}
		return 1;
	}
	public function check($login, $email){
		if(!$this->db_conn) return 0;
		if (0 == mysqli_num_rows($this->db_conn->query("SELECT `id` FROM `users` WHERE `email` = '".$email."' or `login` = '".$login."'"))){
			return 0;
		}
		return 1;
	}
	public function get_password_hash($login){
		if(!$this->db_conn) return 0;
		$recs = $this->db_conn->query("SELECT `password` FROM `users` WHERE `login`='".$login."' or `email`='".$login."'")->fetch_assoc();
		if (!empty($recs)){
			return $recs['password'];
		}
		return 0;
	}
	public function get_id($login){
		if(!$this->db_conn) return 0;
		$recs = $this->db_conn->query("SELECT `id` FROM `users` WHERE `login`='".$login."' or `email`='".$login."'")->fetch_assoc();
		if (!empty($recs)){
			return $recs['id'];
		}
		return 0;
	}
	public function get_name_by_id($id){
		// Такое может быть что имени не будет, тогда возвращаем логин.
		if(!$this->db_conn) return '';
		$recs = $this->db_conn->query("SELECT `login`, `name` FROM `users` WHERE `id`='".$id."'")->fetch_assoc();
		if (!empty($recs)){
			if (empty($recs['name']) || $recs['name'] == '') return $recs['login'];
			return $recs['name'];
		}
		return '#username';
	}

	public function new_name_by_id($id, $name, $surname, $lastame){
		if(!$this->db_conn) return 0;
		return $this->db_conn->query("UPDATE `users` SET `name`='".$name."',`surname`='".$surname."',`lastname`='".$lastame."' WHERE `id`=".$id);
	}



	public function getID(){
		if(!$this->db_conn) return 0;
		return $this->db_conn->insert_id;
	}
};
?>