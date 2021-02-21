<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;600&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
    </script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>

    <title>{{env('APP_NAME')}}</title>
</head>
<body class="mx-10 my-6 bg-gray-100 text-gray-800">
<div id="app">
    <home
            :urls='{{ json_encode($urls, JSON_UNESCAPED_SLASHES) }}'
    >
    </home>
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
