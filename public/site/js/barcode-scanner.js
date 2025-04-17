
let isScannerActive = false;

$(document).ready(function () {

    const beepSound = document.getElementById("beep-sound");

    // Modal open event: Initialize barcode scanner
    $('#scannerModal').on('shown.bs.modal', function () {
        if (isScannerActive) return; // Avoid reinitializing if already active
        isScannerActive = true;

        Quagga.init({
            inputStream: {
                type: "LiveStream", // Use camera as input
                constraints: {
                    width: 400,
                    height: 300,
                    facingMode: "environment" // Use back camera
                },
                target: document.querySelector('#reader') // Scanner container
            },
            decoder: {
                readers: [
                    "code_128_reader",  // Most common for retail
                    "ean_reader",       // EAN-13 (European Article Number)
                    "ean_8_reader",     // EAN-8
                    "upc_reader",       // UPC (Universal Product Code)
                    "code_39_reader"
                ]
            }
        }, function (err) {
            if (err) {
                console.error("Error initializing Quagga: ", err);
                $("#result").text("Error initializing scanner: " + err);
                isScannerActive = false;
                return;
            }

            $("#result").text("");
            $('#scan-btn').attr('disabled', true);
            console.log("Barcode scanner initialized.");
            Quagga.start(); // Start the scanner
        });

        // Handle barcode detection
        Quagga.onDetected(function (data) {

            // Play beep sound
            beepSound.play();

            const barcode = data.codeResult.code;
            console.log("Detected barcode: ", barcode);

            // Display detected barcode
            $("#result").text("Detected Barcode: " + barcode);

            scanText = barcode;
            $('#scan-btn').attr('disabled', false);

            // Stop scanner after detecting a barcode
            Quagga.stop();
            isScannerActive = false;

            // Close the modal
            // $('#scannerModal').modal('hide');
        });

        // Handle processed frames for debugging
        Quagga.onProcessed(function (result) {
            console.log("Processing frame: ", result);
        });
    });

    // Modal close event: Stop barcode scanner
    $('#scannerModal').on('hidden.bs.modal', function () {
        if (isScannerActive) {
            Quagga.stop(); // Stop the scanner
            console.log("Barcode scanner stopped.");
            isScannerActive = false;
        }
    });

});

