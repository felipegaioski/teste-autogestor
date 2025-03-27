<!DOCTYPE html>
<html dir="ltr" lang="pt-br" class=" js no-touch csstransitions">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="56x56" href="{{ asset('assets/favicon.ico') }}" />

    <!-- Title  -->
    <title>AutoGestor</title>

    <!-- CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    {{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    {{-- <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" type="text/javascript"></script> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
</head>
<body class="antialiased">

@yield('content')

</body>
</html>
