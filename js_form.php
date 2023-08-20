<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>JSON Barcode Form with jQuery - Alerts with Sweet Alert</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Create an array to keep JSON data
  var jsonData = [];

  $(document).ready(function() {
    // when "Submit" button clicked
    $("#sendButton").click(submitForm);

    // submit the collected JSON data to js_result.php
    $("#finishButton").click(function() {
      window.location.href = "js_result.php?jsonData=" + JSON.stringify(jsonData);
    });

    // when "Enter" pressed on keyboard or barcode scanner read event
    $("#barcode").keypress(function(event) {
      if (event.which === 13) {
        event.preventDefault();
        submitForm();
      }
    });
  });

  // show error message with / without sound
  function showError($errorText, $soundAlert) {
      var message = $errorText;
      var soundAlert = $soundAlert;
      Swal.fire({
          position: 'top',
          icon: 'error',
          title: message,
          showConfirmButton: true,
          confirmButtonText: 'Ok',
          confirmButtonColor: '#FF0022',
          timerProgressBar: true,
          timer: 3500
      });
      if(soundAlert == 1){
        playError();
      }
  }

  // show ok message with / without sound
  function showOk($okText, $soundAlert) {
    var message = $okText;
    var soundAlert = $soundAlert;
    if(soundAlert == 1){
      playOk();
    }
    Swal.fire({
        position: 'top',
        icon: 'success',
        title: message,
        showConfirmButton: true,
        confirmButtonText: 'Ok',
        confirmButtonColor: '#008822',
        timerProgressBar: true,
        timer: 3500
    });
  }

  // just play "ok" sound
  function playOk() {
    var audio = new Audio('sound/ok.mp3');
    audio.play();
  };

  // just play "error" sound
  function playError() {
    var audio = new Audio('sound/error.mp3');
    audio.play();
  };

  // onsubmit check function
  function submitForm() {
    var barcodeValue = $("#barcode").val();

    // if empty value
    if(barcodeValue == "" || barcodeValue == null){
      // show error message
      showError('Please read a barcode.',1);
      // clear barcode input box for next entry
      $("#barcode").val("");
      return;
    }

    // check JSON data for repetition
    if (jsonData.includes(barcodeValue)) {
      // show error message for repetition
      showError('You added this barcode before.',1);
      // clear barcode input box content
      $("#barcode").val("");
      return;
    }

    // play "ok sound"
    playOk();
    // add data to JSON
    jsonData.push(barcodeValue);

    // update JSON data and JSON count data
    updateJsonData();
    updateDataCount();

    // clean input box for next entry
    $("#barcode").val("");
  }

  // update JSON count
  function updateDataCount() {
    var dataCount = jsonData.length;
    $("#dataCount").text(dataCount);
  }

  // update JSON data
  function updateJsonData() {
    var jsonContainer = $("#jsonContainer");
    jsonContainer.html(JSON.stringify(jsonData, null, 2));
  }
</script>
</head>
<body>

<h1>JSON Form with jQuery - Sweet Alert - Beep Sounds</h1>
<form>
  <label for="barcode">Barcode:</label>
  <input type="number" id="barcode" name="barcode" autofocus required>
  <button type="button" id="sendButton">Submit</button>
</form>
<div>
  <h2>Submitted Data - <span id="dataCount">0</span> Record(s)</h2>
  <pre id="jsonContainer"></pre>
</div>
<button type="button" id="finishButton">Finish</button>
<p>Click the button above to submit all data to server.</p>
</body>
</html>
