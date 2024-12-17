<?php
echo "<style>
body{
background-color: #8e809c;
color: #c3c8e3 ;
}
</style>";


require "Database.php";

$config = require("config.php");

echo "Hi there  <br><br>";

$db = new Database($config["database"]);

$kids = $db->query("SELECT * FROM gifts")->fetchAll();
echo"<div>";
echo "<ol>";
foreach($kids as $kid){
    echo"<li>" . $kid["name"] . " ".$kid["count_available"] . " ". "</li>";   
   }
echo "</ol>";
echo"</div>";


   


?>