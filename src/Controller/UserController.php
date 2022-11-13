<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public array $errors = [];

    public function login(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            //      @todo make some controls on email and password fields and if errors, send them to the view
            $userManager = new UserManager();
            $this->errors = $this->checkUserFields($credentials);
            $user = $userManager->selectOneByEmail($credentials['email']);

            if ($user && password_verify($credentials['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: /');
                return null;
            }
            if ($user == false || !password_verify($credentials['password'], $user['password'])) {
                $this->errors['wrong'] = 'Les identifiants ne correspondent pas.';
            }
        }
        if (!empty($this->errors)) {
            return $this->twig->render('User/login.html.twig', ['errors' => $this->errors]);
        }

        return $this->twig->render('User/login.html.twig');
    }

    public function logout()
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['user_id']);
        header('Location: /');
    }

    public function register()
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
        $this->checkLength($credentials, 'lastname', 45, 'last_length');
        $this->checkLength($credentials, 'firstname', 45, 'first_length');
        $this->checkLength($credentials, 'email', 100, 'email_length');
        $this->checkLength($credentials, 'address', 250, 'adress_length');
        $this->checkLength($credentials, 'pseudo', 1000, 'pseudo_length');
        $this->checkLength($credentials, 'password', 1000, 'password_length');
        $this->checkIfEmpty($credentials, 'firstname', 'empty_firstname');
        $this->checkIfEmpty($credentials, 'email', 'empty_email');
        $this->checkIfEmpty($credentials, 'pseudo', 'empty_pseudo');

        if ((strlen($credentials['phone']) != 10) || (!filter_var($credentials['phone'], FILTER_VALIDATE_INT))) {
            $this->errors['phone'] = "Numéro invalide. Le numéro doit contenir 10 chiffres.";
        }
        return $this->errors ?? [];
    }
    public function checkLength(array $credentials, string $field, int $maxLength, string $key)
    {
        if (strlen($credentials[$field]) > $maxLength && isset($credentials[$field]) && !empty($credentials[$field])) {
            $this->errors[$key] = "C'est trop long, $maxLength caractères MAX";
        }
    }

    public function checkIfEmpty(array $credentials, string $field, string $key)
    {
        if (!isset($credentials[$field]) || empty($credentials[$field])) {
            $this->errors[$key] = "Ce champ est obligatoire";
        }
    }
    public function checkUserFields(array $credentials): array
    {

        if (empty($credentials['email'])) {
            $this->errors['empty_mail'] = 'Veuillez saisir votre adresse e-mail.';
        }

        if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "L'adresse e-mail saisie est incorrecte. ";
        }

        if (empty($credentials['password'])) {
            $this->errors['empty_password'] = 'Veuillez saisir votre mot de passe.';
        }

        if (strlen($credentials['password']) > 20) {
            $this->errors['password_length'] = 'Votre mot de passe ne peut faire plus de 20 caractères.';
        }

        return $this->errors;
    }
}
