<?php
echo "<link rel='stylesheet' href='style.css'>";
require_once "Database.php"; // Nodrošina, ka fails tiek ielādēts tikai vienreiz

$config = require("config.php");
$db = new Database($config["database"]);

// Iegūst visus dāvanu nosaukumus
$gifts = $db->query("SELECT name FROM gifts")->fetchAll(PDO::FETCH_COLUMN);

// Iegūst visus bērnus un viņu vēstules
$kids = $db->query("SELECT * FROM children")->fetchAll();
$letters = $db->query("SELECT * FROM letters")->fetchAll();

foreach ($kids as $kid) {
    foreach ($letters as $letter) {
        if ($letter["sender_id"] == $kid["id"]) {
            $letterText = $letter["letter_text"];
            $highlightedText = $letterText; // Oriģinālais vēstules teksts
            $wishes = []; // Saglabā bērna vēlmes
            
            // Iet cauri visām dāvanām un izceļ tās vēstules tekstā
            foreach ($gifts as $gift) {
                // Pārbauda, vai dāvana ir vēstules tekstā
                if (stripos($letterText, $gift) !== false) {
                    // Pievieno dāvanu vēlmju sarakstam
                    $wishes[] = $gift;
                    
                    // Iezīmē dāvanu bold formātā (aizstājot tekstu ar <b>...</b>)
                    $highlightedText = preg_replace(
                        '/\b' . preg_quote($gift, '/') . '\b/i',
                        '<b class="highlighted-gift">' . htmlspecialchars($gift) . '</b>',
                        $highlightedText
                    );
                }
            }

            // Izvadam bērna datus un vēstuli ar izceltām dāvanām
            echo "<div class='card'>";
            echo "<h3>" . htmlspecialchars($kid["firstname"]) . " " . htmlspecialchars($kid["middlename"]) . " " . htmlspecialchars($kid["surname"]) . "</h3>";
            echo "<p>Age: " . htmlspecialchars($kid["age"]) . "</p>";
            echo "<p class='highlight-text'>" . nl2br($highlightedText) . "</p>";
            
            // Izvadam vēlmju sarakstu, ja tāds ir
            if (!empty($wishes)) {
                echo "<h4>Vēlmju saraksts:</h4>";
                echo "<ul>";
                foreach ($wishes as $wish) {
                    echo "<li>" . htmlspecialchars($wish) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p><i>Nav atrastas vēlmes.</i></p>";
            }

            echo "</div>";
        }
    }
}
?>
