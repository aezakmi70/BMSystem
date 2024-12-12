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
        <img src="images/logo.png" alt="Barangay Logo" >
        <h1>Republic of the Philippines</h1>
        <p>Province Of Cotabato</p>
        <p>Kidapawan City</p>
        <p><strong>Barangay Balindog</strong></p>
    </div>

    <div class="content">
        <h2>Barangay Certificate of Indigency</h2>
        <h4>TO WHOM IT MAY CONCERN:</h4>
        <p class="p1">
            This is to certify that <strong>{{ $record['residentName'] ?? 'Unknown' }}</strong>, 
            <strong>{{ $record['residentAge'] ?? 'N/A' }}</strong> years of age, born on <strong>{{ $record['residentBirthdate'] ?? 'N/A' }}</strong>, 
            is a bonafide resident of Barangay Balindog, Kidapawan, North Cotabato.
        </p>
        <p class="p2">
            The above-named individual is recognized as being under the category of indigent due to their low-income status and lack of sufficient financial resources to support their daily needs.
        </p>
        <p class="p3">
            This certification is issued upon the request of the above-namedindividual  for the purpose <strong>{{ $record['purpose'] ?? 'N/A' }}</strong>.
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
