<?php

declare(strict_types=1);

namespace Controllers;

use Exception;
use NW\AbstractController;
use NW\Request\Request;
use NW\Response\Response;
use Repository\AuthRepository;

class ProfileController extends AbstractController
{
    /**
     * @return Response
     * @throws Exception
     */
    public function index(): Response
    {
        if (!$auth = AuthRepository::getAuth()) {
            return $this->redirect('/');
        }

        return $this->render('profile', ['auth' => $auth]);
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function formLogin(): Response
    {
        if ($auth = AuthRepository::getAuth()) {
            return $this->redirect('/');
        }

        return $this->render('login');
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function login(Request $request): Response
    {
        if ($auth = AuthRepository::getAuth()) {
            return $this->redirect('/');
        }

        try {
            AuthRepository::login($request);
            return $this->redirect('/');
        } catch (Exception $e) {
            return $this->render('login', ['message' => $e->getMessage()]);
        }
    }
}
