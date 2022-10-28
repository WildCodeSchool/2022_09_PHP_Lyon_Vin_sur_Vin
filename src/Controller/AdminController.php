<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        return $this->twig->render('Shared/admin.html.twig');
    }
}
