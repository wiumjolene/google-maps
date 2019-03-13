<?php

/** create XML file */ 
$mysqli = new mysqli("localhost", "php_user", "123456789", "maps");

/* check connection */
if ($mysqli->connect_errno) {

   echo "Connect failed ".$mysqli->connect_error;

   exit();
}

$query = "SELECT * FROM maps.markers";

$booksArray = array();

if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {

       array_push($booksArray, $row);
    }
  
    if(count($booksArray)){

         createXMLfile($booksArray);

     }

    /* free result set */
    $result->free();
}

/* close connection */
$mysqli->close();

function createXMLfile($booksArray){
  
   $filePath = 'markers.xml';

   $dom     = new DOMDocument('1.0', 'utf-8'); 

   $root      = $dom->createElement('markers'); 

   for($i=0; $i<count($booksArray); $i++){
     
     $bookId        =  $booksArray[$i]['id'];  

     $bookName = htmlspecialchars($booksArray[$i]['name']);

     $bookAuthor    =  $booksArray[$i]['address']; 

     $bookPrice     =  $booksArray[$i]['lat']; 

     $bookISBN      =  $booksArray[$i]['lng']; 

     $bookCategory  =  $booksArray[$i]['type']; 

     $book = $dom->createElement('marker');

     $book->setAttribute('id', $bookId);

     $name     = $dom->createElement('name', $bookName); 

     $book->appendChild($name); 

     $author   = $dom->createElement('address', $bookAuthor); 

     $book->appendChild($author); 

     $price    = $dom->createElement('lat', $bookPrice); 

     $book->appendChild($price); 

     $isbn     = $dom->createElement('lng', $bookISBN); 

     $book->appendChild($isbn); 
     
     $category = $dom->createElement('type', $bookCategory); 

     $book->appendChild($category);
 
     $root->appendChild($book);

   }

   $dom->appendChild($root); 

   $dom->save($filePath); 

 } 

 ?>