<?php 

	namespace FM\Config;

		use FM\Config\Database;

	class Session {

		protected $db;

		public function __construct () {

			// session_start();
			$this->db = new Database();
		
		}

		public function setSession ($data = "") {

			if (empty($_SESSION) && !empty($data)) {
				$_SESSION["USERID"] = $data[0]["user_id"];
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}

		}

		public function getSession () {

			$session = array();
			foreach ($_SESSION as $key => $value) {
				$session[$key] = $value;
			}
			return $session;

		}

		public function destroySession () {

			session_destroy();
			
		}

		public function login ($email, $password) {
			$data = $this->db->getData("SELECT user_id 
										FROM user 
										WHERE user_email = '{$email}'
										AND password = '{$password}'");
			if (count($data) == 1) {
				$this->setSession($data);
			}
		}

		public function logout () {

			$this->destroySession();

		}

	}

?>