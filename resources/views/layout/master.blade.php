<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include('partials._topHeader')
<body style="height: 100%;background-color: #f8f9fa;">
@include('partials._Nav')
@yield('content')

@include('partials._footer')
</body>
</html>
