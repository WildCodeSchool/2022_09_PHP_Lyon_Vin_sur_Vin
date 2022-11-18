<?php

namespace App\Controller;

class AccountController
{
    public array $errors = [];

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }

    public function checkLoginFields(array $credentials): array
    {

        if (empty($credentials['email'])) {
            $this->errors['empty_email'] = 'Veuillez saisir votre adresse e-mail.';
        }

        if ((!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) && !empty($credentials['email'])) {
            $this->errors['email'] = "L'adresse e-mail saisie est incorrecte. ";
        }

        if (empty($credentials['password'])) {
            $this->errors['empty_password'] = 'Veuillez saisir votre mot de passe.';
        }

        if ((strlen($credentials['password']) > 20) && !empty($credentials['password'])) {
            $this->errors['password_length'] = 'Votre mot de passe ne peut faire plus de 20 caractères.';
        }

        return $this->errors;
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
}
