<?php 
	namespace FM\Views;

	use FM\Files\Manage;
	use FM\Files\File;
	use FM\Config\Database;

	class View {

		private $Manage;
		private $File;

		public function __construct() {
			$this->Manage = new Manage;
			$this->File = new File;
			$this->Database = new Database;
		}

		public function showFilesAndFolder ($parentFolder = "NULL") {
			$data = $this->Manage->show($parentFolder);
			$folder = $data["folder"];
			$file   = $data["file"];
			$theType = array(
                "text" => ["txt","rtf"],
                "doc" => ["doc","docx","xls","ppt","pptx"],
                "pdf" => ["pdf"],
                "image" => ["jpg","jpeg","png","gif","bmp"],
                "code" => ["js","php","html","css","py","c","r"]
            );
            
			if (count($folder) > 0) {
				echo "  <div class='row' style='width: 100%;clear:both;'>
						<h5 style='padding:0 12px 24px 20px;'>Folder</h5>";
				foreach ($folder as $x) {

					echo "<div class='col-4' style='padding:0 12px 24px 12px;height: 240px;position:relative'>

							<div style='background: #fff;border-radius: 20px; box-shadow: 1px 2px 8px rgba(0,0,0,0.15)'>
								<div style='overflow: hidden;border-radius: 20px;'>
									<div class='thumbs' style='border-bottom: 1px solid #eee;'>
										<a href='?folderid={$x['folder_id']}'>
											<img src='asset/folder-invoices.png' style='width: 100%;height: 112px;object-fit: contain;padding: 18px;padding-bottom: 10px;'>
										</a>
									</div>
									<div class='title' style='padding: 20px;background: #fbfbfb'>
										<p style='font-weight: 500; color: #222; font-size: 17px;margin-bottom: 8px;line-height: 21px;'>
											<a href='?folderid={$x['folder_id']}'>{$x['folder_name']}</a>
										</p>
										<p style='font-weight: 300; color: #7f6c6c; font-size: 14px;line-height: 18px;'></p>
									</div>
									<div class='folderOptions'>
										<a href='javascript:void();'>
											<i class='fa fa-ellipsis-v'></i>
										</a>
											<ul class='folderOptions'>
												<li><a href='#' onclick='rename({$x['folder_id']})'>Rename</a></li>
												<li><a href='managefolder.php?manage=delete&id={$x['folder_id']}'>Delete</a></li>
												<li><a href='javascript:void(0)' data-id='{$x['folder_id']}' class='moveaction'>Move</a></li>
											</ul>
							  		</div>
								</div>
							</div>
							<div class='renameFolderWrap' id='rename-{$x['folder_id']}'>
								<form method='post' action='managefolder.php?manage=rename'>
									<h3>Rename Folder - {$x['folder_name']}</h3>
									<br>
									<div class='row'>
										<div class='col-12'>
											<input type='text' name='newname' placeholder='Nama Folder'>
										</div>
										<div class='col-6'>
											<input type='hidden' name='id' value='{$x['folder_id']}'>
										</div>
										<div class='col-12' style='text-align: right;'>
											<input type='submit' name='submit'>
										</div>
									</div>
								</form> 
								<a href='#' class='closeNewFolderWrap' onclick='closeRename({$x['folder_id']})'><i class='fa fa-window-close'></i></a>
							</div>
						</div>";
						
				}


				echo "</div>";
				
			}

			if (count($file) > 0) {
				echo "<div class='row' style='width: 100%;clear:both'>";
				echo "<h5 style='padding:0 12px 24px 20px;'>File</h5>";
				// print_r($file);
				foreach ($file as $x) {
					echo "<div class='col-4' style='padding:0 12px 24px 12px;height:240px'>
							<div style='background: #fff;border-radius: 20px; box-shadow: 1px 2px 8px rgba(0,0,0,0.15)'>
								<div style='overflow: hidden;border-radius: 20px;'>
									<div class='thumbs' style='border-bottom: 1px solid #eee;'>
										<a href='?previewid={$x['file_id']}'>
											<img src='asset/file.png' style='width: 100%;height: 112px;object-fit: contain;padding: 18px;padding-bottom: 10px;'>
										</a>
									</div>
									<div class='title' style='padding: 20px;background: #fbfbfb'>
										<p style='font-weight: 500; color: #222; font-size: 17px;margin-bottom: 8px;line-height: 21px;'>{$x['file_name']}</p>
										<p style='font-weight: 300; color: #7f6c6c; font-size: 14px;line-height: 18px;'></p>
									</div>
								</div>
								<div class='fileOptions'>
									<a href='javascript:void();'>
										<i class='fa fa-ellipsis-v'></i>
									</a>
										<ul class='fileOptions'>
											<li>
												<a href='#' onclick='renameFile({$x['file_id']})'>Rename</a>
											</li>
											<li>
												<a href='managefile.php?manage=delete&id={$x['file_id']}'>Delete</a>
											</li>
											<li>
												<a href='javascript:void(0)' data-id='{$x['file_id']}' class='movefileaction'>Move</a>
											</li>
											<li>
												<a href='javascript:void(0)' class='moveaction'>Details</a>
											</li>
											<li>
												<a href='javascript:void(0)' data-id='{$x['file_id']}' class='sharingFiles'>Sharing</a>
											</li>
											<li>
												<a href='download.php?id={$x['file_id']}'>Download</a>
											</li>
										</ul>
						  		</div>
							</div>
							<div class='renameFileWrap' id='fileRename-{$x['file_id']}'>
								<form method='post' action='managefile.php?manage=rename'>
									<h3>Rename File - {$x['file_name']}</h3>
									<br>
									<div class='row'>
										<div class='col-12'>
											<input type='text' name='newname' placeholder='Nama Folder'>
										</div>
										<div class='col-6'>
											<input type='hidden' name='id' value='{$x['file_id']}'>
										</div>
										<div class='col-12' style='text-align: right;'>
											<input type='submit' name='submit'>
										</div>
									</div>
								</form> 
								<a href='#' class='closeNewFolderWrap' onclick='closeRenameFile({$x['folder_id']})'><i class='fa fa-window-close'></i></a>
							</div>

						</div>";

				}
				echo "</div>";
			}
		}


		public function previewFile ($id) {
			$data = $this->File->detail($id);
			// print_r($data);
			if (count($data) == 1) {
				echo "<div class='row'>
						<div class='col-12' style='padding:24px;'>
							<div style='overflow:hidden;padding:20px;background: #fff;border-radius: 20px; box-shadow: 1px 2px 8px rgba(0,0,0,0.15)'>
							<h5 style='margin-bottom: 20px;'>Preview : {$data[0]['file_name']}</h5>";
						 show_source($data[0]['dir']);
				echo "<a href='download.php?id={$id}' style='background: #4f61ca;border: none;font-size: 18px;color: #fff;padding: 3px 15px;display: inline-block;border-radius: 30px;margin-top:20px;float:right'>Download</a></div></div></div>";
			}
		}

		public function search ($keyword) {
			$data = $this->File->search($keyword);
			$folder = $data["folder"];
			$file   = $data["file"];
			if (count($folder) > 0) {
				echo "  <div class='row' style='width: 100%;clear:both'>
						<h5 style='padding:0 12px 24px 20px;'>Folder</h5>";
				foreach ($folder as $x) {
					echo "<div class='col-4' style='padding:0 12px 24px 12px;height: 240px'>
							<div style='background: #fff;border-radius: 20px; box-shadow: 1px 2px 8px rgba(0,0,0,0.15)'>
								<div style='overflow: hidden;border-radius: 20px;'>
									<div class='thumbs' style='border-bottom: 1px solid #eee;'>
										<a href='?folderid={$x['folder_id']}'>
											<img src='asset/folder-invoices.png' style='width: 100%;height: 112px;object-fit: contain;padding: 18px;padding-bottom: 10px;'>
										</a>
									</div>
									<div class='title' style='padding: 20px;background: #fbfbfb'>
										<p style='font-weight: 500; color: #222; font-size: 17px;margin-bottom: 8px;line-height: 21px;'>{$x['folder_name']}</p>
										<p style='font-weight: 300; color: #7f6c6c; font-size: 14px;line-height: 18px;'></p>
									</div>
								</div>
							</div>
						</div>";
				}
				echo "</div>";
				
			}
			if (count($file) > 0) {
				echo "<div class='row' style='width: 100%;clear:both'>";
				echo "<h5 style='padding:0 12px 24px 20px;'>File</h5>";
				foreach ($file as $x) {
					// echo "<div class='col'>
					// 		<div>
					// 			<img src='http://localhost/phpmyadmin/themes/pmahomme/img/logo_left.png'/>
					// 		</div>
					// 		<div>
					// 			{$x['file_name']}
					// 		</div>
					// 		<div>
					// 			<ul>
					// 				<li>
					// 					<a href='?previewid={$x['file_id']}'>Preview</a>
					// 				</li>
					// 				<li>
					// 					<a href='?delfile={$x['file_id']}'>Hapus</a>
					// 				</li>
					// 			</ul>
					// 		</div>
					// 	  </div>";
					echo "<div class='col-4' style='padding:0 12px 24px 12px;height:240px'>
							<div style='background: #fff;border-radius: 20px; box-shadow: 1px 2px 8px rgba(0,0,0,0.15)'>
								<div style='overflow: hidden;border-radius: 20px;'>
									<div class='thumbs' style='border-bottom: 1px solid #eee;'>
										<a href='?previewid={$x['file_id']}'>
											<img src='asset/file.png' style='width: 100%;height: 112px;object-fit: contain;padding: 18px;padding-bottom: 10px;'>
										</a>
									</div>
									<div class='title' style='padding: 20px;background: #fbfbfb'>
										<p style='font-weight: 500; color: #222; font-size: 17px;margin-bottom: 8px;line-height: 21px;'>{$x['file_name']}</p>
										<p style='font-weight: 300; color: #7f6c6c; font-size: 14px;line-height: 18px;'></p>
									</div>
								</div>
							</div>
						</div>";
				}
				echo "</div>";
			}
		}

		public function sharing() {
			$data = $this->File->sharing('','','get');
			$share = $data["shared"];
			// print_r($share);
			$sharetome  = $data["sharedtome"];
			if (count($share) > 0) {
				echo "<div class='row' style='width: 100%;clear:both'>";
				echo "<h5 style='padding:0 12px 24px 20px;'>Shared Files</h5>";
				foreach ($share as $x) {
					echo "<div class='col-4' style='padding:0 12px 24px 12px;height:240px'>
							<div style='background: #fff;border-radius: 20px; box-shadow: 1px 2px 8px rgba(0,0,0,0.15)'>
								<div style='overflow: hidden;border-radius: 20px;'>
									<div class='thumbs' style='border-bottom: 1px solid #eee;'>
										<a href='?previewid={$x['file_id']}'>
											<img src='asset/file.png' style='width: 100%;height: 112px;object-fit: contain;padding: 18px;padding-bottom: 10px;'>
										</a>
									</div>
									<div class='title' style='padding: 20px;background: #fbfbfb'>
										<p style='font-weight: 500; color: #222; font-size: 17px;margin-bottom: 8px;line-height: 21px;'>{$x['file_name']}</p>
										<p style='font-weight: 300; color: #7f6c6c; font-size: 14px;line-height: 18px;'></p>
									</div>
								</div>
							</div>
						</div>";
				}
				echo "</div>";
			}

			if (count($sharetome) > 0) {
				echo "<div class='row' style='width: 100%;clear:both'>";
				echo "<h5 style='padding:0 12px 24px 20px;'>Shared With Me</h5>";
				foreach ($sharetome as $x) {
					echo "<div class='col-4' style='padding:0 12px 24px 12px;height:240px'>
							<div style='background: #fff;border-radius: 20px; box-shadow: 1px 2px 8px rgba(0,0,0,0.15)'>
								<div style='overflow: hidden;border-radius: 20px;'>
									<div class='thumbs' style='border-bottom: 1px solid #eee;'>
										<a href='?previewid={$x['file_id']}'>
											<img src='asset/file.png' style='width: 100%;height: 112px;object-fit: contain;padding: 18px;padding-bottom: 10px;'>
										</a>
									</div>
									<div class='title' style='padding: 20px;background: #fbfbfb'>
										<p style='font-weight: 500; color: #222; font-size: 17px;margin-bottom: 8px;line-height: 21px;'>{$x['file_name']}</p>
										<p style='font-weight: 300; color: #7f6c6c; font-size: 14px;line-height: 18px;'></p>
									</div>
								</div>
							</div>
						</div>";
				}
				echo "</div>";
			}
		}

	}
?>
