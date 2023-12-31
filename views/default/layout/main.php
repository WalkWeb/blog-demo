<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?= htmlspecialchars($this->title) ?></title>
    <meta name="Description" content="<?= htmlspecialchars($this->description) ?>">
    <meta name="Keywords" content="<?= htmlspecialchars($this->keywords) ?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="stylesheet" type="text/css" href="/styles/main.css">
</head>
<body>
<div class="menu">
    <ul class="navigation">
        <li><a href="/" title="">Главная</a></li>
        <li><a href="/profile" title="">Профиль</a></li>
        <li><a href="/login" title="">Авторизация</a></li>
<!--        <li><a href="/posts/1" title="">Посты</a></li>-->
<!--        <li><a href="/post/create" title="">Создать пост</a></li>-->
<!--        <li><a href="/admin" title="">Админка</a></li>-->
<!--        <li><a href="/redirect" title="">Редирект</a></li>-->
    </ul>
</div>
<div class="content">
    <?= $content ?? 'Отсутствует контент для отображения' ?>
    <?= NW\Runtime::end() ?>
</div>
</body>
</html>