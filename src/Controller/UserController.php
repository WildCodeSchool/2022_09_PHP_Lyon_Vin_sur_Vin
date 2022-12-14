<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Controller\AccountService;

class UserController extends AbstractController
{
    public function login(): ?string
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['pro_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            //      @todo make some controls on email and password fields and if errors, send them to the view
            $userManager = new UserManager();
            $accountService = new AccountService();
            $this->errors = $accountService->checkLoginFields($credentials);
            $user = $userManager->selectOneByEmail($credentials['email']);

            if ($user && password_verify($credentials['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: /');
                return null;
            }
            if ($user == false || !password_verify($credentials['password'], $user['password'])) {
                $this->errors['wrong'] = 'L\'email et le mot de passe ne correspondent pas.';
            }
        }
        if (!empty($this->errors)) {
            return $this->twig->render('User/login.html.twig', ['errors' => $this->errors]);
        }

        return $this->twig->render('User/login.html.twig');
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /');
    }

    public function register(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            $this->errors = $this->validate($credentials);
            if (empty($credentials['password'])) {
                $this->errors['empty_password'] = 'Veuillez saisir votre mot de passe.';
            }
            if ((!empty($credentials['email'])) && (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL))) {
                $this->errors['email'] = "L'adresse e-mail saisie est incorrecte. ";
            }
            if (!empty($this->errors)) {
                return $this->twig->render('User/register.html.twig', ['errors' => $this->errors]);
            }
            //      @todo make some controls and if errors send them to the view
            $userManager = new UserManager();
            if ($userManager->insert($credentials)) {
                return $this->login();
            }
        }
        return $this->twig->render('User/register.html.twig');
    }

    public function validate(array $credentials): array
    {
        $credentials['pseudo'] = filter_var($credentials['pseudo'], FILTER_SANITIZE_ENCODED);
        $credentials['lastname'] = filter_var($credentials['lastname'], FILTER_SANITIZE_ENCODED);
        $credentials['firstname'] = filter_var($credentials['firstname'], FILTER_SANITIZE_ENCODED);
        $credentials['adress'] = filter_var($credentials['address'], FILTER_SANITIZE_ENCODED);
        $credentials['email'] = filter_var($credentials['email'], FILTER_SANITIZE_ENCODED);
        $credentials['password'] = filter_var($credentials['password'], FILTER_SANITIZE_ENCODED);
        $accountService = new AccountService();
        $accountService->checkLength($credentials, 'lastname', 45, 'last_length');
        $accountService->checkLength($credentials, 'firstname', 45, 'first_length');
        $accountService->checkLength($credentials, 'email', 100, 'email_length');
        $accountService->checkLength($credentials, 'address', 255, 'adress_length');
        $accountService->checkLength($credentials, 'pseudo', 20, 'pseudo_length');
        $accountService->checkLength($credentials, 'password', 20, 'password_length');
        $accountService->checkIfEmpty($credentials, 'firstname', 'empty_firstname');
        $accountService->checkIfEmpty($credentials, 'email', 'empty_email');
        $accountService->checkIfEmpty($credentials, 'pseudo', 'empty_pseudo');

        return $this->errors ?? [];
    }
}
