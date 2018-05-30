<?php 
require 'models/FileManager.php';

if(isset($_GET['name'])){

	$res = FileManager::deleteFile($_GET['name']);

	// Show response to user
    if($res['status'] == "success"){
        echo $res['data'];
    }else{
        echo $res['error']['message'];
    }

}


$dom = new DOMDocument('1.0');

$collection = $dom->createElement('div');
$collectionClass = $dom->createAttribute('class');
$collectionClass->value = 'collection';
$collection->appendChild($collectionClass);

if ($handle = opendir('files')) {

    while (false !== ($entry = readdir($handle))) {
      
    	if ($entry != "." && $entry != "..") {

      	$collectionItem = $dom->createElement('a', $entry);
      	$collectionItemHref = $dom->createAttribute('href');
      	$collectionItemHref->value = "delete.php?name=".$entry;
      	$collectionItem->appendChild($collectionItemHref);

      	$collectionItemClass = $dom->createAttribute('class');
      	$collectionItemClass->value = 'collection-item';

      	$collectionItem->appendChild($collectionItemClass);

      	$collection->appendChild($collectionItem);

      }
    }

    closedir($handle);

    $dom->appendChild($collection);   
}


?>

 <!DOCTYPE html>
  <html>
    <head>

      <title>Delete TBG Builds</title>

      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <link type="text/css" rel="stylesheet" href="css/styles.css" />

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
    <h4 class="title">Tap to Delete TBG APK Builds</h4>

    <div id="list-container">
        <?php 
	        if($dom){ 
	        	echo $dom->saveHTML(); 
	        } 
        ?>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    </body>
  </html>


