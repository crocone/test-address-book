<!DOCTYPE html>
<html lang="ru">
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/home.css">
</head>
<body>


<div class="container">
    <div class="text-center home-page">
        <form class="form-signin ajax-form" action="/api/auth">
            <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
            <label for="inputEmail" class="sr-only">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required autofocus>
            <label for="inputPassword" class="sr-only">Пароль</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Ваш очень сложны пароль" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Вход</button>
            <a href="/home/register">Регистрация</a>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.session@1.0.0/jquery.session.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<script src="/assets/js/config.js"></script>
<script src="/assets/js/home.js"></script>

</body>
</html>
