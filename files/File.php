<?php 

	namespace FM\Files;

		use FM\Files\Upload;
		use FM\Files\Download;

	class File extends Manage {

		protected $upload;
		protected $download;

		public function __construct () {
			parent::__construct("file");
			$this->upload = new Upload();
			$this->download = new Download();
		}

		public function upload ($file, $parentFolder = "NULL") {

			// echo $this->userID;

			if ($this->upload->doUpload($file)) {
				$data = $this->upload->getUploadInfo();
				$time = date("Y-m-d");
				$dir  = $data["directory"];
				$name = $data["filename"];
				$folder = $this->db->getData("SELECT * FROM folder WHERE folder_id = $parentFolder AND user_id = {$this->userID}");
				if (count($folder) == 1) {
					$this->db->setData(" INSERT INTO {$this->tableName} 
										(user_id, folder_id, file_name, c_type, dir) 
								     	VALUES ( {$this->userID}, $parentFolder, '$name', '$time', '$dir') ");
				} elseif ($parentFolder == "NULL") {
					$this->db->setData(" INSERT INTO {$this->tableName} 
										(user_id, folder_id, file_name, c_type, dir) 
								     	VALUES ( {$this->userID}, $parentFolder, '$name', '$time', '$dir') ");
				} else {
					echo "Error Upload : Folder Tidak Ditemukan";
				}
			}

		}

		public function rename ($newName, $id) {
			$query = "UPDATE {$this->tableName} 
											 SET file_name = '{$newName}' 
											 WHERE file_id = {$id}
											 AND user_id   = {$this->userID}";
			if ($this->db->setData($query)) {
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}

		public function move ($id, $toFolderID, $type) {
			// $this->db->setData(" UPDATE {$this->tableName} 
			// 					 SET folder_id = {$newFolderID} 
			// 					 WHERE file_id = $id
			// 					 AND user_id   = {$this->userID} ");
			if ($type == 'get') {
				$data = $this->db->getData("SELECT * FROM {$this->tableName} 
										 	WHERE file_id = $id 
											AND user_id = {$this->userID} ");
				// print_r($data);
				if ($data[0]['folder_id'] == ''){
					$getData = $this->db->getData("SELECT * FROM folder 
													WHERE parent_folder_id IS NULL
													AND user_id = {$this->userID} ");
					return $getData;
				} else {
					$getData = $this->db->getData("SELECT * FROM folder 
													WHERE parent_folder_id = {$data[0]['folder_id']}
													AND user_id = {$this->userID} ");
					return $getData;
				}
			} else {
				$query = "UPDATE {$this->tableName} 
									 SET folder_id   = {$toFolderID} 
									 WHERE file_id = {$id}
									 AND user_id     = {$this->userID}";
				if ($this->db->setData($query)) {
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				}
			}
		}

		public function delete ($id) {
			$query = " DELETE FROM {$this->tableName} 
					   WHERE file_id = $id 
					   AND user_id   = {$this->userID} ";

			if ($this->db->setData($query)) {
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}

		public function detail ($id) {
			return $this->db->getData(" SELECT * FROM {$this->tableName} 
									    WHERE file_id = $id 
									    AND user_id   = {$this->userID} ");			
		}

		public function sharing ($toUserMail,$fileID,$type) {
			if ($type == 'get') {
				$query1 = "SELECT * FROM sharing 
						   INNER JOIN file 
						   ON sharing.files_id = file.file_id 
						   WHERE sharing.owner_user_id = {$this->userID}";
			    $data['shared'] = $this->db->getData($query1);

			    $query2 = "SELECT * FROM sharing 
			    		   INNER JOIN file 
			    		   ON sharing.files_id = file.file_id 
			    		   WHERE sharing.shareto_user_id = {$this->userID}";
				$data['sharedtome'] = $this->db->getData($query2);
				return $data;
			} else {
				$data = $this->db->getData(" SELECT user_id FROM user 
										 WHERE user_email = '{$toUserMail}' ");
				if (count($data) == 1) {
					$toUserID = $data[0]['user_id'];
					$this->db->setData(" INSERT INTO sharing (owner_user_id,shareto_user_id,files_id) 
										 VALUES ({$this->userID}, $toUserID, $fileID)");
				} else {
					return "User Tidak Ditemukan";
				}
			}
		}

		public function download ($id) {
			$data = $this->db->getData(" SELECT dir FROM {$this->tableName}
										 WHERE file_id = $id 
										 AND user_id = {$this->userID} ");
			if (count($data) == 1) {
				$dl = $data[0]['dir'];
				$this->download->doDownload($dl);
			}
		}
		
		
	}

?>