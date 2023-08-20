<?php
if(isset($_GET['jsonData'])) {
  // get and decode submitted JSON data with proper safety checks
  $jsonData = json_decode($_GET['jsonData'], true);

  if ($jsonData !== null) {
    echo "<h2>Submitted JSON Data</h2>";
    echo "<ul>";
    foreach ($jsonData as $data) {
      echo "<li>" . htmlspecialchars($data) . "</li>";
    }
    echo "</ul>";
    echo count($jsonData) . " rows received.";
  } else {
    echo "<h2>Error</h2>";
    echo "Invalid JSON data received.";
  }
} else {
  echo "<h2>Error</h2>";
  echo "No JSON data received.";
}
?>
