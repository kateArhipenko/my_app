<?php 
	/**
	* base service class 
	*/
	class BaseService
	{
		protected $db;
		protected $table_name;
		
		function __construct() {
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

		public function get_all() {
			$query = "SELECT * FROM $this->table_name";
			$query = $this->db->prepare($query);
		    $query->execute();
		    $result = $query->fetchAll();
		    return $result;
		}

		public function find_by_id($id) {
			$query = "SELECT * FROM $this->table_name WHERE id=$id";
        	$query = $this->db->prepare($query);
    		$query->execute();
    		$result = $query->fetch();
    		return $result;
		}

		public function delete($id) {
			$query = "DELETE FROM $this->table_name WHERE id=$id";
		    $query = $this->db->prepare($query);
		    $result = $query->execute();
		    return $result;
		}

		public function update($id, $params) {
			$query = "UPDATE $this->table_name SET ";
			foreach ($params as $key => $value) {
				$query .= "$key='$value',";
			}
			$query = rtrim($query, ",");
			$query .= " WHERE id=$id";
			$query = $this->db->prepare($query);
    		$query->execute();
    		$result = $query->fetch();
    		return $result;
		}

		public function create($params) {
			$query = "INSERT INTO $this->table_name (";

			foreach ($params as $key => $value) {
				$query .= "$key,";
			}

			$query = rtrim($query, ",");
			$query .= ") VALUES (";

			foreach ($params as $key => $value) {
				$query .= "'$value',";
			}

			$query = rtrim($query, ",");
			$query .= ")";
			$query = $this->db->prepare($query);
    		$query->execute();
    		$result = $query->fetch();
    		return $result;
		}
	}