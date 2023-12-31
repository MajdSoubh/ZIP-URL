<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= asset('styles/main.css') ?>">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <title>Shorty</title>
  <style>

  </style>
</head>

<body data-bs-theme="dark">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">ZIP URL</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link    <?= request()->path() == '/' ? 'active' : '' ?> " href="<?= url('/') ?>">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= request()->path() == '/link' ? 'active' : '' ?> " href="<?= url('/link') ?>">Links</a>
          </li>
        </ul>
        <div class="dropdown p-1 ">
          <div class="dropdown-toggle no-arrow  " data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle d-block" style="font-size:1.6rem ;"></i>

          </div>
          <ul class="dropdown-menu dropdown-menu-md-end ">
            <li> <a class="nav-link text-center" href="<?= url('/logout') ?>">Logout</a></li>

          </ul>
        </div>
      </div>
    </div>
  </nav>


  <div class="container ">
    <div class='mt-5'>

      <!-- Main content here -->
      {{content}}
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>