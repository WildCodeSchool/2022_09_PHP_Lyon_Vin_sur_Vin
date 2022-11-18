<?php

namespace App\Controller;

use App\Model\AdminManager;
use App\Controller\AccountController;

class AdminController extends AbstractController
{
    public function index(): ?string
    {
        if (!$this->admin) {
            echo 'Seuls les administrateurs ont accès à cette page';
            header('HTTP/1.1 401 Unauthorized');
            return null;
        }
        return $this->twig->render('Shared/admin.html.twig');
    }

    public function login(): string
    {
        session_destroy();

        if ($this->admin != false) {
            header('Location: /admin');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            //      @todo faire des controles pour dire si l'email et le mdp est bon
            $adminManager = new AdminManager();
            $accountController = new AccountController();
            $this->errors = $accountController->checkLoginFields($credentials);
            $admin = $adminManager->selectOneByEmail($credentials['email']);
            if ($admin && password_verify($credentials['password'], $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                header('Location: /admin');
            }

            if ($admin == false || !password_verify($credentials['password'], $admin['password'])) {
                $this->errors['wrong'] = "Vous n'avez pas de compte ou vous avez fait une faute de frappe";
            }
        }
        if (!empty($this->errors)) {
            return $this->twig->render('Admin/login.html.twig', ['errors' => $this->errors]);
        }
        return $this->twig->render('Admin/login.html.twig');
    }
}
