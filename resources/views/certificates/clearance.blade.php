<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Certification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
            height: 100px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
        }
        .content {
            margin: 0 50px;
        }
        .content h2 {
            text-align: center;
            text-transform: uppercase;
            
            font-size: 20px;
        }
        .signature {
            text-align: right;
            margin-top: 50px;
            margin-right: 50px;
        }
        .p1,.p2,.p3,.p4 {
            text-indent: 2em;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="images/barangayLogo.png" alt="Barangay Logo">
        <h1>Republic of the Philippines</h1>
        <p>Province Of North Cotabato</p>
        <p>Kidapawan City</p>
        <p><strong>Barangay Balindog</strong></p>
    </div>

    <div class="content">
        <h2>Barangay Clearance</h2>
        <h4>TO WHOM IT MAY CONCERN:</h4>
        <p class="p1">
            This is to certify that <strong>{{ $record['residentName'] ?? 'Unknown' }}</strong>, 
            <strong>{{ $record['residentAge'] ?? 'N/A' }}</strong> years of age, born on <strong>{{ $record['residentBirthdate'] ?? 'N/A' }}</strong>, 
            is a bonafide resident of Barangay Balindog, Kidapawan, North Cotabato, and has no derogatory records or pending legal issues in the barangay.
        </p>
        <p class="p2">
            This clearance is being issued to affirm that the individual is of good standing in the community and is a law-abiding citizen.
        </p>
        <p class="p3">
            This clearance is being issued for the purpose of <strong>{{ $record['purpose'] }}</strong>.
        </p>
        <p class="p4">
            Given this {{ now()->format('F j, Y') }} at Balindog, Kidapawan City, North Cotabato.
        </p>
    </div>

    <div class="signature">
        <p><strong>Jhon Doe</strong></p>
        <p>Punong Barangay</p>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
