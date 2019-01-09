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


    <!-- Floating Button -->
    <div class="fixed-action-btn">
      <a class="btn-floating btn-large red">
        <i class="large material-icons">add</i>
      </a>
      <ul>
        <li><a class="btn-floating red" href="upload.php"><i class="material-icons">file_upload</i></a></li>
        <li><a class="btn-floating red" href="delete.php"><i class="material-icons">delete</i></a></li>
      </ul>
    </div>


    <!-- JavaScript to handle the floating button actions -->
    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.fixed-action-btn');
        var instances = M.FloatingActionButton.init(elems, {direction: 'top'});
      });
    </script>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    </body>
  </html>


