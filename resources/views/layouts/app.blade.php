<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Exam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    .resetBtn {
      border:0;
      background-color:none;
      outline:none;
      -webkit-appearance: none;//用於IOS下移除原生樣式
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Logo</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link @if (Route::currentRouteName() == 'home')
            active
            @endif " aria-current="page" href="/">Home</a>
          </li>
          @if (session()->get('user'))
          <li class="nav-item">
            <a class="nav-link @if (Route::currentRouteName() == 'dashboard')
              active
            @endif" href="{{route('dashboard')}}">dashboard</a>
          </li>
          @endif
          @if (!session()->get('user'))
          <li class="nav-item">
            <a class="nav-link @if (Route::currentRouteName() == 'login')
              active
            @endif" href="{{route('login')}}">Login</a>
          </li>
          @else
          <li class="nav-item">
            <a class="nav-link" href="{{route('logout')}}">Logout</a>
          </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>
  @yield('dashboardSidebar')
  @yield('content')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>