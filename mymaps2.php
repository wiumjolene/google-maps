<?php

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// include "dbConnection.php"; // in this file you write the code for creating the connection to your MySQL database.

$mysqli = new mysqli("localhost", "php_user", "123456789", "maps");

/* check connection */
if ($mysqli->connect_errno) {

   echo "Connect failed ".$mysqli->connect_error;

   exit();
}

// Select all the rows in the markers table

$query = "SELECT * FROM markers WHERE 1";
// $result = mysql_query($query);
// $result = mysql_query($query,$con);
$result = $mysqli->query($query);
$mysqli->close();

if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$row['id']);
  $newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", $row['type']);
}

echo $dom->saveXML();
$filePath = 'markers.xml';
$dom->save($filePath); 

?>