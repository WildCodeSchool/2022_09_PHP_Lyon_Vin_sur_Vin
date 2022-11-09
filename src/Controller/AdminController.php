<?php

namespace App\Controller;

use App\Model\AdminManager;

class AdminController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        if (!$this->admin) {
            echo 'Seuls les adminsitrateurs ont accès à cette page';
            header('HTTP/1.1 401 Unauthorized');
            exit();
        } 
        return $this->twig->render('Shared/admin.html.twig');
    }

    public function login(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            //      @todo make some controls on email and password fields and if errors, send them to the view
            $adminManager = new AdminManager();
            $user = $adminManager->selectOneByEmail($credentials['email']);
            if ($user && password_verify($credentials['password'], $user['password'])) {
                $_SESSION['admin_id'] = $user['id'];
                header('Location: /');
            }
        }
        return $this->twig->render('Admin/login.html.twig');
    }

    public function logout()
    {
        unset($_SESSION['admin_id']);
        header('Location: /');
    }
    public function register(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //      @todo make some controls and if errors send them to the view
            $credentials = $_POST;
            $adminManager = new AdminManager();
            if ($adminManager->insert($credentials)) {
                return $this->login();
            }
        }
        return $this->twig->render('Admin/register.html.twig');
    }
}
