<!DOCTYPE html>
<html>

<head>
    <title>Instascan</title>

</head>

<body>
    <div style="width: 500px" id="reader"></div>
    <textarea id="result">

    </textarea>
    <script src="{{asset('public/js/html5-qrcode.min.js')}}">
    </script>
    <script>
        const html5QrCode = new Html5Qrcode("reader");
const qrCodeSuccessCallback = message => { document.getElementById("result").value = message }
const config = { fps: 10, qrbox: 250 };

// If you want to prefer front camera
html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);

// If you want to prefer back camera
//html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);

// Select front camera or fail with `OverconstrainedError`.
//html5QrCode.start({ facingMode: { exact: "user"} }, config, qrCodeSuccessCallback);

// Select back camera or fail with `OverconstrainedError`.
//html5QrCode.start({ facingMode: { exact: "environment"} }, config, qrCodeSuccessCallback);
    </script>
</body>

</html>