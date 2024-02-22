<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    @vite([
        'resources/css/maintenance.css'
        ])
</head>
<body>
    <style>
        body {
            background-image: url("{{asset('storage/medias/chalk-1920x1080.jpg')}}");
        }
    </style>
    <div class="maintenance__container">
        <p>Site en maintenance...</p>
        <p>Merci de votre patience!</p>
    </div>
</body>
</html>