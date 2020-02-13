<?php 
	
	namespace FM\Files;

	class Upload {

		private $PERMISSION = 0777;

		protected $uploadInfo = array();

		public function doUpload ($file) {

			$result = false;
			
			$Storage = "storage";
			$UFolder = $_SESSION["USERID"];
			$Dinamic = date("d-m-y");	
			$FullDir = $Storage . "/" . $UFolder . "/" . $Dinamic;

			if (!file_exists( $Storage )) {
				mkdir( $Storage, $this->PERMISSION, true );
			}

			if (!file_exists( $Storage . "/" . $UFolder)) {
				mkdir( $Storage . "/" . $UFolder, $this->PERMISSION, true );
			}

			if (!file_exists( $FullDir )) {
				mkdir( $FullDir, $this->PERMISSION, true );
			}

			if (!is_dir($FullDir)) {
				echo("Upload Gagal");
			} elseif (empty($file)) {
				echo "File Belum Ada";
			} else {
				if (move_uploaded_file( $file["tmp_name"], $FullDir . "/" . $file["name"] )) {
					$result = true;
					$directory = $FullDir . "/" . $file["name"];
					$this->uploadInfo = array(
						"directory" => $directory,
						"filename"  => $file['name'],
						"size"		=> $file['size']
					);

				}
			}

			return $result;

		}

		public function getUploadInfo () {
			return $this->uploadInfo;
		}

	}

?>