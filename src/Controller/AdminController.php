<?php

namespace App\Controller;

use App\Model\AdminManager;

class AdminController extends AbstractController
{
    /**
     * Display home page
     */
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            //      @todo faire des controles pour dire si l'email et le mdp est bon
            $errors = [];

            if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) && !empty($credentials['email'])) {
                $errors['email_incorrect'] = "L'adresse e-mail saisie est incorrecte. ";
            }

            $adminManager = new AdminManager();
            $user = $adminManager->selectOneByEmail($credentials['email']);
            if ($user && password_verify($credentials['password'], $user['password'])) {
                $_SESSION['admin_id'] = $user['id'];
                header('Location: /');
            }

            if ($user == false || !password_verify($credentials['password'], $user['password'])) {
                $errors['wrong'] = "Vous n'avez pas de compte ou vous avez fait une faute de frappe";
            }
        }
        if (!empty($errors)) {
            return $this->twig->render('Admin/login.html.twig', ['errors' => $errors]);
        }
        return $this->twig->render('Admin/login.html.twig');
    }

    public function logout()
    {
        unset($_SESSION['admin_id']);
        header('Location: /');
    }
}
