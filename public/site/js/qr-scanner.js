
let html5QrcodeScanner = null;

$(document).ready(function () {

    const beepSound = document.getElementById("beep-sound");
    const beepSoundError = document.getElementById("error-beep-sound");

    function onScanSuccess(decodedText, decodedResult) {

        // Play beep sound
        beepSound.play();

        // Display the scanned result
        scanText = decodedResult;
        var qrResult = scanText.decodedText;
        var qrData = qrResult.split("|");

        // Play beep sound
        if ((qrData.length - 1) === 7) {
            $('#scan-btn').attr('disabled', false);
            $("#result").text(`Scanned Code: ${decodedText}`);
        } else {
            $('#scan-btn').attr('disabled', true);
            $("#result").text('Wrong QR Code!');
        }
    }

    function onScanFailure(error) {
        // Handle scan failure (optional)
        // console.warn(`Scan error: ${error}`);
    }

    // Modal open event: Initialize QR scanner
    $('#qrScannerModal').on('shown.bs.modal', function () {
        // Get available cameras
        Html5Qrcode.getCameras().then(function (cameras) {
            if (cameras && cameras.length) {
                const cameraId = cameras[0].id; // Use the first camera

                // Initialize scanner only if not already initialized
                if (!html5QrcodeScanner) {
                    html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader",
                        {
                            fps: 10, // Frames per second
                            qrbox: { width: 250, height: 250 } // QR scanning area
                        },
                        false
                    );

                    // Render the scanner
                    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                }
            } else {
                console.error("No cameras found.");
                $("#result").text("No cameras found.");
            }
        }).catch(function (err) {
            console.error("Error getting cameras: ", err);
            $("#result").text("Error accessing camera: " + err);
        });
    });

    // Modal close event: Stop QR scanner and clean up
    $('#qrScannerModal').on('hidden.bs.modal', function () {
        if (html5QrcodeScanner) {
            // Stop the scanner and clean up
            html5QrcodeScanner.clear().then(() => {
                console.log("QR Scanner stopped.");
                html5QrcodeScanner = null; // Reset scanner instance
                $("#result").text('Scan result will appear here');
            }).catch(err => {
                console.error("Error stopping scanner: ", err);
            });
        }
    });

});