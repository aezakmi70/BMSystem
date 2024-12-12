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
        <img src="images/logo.png.png" alt="Barangay Logo">
        <h1>Republic of the Philippines</h1>
        <p>Province Of Cotabato</p>
        <p>Kidapawan City</p>
        <p><strong>Barangay Balindog</strong></p>
    </div>

    <div class="content">
        <h2>Barangay Business Permit</h2>
        <h4>TO WHOM IT MAY CONCERN:</h4>
        <p class="p1">
            This is to certify that <strong>{{ $record['resident_name'] ?? 'Unknown' }}</strong>, 
            <strong>{{ $record['resident_age'] ?? 'N/A' }}</strong> years of age, born on <strong>{{ $record['resident_birthdate'] ?? 'N/A' }}</strong>, 
            is the owner of the business <strong>{{ $record['business_name'] ?? 'N/A' }}</strong>, located at <strong>{{ $record['business_address'] ?? 'N/A' }}</strong>.
        </p>
        <p class="p2">
            The business complies with local business laws, ordinances, and requirements, and is fully operational within the Barangay's jurisdiction.
        </p>
        <p class="p3">
            This permit is issued to the individual for the purpose of operating their business in accordance with local regulations.
        </p>
        <p class="p4">
            Given this {{ now()->format('F j, Y') }} at Balindog, Kidapawan City, North Cotabato.
        </p>
    </div>

    <div class="signature">
        <p><strong>{{ $record['present_official'] ?? 'Unknown' }}</strong></p>
        <p>{{ $record['official_position'] ?? 'Unknown' }}</p>
    </div>
</body>
</html>
