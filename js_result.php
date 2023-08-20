<?php
if(isset($_GET['jsonData'])) {
  // get and decode submitted JSON data with a little safety check
  $jsonData = json_decode($_GET['jsonData']), true);
  echo "<h2>Submitted JSON Data</h2>";
  echo "<ul>";
  foreach ($jsonData as $key => $data) {
    echo "<li>$data</li>";
  }
  echo "</ul>";
  echo ($key + 1)." rows received.";
}
?>
