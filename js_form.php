<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>JSON Barcode Form with jQuery - Alerts with Sweet Alert</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
    var jsonData = [];
    var $barcode = $("#barcode");
    var $dataCount = $("#dataCount");
    var $jsonContainer = $("#jsonContainer");

    function showMessage(message, type, soundAlert, confirmButtonColor) {
      var icon = (type === 'error') ? 'error' : 'success';

      if (soundAlert === 1) {
        if (type === 'error') {
            playSound('error');
        } else {
            playSound('ok');
        }
      }

      Swal.fire({
          position: 'top',
          icon: icon,
          title: message,
          showConfirmButton: true,
          confirmButtonText: 'Ok',
          confirmButtonColor: confirmButtonColor,
          timerProgressBar: true,
          timer: 3500
      });
    }

    function playSound(soundType) {
      var audio = new Audio('sound/' + soundType + '.mp3');
      audio.play();
    }

    function updateDataCount() {
      var dataCount = jsonData.length;
      $dataCount.text(dataCount);
    }

    function updateJsonData() {
      $jsonContainer.html(JSON.stringify(jsonData, null, 2));
    }

    function submitForm() {
      var barcodeValue = $barcode.val();

      if (!barcodeValue) {
        showMessage('Please read a barcode.', 'error', 1, '#FF0022');
        $barcode.val("");
        return;
      }

      if (jsonData.includes(barcodeValue)) {
        showMessage('You added this barcode before.', 'error', 1, '#FF0022');
        $barcode.val("");
        return;
      }

      playSound('ok');
      jsonData.push(barcodeValue);
      updateJsonData();
      updateDataCount();
      $barcode.val("");
    }

    $("#sendButton").click(submitForm);

    $("#finishButton").click(function() {
      window.location.href = "js_result.php?jsonData=" + JSON.stringify(jsonData);
    });

    $barcode.keypress(function(event) {
      if (event.which === 13) {
        event.preventDefault();
        submitForm();
      }
    });
  });
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
<p>Click the button above to submit all data to the server.</p>
</body>
</html>