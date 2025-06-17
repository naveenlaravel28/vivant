let html5QrcodeScanner = null;
let html5QrCode = null;
let currentCameraId = null;

$(document).ready(function () {
    const beepSound = document.getElementById("beep-sound");
    const beepSoundError = document.getElementById("error-beep-sound");

    function onScanSuccess(decodedText, decodedResult) {
        beepSound.play();
        var qrResult = decodedResult.decodedText;
        var qrData = qrResult.split("|");

        if ((qrData.length - 1) === 7) {
            $('#scan-btn').attr('disabled', false);
            scanText = decodedText;
            $("#result").text(`Scanned Code: ${decodedText}`);
        } else {
            $('#scan-btn').attr('disabled', true);
            $("#result").text('Wrong QR Code!');
        }
    }

    function onScanFailure(error) {
        // Optional: console.warn(`Scan error: ${error}`);
    }

    $('#qrScannerModal').on('shown.bs.modal', function () {
        Html5Qrcode.getCameras().then(function (cameras) {
            if (cameras && cameras.length) {
                // Populate camera options
                let cameraSelect = $('#camera-select');
                cameraSelect.empty();
                cameras.forEach(camera => {
                    cameraSelect.append(new Option(camera.label, camera.id));
                });

                let savedCameraId = localStorage.getItem('lastUsedCameraId');
                let matchedCamera = cameras.find(camera => camera.id === savedCameraId);

                currentCameraId = matchedCamera ? matchedCamera.id : cameras[0].id;
                cameraSelect.val(currentCameraId); // Preselect saved camera
                localStorage.setItem('lastUsedCameraId', currentCameraId);
                startScanner(currentCameraId);

                // Handle camera change
                cameraSelect.off('change').on('change', function () {
                    let selectedCameraId = $(this).val();
                    if (selectedCameraId !== currentCameraId) {
                        localStorage.setItem('lastUsedCameraId', selectedCameraId);
                        // Stop the old scanner first
                        if (html5QrCode) {
                            html5QrCode.stop().then(() => {
                                startScanner(selectedCameraId);
                            }).catch(err => {
                                console.error("Error stopping camera", err);
                            });
                        }
                    }
                });

            } else {
                console.error("No cameras found.");
                $("#result").text("No cameras found.");
            }
        }).catch(function (err) {
            console.error("Error getting cameras: ", err);
            $("#result").text("Error accessing camera: " + err);
        });
    });

    $('#qrScannerModal').on('hidden.bs.modal', function () {
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                console.log("QR Scanner stopped.");
                html5QrCode.clear();
                html5QrCode = null;
                $("#result").text('Scan result will appear here');
            }).catch(err => {
                console.error("Error stopping scanner: ", err);
            });
        }
    });

    function startScanner(cameraId) {
        currentCameraId = cameraId;
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("reader");
        }
        html5QrCode.start(
            cameraId,
            {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                rememberLastUsedCamera: true,
                aspectRatio: 1.777778,
                facingMode: "environment"
            },
            onScanSuccess,
            onScanFailure
        ).catch(err => {
            console.error("Error starting camera", err);
            $("#result").text("Error starting camera: " + err);
        });
    }
});
