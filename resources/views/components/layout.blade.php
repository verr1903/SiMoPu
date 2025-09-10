<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}} - Mazer Admin Dashboard</title>

    <link rel="shortcut icon" href=".//../assets/compiled/svg/favicon.svg" type="image/x-icon">

    <link rel="stylesheet" href=".//../assets/compiled/css/app.css">
    <link rel="stylesheet" href=".//../assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href=".//../assets/compiled/css/iconly.css">
</head>

<body>
    
    <script src="/../assets/static/js/initTheme.js"></script>

    <div id="app">
        <x-sidebar></x-sidebar>

        {{ $slot  }}


    </div>

    <script src="/../assets/static/js/components/dark.js"></script>
    <script src="/../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/../assets/compiled/js/app.js"></script>
    <!-- Need: Apexcharts -->
    <script src="/../assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="/../assets/static/js/pages/dashboard.js"></script>

    <!-- sweetalert -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>