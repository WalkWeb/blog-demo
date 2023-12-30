<?php

$this->title = 'Авторизация';
$url = '/login';

?>

<h1><?= $this->title ?></h1>

<div class="login_container">
    <form method="POST" action="<?= $url ?>">
        <label>
            <span class="login_label">Логин:</span>
            <input size="20" name="login" autocomplete="off" class="login_input">
        </label>
        <label>
            <span class="login_label">Пароль:</span>
            <input size="20" type="password" name="pass" class="login_input">
        </label>
        <button class="input_submit login_submit">Войти</button>
    </form>
</div>
