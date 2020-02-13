<?php 
	
	namespace FM\Config;
	
	class Database {

		private $host;
		private $user;
		private $pass;
		private $db;

		public function __construct() {
			$this->host = "localhost";
			$this->user = "root";
			$this->pass = "";
			$this->db 	= "cloudlite";
		}

		public function connectDB () {
			if ($conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db)) {
				return $conn;
			}
		}

		public function setData ($query) {
			$con   = $this->connectDB();
			// $res   = mysqli_query($con,$query) or die("ERROR : " . mysqli_error($con));
			if (mysqli_query($con,$query)) {
				return true;
			} else {
				return false;
			}
		}

		public function getData ($query) {
			$data  = array();
			$con   = $this->connectDB();
			$res   = mysqli_query($con,$query) or die("ERROR : " . mysqli_error($con));
			while ($result = mysqli_fetch_assoc($res)) {
				$data[] = $result;
			}
			return $data;
		}
		
	}

?>
