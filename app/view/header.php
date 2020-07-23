<!DOCTYPE html>
<html lang="ru">
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?= $action == 'index' ? 'active' : '' ?>">
                <a class="nav-link" href="/dashboard/index">Мои контакты</a>
            </li>
            <li class="nav-item <?= $action == 'profile' ? 'active' : '' ?>">
                <a class="nav-link" href="/dashboard/profile">Профиль</a>
            </li>
            <?php if($isAdmin): ?>
                <li class="nav-item <?= $action == 'admin' ? 'active' : '' ?>">
                    <a class="nav-link" href="/dashboard/admin">Список пользователей</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container content-block">