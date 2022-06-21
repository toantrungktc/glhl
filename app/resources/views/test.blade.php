<html>
<head>
    <title>Html-Qrcode Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
    <div id="qr-reader" style="width:500px"></div>
    <div id="qr-reader">Kết quả</div>

    <div id="qr-reader-results"></div>
    <input type="text" id="test" name="test" class="form-control"/>

<script src="{{ asset("/bower_components/admin-lte/plugins/html5-qrcode/html5-qrcode.min.js") }} "></script>
<script>
    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete"
            || document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function () {
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;
        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                resultContainer.innerHTML += `<div>[${countResults}] - ${decodedText}</div>`;
                document.getElementById("test").value = decodedText;

                //$('#test').val(decodedText);
                // Handle on success condition with the decoded message.
                console.log(`Scan result ${decodedText}`, decodedResult);
                
            }
        }

        Html5Qrcode.getCameras().then(devices => {
        /**
         * devices would be an array of objects of type:
         * { id: "id", label: "label" }
         */
        if (devices && devices.length) {
            var cameraId = devices[0].id;
            // .. use this to start scanning.
        }
        }).catch(err => {
        // handle err
        });
        
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 350 });
        html5QrcodeScanner.render(onScanSuccess);
    });
</script>
</body>
</html>