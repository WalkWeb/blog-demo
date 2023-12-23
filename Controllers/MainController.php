<?php

declare(strict_types=1);

namespace Controllers;

use Exception;
use NW\AbstractController;
use NW\Response\Response;

class MainController extends AbstractController
{
    /**
     * @return Response
     * @throws Exception
     */
    public function index(): Response
    {
        return $this->render('index');
    }
}
