import $ from 'jquery';
import Swal from 'sweetalert2';

let jsonData = [];

$(document).ready(function() {

    // when "Submit" button clicked
    $("#sendButton").click(submitForm);

    // submit the collected JSON data to js_result.php
    $("#finishButton").click(function () {
        window.location.href = "js_result.php?jsonData=" + JSON.stringify(jsonData);
    });

    // when "Enter" pressed on keyboard or barcode scanner read event
    $("#barcode").keypress(function (event) {
        if (event.which === 13) {
            event.preventDefault();
            submitForm();
        }
    });
});

const showError = (errorText, alert) => {
    Swal.fire({
        position: 'top',
        icon: 'error',
        title: errorText,
        showConfirmButton: true,
        confirmButtonText: 'Ok',
        confirmButtonColor: '#FF0022',
        timerProgressBar: true,
        timer: 3500
    });

    if (alert === 1) {
        playError();
    }
}

const showOK = (okText, alert) => {
    Swal.fire({
        position: 'top',
        icon: 'success',
        title: okText,
        showConfirmButton: true,
        confirmButtonText: 'Ok',
        confirmButtonColor: '#008822',
        timerProgressBar: true,
        timer: 3500
    });

    if (alert === 1) {
        playOk();
    }
}

const playOk = () => {
    let audio = new Audio('sound/ok.mp3');

    audio.play();
}

const playError = () => {
    let audio = new Audio('sound/error.mp3');

    audio.play();
}

const submitForm = () => {
    let barcodeElement = $("#barcode");
    let barcodeValue = barcodeElement.val();

    // if empty value
    if (barcodeValue === "" || barcodeValue == null) {
        // show error message
        showError('Please read a barcode.', 1);
        // clear barcode input box for next entry
        barcodeElement.val("");
        return;
    }

    // check JSON data for repetition
    if (jsonData.includes(barcodeValue)) {
        // show error message for repetition
        showError('You added this barcode before.', 1);
        // clear barcode input box content
        barcodeElement.val("");
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
    barcodeElement.val("");
}

const updateDataCount = () => {
    $("#dataCount").text(jsonData.length);
}

const updateJsonData = () => {
    $("#jsonData").text(JSON.stringify(jsonData, null ,2));
}