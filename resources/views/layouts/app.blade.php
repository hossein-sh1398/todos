<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ url('css/app.css') }}">
        @yield('css')
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
              <a class="navbar-brand" href="#"><img width="80" src="{{ url('images/logo.png') }}" alt=""></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ url('/') }}">صفحه اصلی</a>
                  </li>
                  @auth
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="{{ route('todos.index') }}">لیست تودوها</a>
                    </li>
                  @endauth
                </ul>
                <div class="d-flex">
                    @if (Route::has('login.form'))
                        <div class="fixed top-0">
                            @auth
                                <form action="{{ route('logout') }}" id="logout-form" method="post">@csrf</form>
                                <span>{{ auth()->user()->name }}</span>
                                <a href="#" onclick="logout(event)" class="btn btn-warning">خروج</a>
                            @else
                                <a href="{{ route('login.form') }}" class="btn btn-primary">ورود</a>

                                @if (Route::has('register.form'))
                                    <a href="{{ route('register.form') }}" class="btn btn-success">ثبت نام</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
              </div>
            </div>
          </nav>
        <div class="container mt-3">
            @yield('content')
        </div>
       
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    @auth
      <script>
        function logout(e) {
          e.preventDefault();
          document.getElementById('logout-form').submit();
        }
      </script>
    @endauth
    @include('sweetalert::alert') 
    
    @yield('js')
    </html>