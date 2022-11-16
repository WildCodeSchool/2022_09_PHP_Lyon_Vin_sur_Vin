<?php

namespace App\Controller;

class AccountService extends AbstractController
{
    public function logout()
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['user_id']);
        unset($_SESSION['pro_id']);
        header('Location: /');
    }

    public function checkLoginFields(array $credentials): array
    {

        if (empty($credentials['email']) || !isset($credentials['email'])) {
            $this->errors['empty_email'] = 'Veuillez saisir votre adresse e-mail.';
        }

        if ((!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) && !empty($credentials['email'])) {
            $this->errors['email'] = "L'adresse e-mail saisie est incorrecte. ";
        }

        if (empty($credentials['password']) || !isset($credentials['password'])) {
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
