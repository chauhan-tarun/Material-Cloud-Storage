<?php

/**
 * Use FileUploader to uplaod a file into files dir.
 */
class FileUploader
{

	public static $INVALID_FILE_TYPE = 0;
	public static $FILE_ALREADY_EXIST = 1;
	public static $FAILED_TO_COPY_FILE = 2;

	/**
	 * @param fileObject file request returned from the input method.
	 * get your file object like this : $_FILES["idOfFileTypeInput"]
	 *
	 * @return response from copying the file
	 */
	function uploadAPKFile($fileObject) {

		$target_dir = "files/";
		$target_file = basename($fileObject["name"]);

		// Get file type/extension
		$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		FileUploader::console('file extension : '.$fileType);

		// Get file name excluding extension
		$fileName = substr_replace($target_file, '', -(strlen($fileType) + 1));
		FileUploader::console('replace : '.$fileName);

		// Replace all special chars with underscore excluding file extension
		$target_file = $target_dir . preg_replace("/[^a-zA-Z0-9_]/", '_', $fileName) . '.' . $fileType;
		FileUploader::console($target_file);

		// Check if file is apk or not
		if($fileType != "apk"){
			return FileUploader::sendFailure(FileUploader::$INVALID_FILE_TYPE);
		}

		// Check if file already exists
		if (file_exists($target_file)) {
		    return FileUploader::sendFailure(FileUploader::$FILE_ALREADY_EXIST);
		}

		// Move file
	    if (move_uploaded_file($fileObject["tmp_name"], $target_file)) {
	    	return FileUploader::sendSuccess("The file ". basename( $fileObject["name"]). " has been uploaded.");
	    } else {
	    	return FileUploader::sendFailure(FileUploader::$FAILED_TO_COPY_FILE);
	    }
	
	}

	function console($data) {
		$output = $data;
	    if ( is_array( $output ) )
	        $output = implode( ',', $output);

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
			case FileUploader::$INVALID_FILE_TYPE:
				$message = "Invalid file type! Only APK files are allowed!!";
				break;
			case FileUploader::$FILE_ALREADY_EXIST:
				$message = "Sorry, file already exists.";
				break;
			case FileUploader::$FAILED_TO_COPY_FILE:
				$message = "Sorry, there was an error uploading your file.";
				break;
			default:
				$message = "Failed to upload file";
				break;
		}

		return array(
			'status' => "failed",
			'error' => array('errorCode' => $errorCode, 'message' => $message)
		);

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