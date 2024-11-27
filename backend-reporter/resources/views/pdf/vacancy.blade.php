<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacancy Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .section p {
            margin: 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $vacancy->title }}</h1>
    </div>

    <div class="section">
        <h2>Description:</h2>
        {!! $vacancy->description !!}
    </div>

</body>
</html>
