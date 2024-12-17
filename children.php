<?php


echo "<link rel='stylesheet ' href='style.css' >";
require "Database.php";

$config = require("config.php");

echo "Hi there  <br><br>";

$db = new Database($config["database"]);

$kids = $db->query("SELECT * FROM children")->fetchAll();
foreach ($kids as $kid) {
    echo "<div class='card'>";
    echo "<h3>" . htmlspecialchars($kid["firstname"]) . " " . htmlspecialchars($kid["middlename"]) . " " . htmlspecialchars($kid["surname"]) . "</h3>";
    echo "<p>Age: " . htmlspecialchars($kid["age"]) . "</p>";
    echo "</div>";
}

echo "</div>";


   


?>