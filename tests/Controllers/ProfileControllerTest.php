<?php

declare(strict_types=1);

namespace Tests\Controllers;

use Exception;
use Tests\AbstractUnitTest;

class ProfileControllerTest extends AbstractUnitTest
{
    /**
     * Тест на отображение страницы профиля пользователя
     *
     * @throws Exception
     */
    public function testProfileIndexSuccess(): void
    {
        $request = $this->createRequest('/profile', 'GET', 'hash1');
        $app = $this->createApp();

        $response = $app->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Ваш профиль', $response->getBody());
        self::assertStringContainsString('<b>ID</b>: 1095762b-41d5-4f48-a510-284a90fa9e58', $response->getBody());
        self::assertStringContainsString('<b>Имя</b>: User1', $response->getBody());
        self::assertStringContainsString('<b>Статус</b>: Active', $response->getBody());
        self::assertStringContainsString('<b>Аватар</b>: ava.jpg', $response->getBody());
        self::assertStringContainsString('<b>Уровень</b>: 1', $response->getBody());
    }

    /**
     * Тест на попытку открыть страницу профиля с некорректными авторизационными данными
     *
     * @throws Exception
     */
    public function testProfileIndexFail(): void
    {
        $request = $this->createRequest('/profile', 'GET', 'unknown_hash');
        $app = $this->createApp();

        $response = $app->handle($request);

        self::assertEquals(302, $response->getStatusCode());
        self::assertEquals(['Location' => '/'], $response->getHeaders());
    }

    /**
     * Тест на отображение страницы авторизации
     *
     * @throws Exception
     */
    public function testProfileFormLogin(): void
    {
        $request = $this->createRequest('/login', 'GET', 'unknown_hash');
        $app = $this->createApp();

        $response = $app->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Авторизация', $response->getBody());
        self::assertStringContainsString('Логин', $response->getBody());
        self::assertStringContainsString('Пароль', $response->getBody());
    }

    /**
     * Тест на успешную авторизацию
     *
     * @throws Exception
     */
    public function testProfileLoginSuccess(): void
    {
        $request = $this->createRequest('/login', 'POST', '', ['login' => 'Login1', 'pass' => '12345']);
        $app = $this->createApp();

        $response = $app->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        // При успешной авторизации происходит редирект, но PHPUnit не дает его сделать
        // Соответственно успешность авторизации проверяем по тексту ошибки
        self::assertStringContainsString('Cannot modify header information', $response->getBody());
    }

    /**
     * Тест на различные ошибки авторизации
     *
     * @param string $login
     * @param string $pass
     * @param string $error
     * @throws Exception
     * @dataProvider failLoginDataProvider
     */
    public function testProfileLoginFail(string $login, string $pass, string $error): void
    {
        $body = [];

        if ($login) {
            $body['login'] = $login;
        }
        if ($pass) {
            $body['pass'] = $pass;
        }

        $request = $this->createRequest('/login', 'POST', '', $body);
        $app = $this->createApp();

        $response = $app->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString($error, $response->getBody());
    }

    /**
     * Тест на ситуацию, когда уже авторизованный пользователь отправляет данные на авторизацию
     *
     * @throws Exception
     */
    public function testProfileLoginAlreadyAuth(): void
    {
        $request = $this->createRequest('/login', 'POST', 'hash1', ['login' => 'Login1', 'pass' => '12345']);
        $app = $this->createApp();

        $response = $app->handle($request);

        // Проверяем переадресацию такого пользователя на главную
        self::assertEquals(302, $response->getStatusCode());
        self::assertEquals(['Location' => '/'], $response->getHeaders());
    }

    public function failLoginDataProvider(): array
    {
        return [
            // Не указан логин и пароль
            [
                '',
                '',
                'Не указан логин'
            ],
            // Не указан логин
            [
                '',
                'pass',
                'Не указан логин'
            ],
            // Не указан пароль
            [
                'login',
                '',
                'Не указан пароль'
            ],
            // Указан неизвестный логин
            [
                'unknown_login',
                'pass',
                'Указан неизвестный логин'
            ],
            // Указан некорректный пароль
            [
                'Login1',
                'pass',
                'Логин и/или пароль не верны'
            ],
            // Аккаунт заблокирован
            [
                'Login2',
                '12345',
                'Аккаунт заблокирован'
            ],
        ];
    }
}
