<?php 

	namespace FM\Files;

	class Folder extends Manage {
		public function __construct () {
			parent::__construct("folder");
		}

		public function create ($folderName ="Untitled", $parentFolder = "NULL") {
			$query = " INSERT INTO {$this->tableName}
					   (user_id, parent_folder_id, folder_name) 
						VALUES ( {$this->userID}, $parentFolder, '{$folderName}')";
			if ($this->db->setData($query)) {
				header('Location: ' . $_SERVER['HTTP_REFERER']);
				return true;
			}
		}

		public function rename ($id, $newName) {
			$query = "UPDATE {$this->tableName}
					  SET folder_name = '{$newName}'
					  WHERE folder_id = $id
					  AND user_id     = {$this->userID}";
			if ($this->db->setData($query)) {
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}

		public function move ($id, $toFolderID, $type) {
			if ($type == 'get') {
				$data = $this->db->getData("SELECT * FROM {$this->tableName} 
											WHERE folder_id = $id 
											AND user_id = {$this->userID} ");
				// print_r($data);
				if ($data[0]['parent_folder_id'] == ''){
					$getData = $this->db->getData("SELECT * FROM {$this->tableName} 
													WHERE parent_folder_id IS NULL
													AND folder_id NOT IN ({$id})
													AND user_id = {$this->userID} ");
					return $getData;
				} else {
					$getData = $this->db->getData("SELECT * FROM {$this->tableName} 
													WHERE folder_id NOT IN ($id)
													AND parent_folder_id = {$data[0]['parent_folder_id']}
													AND user_id = {$this->userID} ");
					return $getData;
				}
			} else {
				$query = "UPDATE {$this->tableName} 
									 SET parent_folder_id   = {$toFolderID} 
									 WHERE folder_id = {$id}
									 AND user_id     = {$this->userID}";
				if ($this->db->setData($query)) {
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				}
			}


		}

		public function delete ($id) {
			$query = " DELETE FROM {$this->tableName} 
					   WHERE folder_id = $id 
					   AND user_id     = {$this->userID}";
			if ($this->db->setData($query)) {
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}

	}

?>