<?php

/**
 * Use FileManager to uplaod a file into files dir.
 */
class FileManager
{

	public static $INVALID_FILE_TYPE = 0;
	public static $FILE_ALREADY_EXIST = 1;
	public static $FAILED_TO_COPY_FILE = 2;
	public static $FAILED_TO_DELETE_FILE = 3;
	public static $NO_FILE_EXISTS = 4;

	private static $BASE_PATH = "files/";

	/**
	 * @param fileObject file request returned from the input method.
	 * get your file object like this : $_FILES["idOfFileTypeInput"]
	 *
	 * @return response from copying the file
	 */
	function uploadAPKFile($fileObject) {

		$target_dir = FileManager::$BASE_PATH;
		$target_file = basename($fileObject["name"]);

		// Get file type/extension
		$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		FileManager::console('file extension : '.$fileType);

		// Get file name excluding extension
		$fileName = substr_replace($target_file, '', -(strlen($fileType) + 1));
		FileManager::console('replace : '.$fileName);

		// Replace all special chars with underscore excluding file extension
		//$target_file = preg_replace("/[^a-zA-Z0-9_]/", '_', $fileName) . '.' . $fileType;

		// make full path of file
		$target_file = $target_dir . $target_file;

		FileManager::console($target_file);

		// Check if file is apk or not
		if($fileType != "apk"){
			return FileManager::sendFailure(FileManager::$INVALID_FILE_TYPE);
		}

		// Check if file already exists
		if (file_exists($target_file)) {
		    return FileManager::sendFailure(FileManager::$FILE_ALREADY_EXIST);
		}

		// Move file
	    if (move_uploaded_file($fileObject["tmp_name"], $target_file)) {
	    	return FileManager::sendSuccess("The file ". basename( $fileObject["name"]). " has been uploaded.");
	    } else {
	    	return FileManager::sendFailure(FileManager::$FAILED_TO_COPY_FILE);
	    }
	
	}


	function deleteFile($fileName){

		if(file_exists(FileManager::$BASE_PATH.$fileName)){
			if(unlink(FileManager::$BASE_PATH.$fileName)){
				return FileManager::sendSuccess("File deleted successfully");
			}else{
				return FileManager::sendFailure(FileManager::$FAILED_TO_DELETE_FILE);
			}
		}else{
			return FileManager::sendFailure(FileManager::$NO_FILE_EXISTS);
		}
	}

	function console($data) {
		$output = $data;

	    // if ( is_array( $output ) )
	    //     $output = implode( ',', $output);

	    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
	}

	private function sendSuccess($successMessage){
		return array(
			'status' => 'success',
			'data' => $successMessage
		);

		die();
	}

	private function sendFailure($errorCode){

		switch ($errorCode) {
			case FileManager::$INVALID_FILE_TYPE:
				$message = "Invalid file type! Only APK files are allowed!!";
				break;
			case FileManager::$FILE_ALREADY_EXIST:
				$message = "Sorry, file already exists.";
				break;
			case FileManager::$FAILED_TO_COPY_FILE:
				$message = "Sorry, there was an error uploading your file.";
				break;
			case FileManager::$FAILED_TO_DELETE_FILE:
				$message = "Failed to delete file.";
				break;
			case FileManager::$NO_FILE_EXISTS:
				$message = "File not found.";
				break;
			default:
				$message = "Failed to upload file";
				break;
		}

		$res = array(
			'status' => "failed",
			'error' => array('errorCode' => $errorCode, 'message' => $message)
		);

		FileManager::console($res['error']['message']);

		return $res;

		die();

	}
	
	private function sendResponse($status, $message) {

		$response = array();
		$response['status'] = $status;

		if($status == "success"){
			$response['data'] = $message;
		}else{
			$response['error']['message'] = $message;
		}

		return $response;
		die();
	}
}

?>