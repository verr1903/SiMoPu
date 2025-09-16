<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* optional, buat print-friendly styling */
        body { font-size: 14px; }
        .container { margin-top: 30px; }
        button { display: none; } /* hide buttons saat print */
    </style>
</head>
<body>
    {{ $slot }}
</body>
</html>
