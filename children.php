<?php
echo "<link rel='stylesheet' href='style.css'>";
require "Database.php";

$config = require("config.php");

$db = new Database($config["database"]);

$kids = $db->query("SELECT * FROM children")->fetchAll();
$letters = $db->query("SELECT * FROM letters")->fetchAll();

foreach ($kids as $kid) {
    foreach ($letters as $letter) {
        if ($letter["sender_id"] == $kid["id"]) {
            echo "<div class='card'>";
            echo "<h3>" . htmlspecialchars($kid["firstname"]) . " " . htmlspecialchars($kid["middlename"]) . " " . htmlspecialchars($kid["surname"]) . "</h3>";
            echo "<p>Age: " . htmlspecialchars($kid["age"]) . "</p>";
            echo "<p>Vestule: " . htmlspecialchars($letter["letter_text"]) . "</p>";  
            echo "</div>"; 
        }
    }
}
?>
