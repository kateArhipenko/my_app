<?php 
	/**
	* 
	*/
	class AuthService
	{

		private $login;
		private $password;
		private $hash;
		
		function __construct()
		{
			$host = '127.0.0.1';
	        $db   = 'myapp';
	        $user = 'root';
	        $pass = '';
	        $charset = 'utf8';
	        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	        $opt = [
	            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	            PDO::ATTR_EMULATE_PREPARES   => false,
	        ];
        	$this->db = new PDO($dsn, $user, $pass, $opt);


			// $this->login = $login;
			// $this->password = $password;
			// $this->confirm_password = $confirm_password;
		}

		public function login($login, $password) {
			$password = md5(md5($password));

			$query = "SELECT count(*) FROM users WHERE login='$login' AND pass='$password'";
			$result = $this->db->query($query);

			if ($result->fetch()["count(*)"] == 0) {
				return "error: user not found";
			}

			$hash = $this->generate_hash();

			$query = "UPDATE users SET hash='$hash' WHERE login='$login'";
			$this->db->query($query);

			return $hash;
		}

		public function check_authorize($hash) {
			$query = "SELECT count(*) FROM users WHERE hash='$hash'";

			$result = $this->db->query($query);
			return $result->fetch()["count(*)"] == 1;
		}

		//remove
		private function check_user() {
			$query = "SELECT count(*) FROM users WHERE login=$this->login";
			$result = $this->db->query($query);
			return $result->fetch() == 1;
		}

		private function md5_password() {
			$this->password =  md5(md5(trim($this->password)));
		}

		private function generate_hash() {
			return md5($this->generate_code());
		}

		private function generate_code($length=6) {
    		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

    		$code = "";

    		$clen = strlen($chars) - 1;  
    		while (strlen($code) < $length) {
            	$code .= $chars[mt_rand(0,$clen)];  
    		}

    		return $code;
		}
	}