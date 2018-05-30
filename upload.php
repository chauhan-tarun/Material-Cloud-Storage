<?php require 'models/FileManager.php';
  
  if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Upload the apk file using File Manager
    $res = FileManager::uploadAPKFile($_FILES["fileToUpload"]);
    FileManager::console(json_encode($res));

    // Show response to user
    if($res['status'] == "success"){
        echo $res['data'];
    }else{

        if($res['error']['errorCode'] == FileManager::$FILE_ALREADY_EXIST){

            // todo: add replace(or rename) dialog

        }

        echo $res['error']['message'];
    }

  }

?>

<!DOCTYPE html>
<html>
<!-- disallow browser cache -->
<meta HTTP-EQUIV="Pragma" content="no-cache">
<meta HTTP-EQUIV="Expires" content="-1" >
<head>
	<title>Upload Build</title>

	  <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <link type="text/css" rel="stylesheet" href="css/styles.css" />

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>

	<form id="upload-form" action="" method="post" enctype="multipart/form-data">
	    <h4 class="title">Select apk to upload:</h4>
	    <input type="file" name="fileToUpload" id="fileToUpload" class="browse-style">
	    <a onclick="document.getElementById('upload-form').submit();" class="waves-effect waves-light btn upload-btn">Upload</a>
	</form>


    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>

</body>
</html>