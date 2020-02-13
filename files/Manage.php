<?php 

	namespace FM\Files;

		use FM\Config\Database;
		use FM\Config\Session;

	class Manage {

		protected $db;
		public $session;
		protected $userID;
		protected $tableName;

		public function __construct ($tableName = '') {
			$this->db = new Database();
			$this->session = new Session();
			$this->userID = $this->session->getSession()['USERID'];
			$this->tableName = $tableName;
		}

		public function show ($parentFolder = "NULL") {
			if ($parentFolder == "NULL") {
				$data["folder"] = $this->db->getData(" SELECT * FROM folder
												   	   WHERE user_id = {$this->userID} 
												       AND parent_folder_id IS NULL 
												       ORDER BY folder_id DESC ");

				$data["file"] = $this->db->getData(" SELECT * FROM file
													 WHERE user_id = {$this->userID} 
													 AND folder_id IS NULL 
													 ORDER BY file_id DESC ");
			} else {
				$data["folder"] = $this->db->getData(" SELECT * FROM folder
												   	   WHERE user_id = {$this->userID} 
												       AND parent_folder_id = $parentFolder 
												   	   ORDER BY folder_id DESC ");

				$data["file"] = $this->db->getData(" SELECT * FROM file
													 WHERE user_id = {$this->userID} 
													 AND folder_id = $parentFolder 
													 ORDER BY folder_id DESC ");
			}

			return $data;
		}

		public function search ($keyword) {
			$data["folder"] = $this->db->getData(" SELECT * FROM folder
												   WHERE user_id = {$this->userID}
												   AND folder_name LIKE '%{$keyword}%' ");

			$data["file"] = $this->db->getData(" SELECT * FROM file
												 WHERE user_id = {$this->userID}
												 AND file_name LIKE '%{$keyword}%' ");

			return $data;
		}

	}

?>