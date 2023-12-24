<?php

use Portal\Auth\AuthInterface;

$this->title = 'Ваш профиль';

/** @var AuthInterface $auth */
if ($auth === null) {
    // Эту ошибку пользователь увидит только если сломалась проверка авторизации в контроллере
    echo '<p>Ошибка авторизации</p>';
}

?>

<h1><?= htmlspecialchars($this->title) ?></h1>

<p><b>ID</b>: <?= $auth->getId() ?><br />
<b>Имя</b>: <?= $auth->getName() ?><br />
<b>Группа</b>: <?= $auth->getGroup()->getName() ?><br />
<b>Статус</b>: <?= $auth->getStatus()->getName() ?><br />
<b>Аватар</b>: <?= $auth->getAvatar() ?><br />
<b>Уровень</b>: <?= $auth->getLevel() ?></p>
