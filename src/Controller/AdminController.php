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
            $adminManager = new AdminManager();
            $errors = $this->checkUserFields($credentials);
            $admin = $adminManager->selectOneByEmail($credentials['email']);
            if ($admin && password_verify($credentials['password'], $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                header('Location: /');
            }
            if ($admin == false || !password_verify($credentials['password'], $admin['password'])) {
                $errors['wrong'] = 'L\'email et le mot de passe ne correspondent pas.';
            }
        }

        if (!empty($errors)) {
            return $this->twig->render('Admin/login.html.twig', ['errors' => $errors]);
        }
        return $this->twig->render('Admin/login.html.twig');
    }

    public function checkUserFields(array $credentials): array
    {
        $errors = [];

        if (empty($credentials['email'])) {
            $errors['empty_mail'] = 'Veuillez saisir votre adresse e-mail.';
        }

        if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'adresse e-mail saisie est incorrecte. ";
        }

        if (empty($credentials['password'])) {
            $errors['empty_password'] = 'Veuillez saisir votre mot de passe.';
        }

        if (strlen($credentials['password']) > 20) {
            $errors['password_length'] = 'Votre mot de passe ne peut faire plus de 20 caractères.';
        }

        return $errors;
    }
}
