<?php
	/**
	* 
	*/
	class RegService
	{
		private $login;
		private $password;
		private $hash;
		private $confirm_password;

		private $db;
		
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
		}

		public function registration($login, $password, $confirm_password) {
			$this->login = $login;
			$this->password = $password;
			$this->confirm_password = $confirm_password;

			if (!isset($this->login) && !isset($this->password) &&  !isset($this->confirm_password)) {
				return "error: empty login or password";
			}

			if ($this->password != $this->confirm_password) {
				return "error: passwords do not match";
			}

			$this->md5_password();

			if ($this->check_user()) {
				return "error: user exist";
			}

			$this->hash = $this->generate_hash();

			$query = "INSERT INTO users (login, pass, hash) VALUES ('$this->login', '$this->password', '$this->hash')";
			$query = $this->db->query($query);
			return $this->hash;
		}

		private function md5_password() {
			$this->password =  md5(md5(trim($this->password)));
		}

		private function check_user() {
			$query = "SELECT count(*) FROM users WHERE login='$this->login'";
			$result = $this->db->query($query);
		
			return $result->fetch()["count(*)"] == 1;
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