<?php

// Display the CSS styles
echo "<style>
body { 
    background-color: rgb(206, 157, 157);
    font-family: 'Space Mono', monospace; 
    display: flex;
    flex-direction: column;
    max-width: 420px;
    padding: 32px;
    margin: 60px auto;
    border: 1px solid #eee;
    box-shadow: 0px 12px 24px rgba(0, 0, 0, 0.06);
}

* { 
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-rendering: optimizelegibility;
    letter-spacing: -0.25px;
}

ol { 
    padding-left: 50px;
}

li { 
    color:  rgba(99, 99, 160, 0.7); 
    padding-left: 16px;
    margin-top: 24px;
    position: relative;
    font-size: 16px;
    line-height: 20px;
}

li::before {
    content: '';
    display: block;
    height: 42px;
    width: 42px;
    border-radius: 50%;
    border: 2px solid #ddd;
    position: absolute;
    top: -12px;
    left: -46px;
}

strong { color: #292929; }

ol.alternating-colors { 
    li:nth-child(odd)::before { border-color: #0BAD02; }
    li:nth-child(even)::before { border-color: #2378D5; }
}
</style>";

// Include the database connection file
require "Database.php";

// Load the configuration file
$config = require("config.php");

// Create a new Database object
$db = new Database($config["database"]);

// Query to fetch all gifts from the database
$gifts = $db->query("SELECT * FROM gifts")->fetchAll();

// Display the title for the list
echo "<div>";
echo "<strong>Best Gifts</strong>"; 
echo "<ol class='alternating-colors'>"; 

// Loop through each gift and display its name and count
foreach ($gifts as $gift) {
    // Check if description exists and is not empty, otherwise provide a default message
    $description = isset($gift["description"]) && !empty($gift["description"]) ? htmlspecialchars($gift["description"]) : "No description available";
    
    // Display gift name and available count
    echo "<li>";
    echo "<strong>" . htmlspecialchars($gift["name"]) . "</strong>"; 
    echo " - Pieejami: " . htmlspecialchars($gift["count_available"]);
    echo "</li>";
}

echo "</ol>"; 
echo "</div>";

?>
