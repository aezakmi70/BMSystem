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
        <h2>Barangay Business Permit</h2>
        <h4>TO WHOM IT MAY CONCERN:</h4>
        <p class="p1">
            This is to certify that <strong>{{ $record['residentName'] ?? 'Unknown' }}</strong>, 
            <strong>{{ $record['residentAge'] ?? 'N/A' }}</strong> years of age, born on <strong>{{ $record['residentBirthdate'] ?? 'N/A' }}</strong>, 
            is the owner of the business <strong>{{ $record['businessName'] ?? 'N/A' }}</strong>, located at <strong>{{ $record['businessAddress'] ?? 'N/A' }}</strong>.
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
