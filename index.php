<?php

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
      	$collectionItemHref->value = 'files/'.$entry;
      	$collectionItem->appendChild($collectionItemHref);

      	$collectionItem->appendChild($dom->createAttribute('download'));

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

      <title>TBG Builds</title>

      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <link type="text/css" rel="stylesheet" href="css/styles.css" />

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
    <h4 class="title">APK Builds</h4>

    <div id="list-container">
        <?php echo $dom->saveHTML();?>
    </div>

  <div class="fixed-action-btn">
    <a class="btn-floating btn-large red" href="upload.php">
      <i class="large material-icons">file_upload</i>
    </a>
  </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    </body>
  </html>


