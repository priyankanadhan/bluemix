<?php
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\Regex as RegexValidator;
use Phalcon\Validation\Validator\StringLength as StringLength;
class AttachController extends ControllerBase {
	public function FileUploadAction() {
		$fileName = $_FILES ['file'] ['name'];
		$string = $fileName [0];
		$size = $_FILES ['file'] ['size'];
		$name = $fileName;
		$type = $_FILES ['file'] ['type'];
                $date=date('Y:M:D');
         
		$path = "/var/www/html/upload/$date/$string/";
               $pathValue="/upload/$date/$string";
		if (is_dir ( $path )) {
		if (move_uploaded_file ( $_FILES ['file'] ['tmp_name'], $path . $_FILES ['file'] ['name'] )) {
               $attach = new Attach ();
                $attach->id= $this->id->getId ( "normal" );
		$attach->name = $name;
		$attach->size = $size;
		$attach->path =$pathValue;
		$attach->ref_id = "";
       	        $attach->created=date('Y:M:D');
		$attach->mime = $type;
		$attach->originalPath=$path;
                 $attach->save();
        $fileId=$attach->id;	
        $resultName=$attach->name;
				
				return $this->response->setJsonContent ( array (
                                        
						"success" => "true",
                        "file_id"=>$fileId,
                        "file_name"=>$resultName,
						"result" => "file uploaded successfully" 

				) );
			} else {
				return $this->response->setJsonContent ( array (
						"success" => "false",
						"result" => "file is unable to upload" 
				) );
			}
		} else {
			
		mkdir ( $path, 0777, true );
        	$attach = new Attach ();
        	$attach->id= $this->id->getId ( "normal" );
		$attach->name = $name;
		$attach->size = $size;
		$attach->path = $pathValue;
		$attach->ref_id = "";
        	$attach->created=date('Y:M:D');
		$attach->mime = $type;
		$attach->originalPath=$path;
        	$attach->save();
        	$fileId=$attach->id;
		$resultName=$attach->name;
			
			if (move_uploaded_file ( $_FILES ['file'] ['tmp_name'], $path . $_FILES ['file'] ['name'] )) {
				return $this->response->setJsonContent ( array (
                                        
						"success" => "true",
                                                "file_id"=>$fileId,
                                                "file_name"=>$resultName,
						"result" => "file uploaded successfully" 

				) );
			} else {
				return $this->response->setJsonContent ( array (
						"success" => "false",
						"result" => "file is unable to upload" 
				) );
			}
		}
		
		
		
		// Check if it was successfull
	}
	/**
	 * see the all files*
	 */
	public function seeAllFilesAction() {
		$attach = Attach::findByref_id ( 1 );
		foreach ( $attach as $value ) {
			$uploadedFiles [] = array (
					"file_name" => $value->name,
					"file_size" => $value->size,
					"path" => $value->path,
					"created_at" => $value->created 
			);
		}
		print_r ( $uploadedFiles );
	}
	
	/**
	 * download the file by id*
	 */
	public function downloadAction() {
		$id=$_REQUEST['id'];

		$attach = Attach::findFirstByid ( $id );
		if ($attach) {
			
			$path = $attach->originalPath;
			$name = $attach->name;
			$size = $attach->size;
			
			$file = $path . $name;
			
			if (file_exists ( $file )) {
				// Print headers
				 header('Content-Description: File Transfer');
				header('Content-Type:'.$attach->mime);
				header ( 'Content-Disposition: attachment; filename=' . basename ( $file ) );
                                header('Expires: 0');
                                header('Cache-Control: must-revalidate');
                                header('Pragma: public');
				header ( 'Content-Length: ' . filesize ( $file ) );
                                header("Content-Transfer-Encoding: binary");
                                header('Accept-Ranges: bytes');
				readfile ( $file );
				exit ();
			}
		} else {
			echo 'Error! No image exists with that ID.';
		}
		
		// Free the mysqli resources
	}
	
	
	public function deleteFileAction(){
		$restService = json_decode ( file_get_contents ( 'php://input' ), true );
	$file_id=$restService['file_id'];
	$attach=Attach::findFirstByid($file_id);
	$dir=$attach->originalPath;
    $data=$attach->name;
  
               if(unlink($dir."/".$data)&&($attach->delete()))
               {   
               	return $this->response->setJsonContent ( array (
               			"success" => "true",
               			"result" => "file deleted successfully"
               	) );
               }
               else{
               	return $this->response->setJsonContent ( array (
               			"success" => "false",
               			"result" => "unable to delete"
               	) );
               }
       

		 
	}
}
?>
