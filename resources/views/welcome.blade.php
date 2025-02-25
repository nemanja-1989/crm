<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>   
    <body>
        <h1>Kredium loans</h1>  

        <div>
            <a href="{{ route('login-page') }}">
                <button>Log in</button>
            </a>
        </div>
    </body>
</html>
