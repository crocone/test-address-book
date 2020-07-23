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
    <div class="home-page text-center">
        <form class="form-signin ajax-form" action="/api/register">
            <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
            <div class="form-group">
                <label for="name" class="sr-only">Ваше имя</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Имя" required autofocus>
            </div>
            <div class="form-group">
                <label for="email" class="sr-only">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="password" class="sr-only">Пароль</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Ваш очень сложны пароль" required>
            </div>
            <div class="form-group">
                <label for="passwordConfirm" class="sr-only">Повторите пароль</label>
                <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control" placeholder="Повторите пароль введенный выше" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div id="captcha"></div>
                </div>
                <input type="text" class="form-control" name="captcha" placeholder="Captcha" id="cpatchaTextBox"/>
            </div>
            <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Регистрация</button>
                <a  href="/">Авторизация</a>
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
