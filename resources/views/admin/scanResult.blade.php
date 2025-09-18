<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Scan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      text-align: center;
    }
    .status-box {
      padding: 40px;
      border-radius: 12px;
      color: white;
      width: 90%;
      margin-top: -80px;
      max-width: 400px;
    }
    .success { background-color: #28a745; }
    .error   { background-color: #dc3545; }
  </style>
</head>
<body>
  <div class="status-box {{ $status }}">
   <h1>
  @if($status === 'success')
    <i class="bi bi-check-circle-fill" style="font-size: 4rem; color: #fff;"></i>
    <div>Berhasil</div>
  @else
    <i class="bi bi-x-circle-fill" style="font-size: 4rem; color: #fff;"></i>
    <div>Gagal</div>
  @endif
</h1>
    <p style="font-size: 1.2rem;">{{ $message }}</p>
  </div>
</body>
</html>
