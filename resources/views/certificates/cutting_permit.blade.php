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
            width: 120px;
            height: 120px;
            margin: 0 0 0 2em;
            position: absolute;
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
        <img src="images/logo.png" alt="Barangay Logo">
        <h1>Republic of the Philippines</h1>
        <p>Province Of Cotabato</p>
        <p>Kidapawan City</p>
        <p><strong>Barangay Balindog</strong></p>
    </div>

    <div class="content">
        <h2>Barangay Cutting Permit</h2>
        <h4>TO WHOM IT MAY CONCERN:</h4>
        <p class="p1">
            This is to certify that <strong>{{ $record['residentName'] ?? 'Unknown' }}</strong>, 
            <strong>{{ $record['residentAge'] ?? 'N/A' }}</strong> years of age, born on <strong>{{ $record['residentBirthdate'] ?? 'N/A' }}</strong>, 
            is a bonafide resident of Barangay Balindog, Kidapawan, North Cotabato.
        </p>
        <p class="p2">
            The individual is authorized to cut or gather certain plants, trees, or materials from the public or private land as per local regulations and with the consent of the Barangay authorities.
        </p>
        <p class="p3">
            This Cutting Permit is being issued for the specific purpose of <strong>{{ $record['purpose'] ?? 'N/A' }}</strong>, in accordance with Barangay policies regarding the cutting and gathering of natural resources.
        </p>
        <p class="p4">
            Given this {{ now()->format('F j, Y') }} at Balindog, Kidapawan City, North Cotabato.
        </p>
    </div>

    <div class="signature">
        <p><strong>{{ $record['officialName'] ?? 'Unknown' }}</strong></p>
        <p>{{ $record['officialPosition'] ?? 'Unknown' }}</p>
    </div>

</body>
</html>
