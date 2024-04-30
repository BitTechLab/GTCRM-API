<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GTCRM</title>

    <script>
        window.authData = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::user(),
            // 'api_token' => Auth::user() ? Auth::user()->api_token : null,
        ]) !!};
    </script>

    @vite('resources/css/app.css')
</head>

<body>
    <div id="app"></div>
    @vite('resources/js/app.ts')
</body>

</html>
