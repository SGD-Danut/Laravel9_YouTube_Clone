<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('head-title')</title>
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"> --}}
        <link rel="stylesheet" href="/bootstrap-5.2.2/css/bootstrap.min.css">
    </head>
    <body>
        @include('admin.master.parts.top-nav')
        <div class="px-4 py-5 my-5 text-center">
            <h1 class="display-6 fw-bold">@yield('big-title')</h1>
            <div class="col-lg-10 mx-auto">
                <br>
                @yield('content')
            </div>
        </div>
        {{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>--}}
        <script src="/bootstrap-5.2.2/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
