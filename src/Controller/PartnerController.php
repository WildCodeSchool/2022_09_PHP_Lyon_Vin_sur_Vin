<?php

namespace App\Controller;

use App\Model\PartnerManager;

class PartnerController extends AbstractController
{
    public array $errors = [];

    public function list(): ?string
    {
        if (!$this->admin) {
            echo 'Seuls les administrateurs ont accès à cette page';
            header('HTTP/1.1 401 Unauthorized');
            return null;
        }
        $partnerManager = new PartnerManager();
        $partners = $partnerManager->selectAll();

        return $this->twig->render('Partner/list.html.twig', ['partners' => $partners]);
    }

    public function show(int $id): ?string
    {
        if (!$this->admin) {
            echo 'Seuls les administrateurs ont accès à cette page';
            header('HTTP/1.1 401 Unauthorized');
            return null;
        }
        $partnerManager = new PartnerManager();
        $partner = $partnerManager->selectOneById($id);

        return $this->twig->render('Partner/show.html.twig', ['partner' => $partner]);
    }

    public function add(): ?string
    {
        if (!$this->admin) {
            echo 'Seuls les administrateurs ont accès à cette page';
            header('HTTP/1.1 401 Unauthorized');
            return null;
        }
        $partnerManager = new PartnerManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $partner = array_map('trim', $_POST);
            $this->errors = $this->validate($partner);

            if (!empty($this->errors)) {
                return $this->twig->render('Partner/add.html.twig', ['errors' => $this->errors]);
            }
            $id = $partnerManager->insert($partner);

            header('Location:/partners/show?id=' . $id);
            return null;
        }

        return $this->twig->render('Partner/add.html.twig');
    }

    public function edit(int $id): ?string
    {
        if (!$this->admin) {
            echo 'Seuls les administrateurs ont accès à cette page';
            header('HTTP/1.1 401 Unauthorized');
            return null;
        }
        $partnerManager = new PartnerManager();
        $partner = $partnerManager->selectOneById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $partner = array_map('trim', $_POST);
            $this->errors = $this->validate($partner);

            if (!empty($this->errors)) {
                return $this->twig->render(
                    'Partner/edit.html.twig',
                    ['errors' => $this->errors, 'partner' => $partner],
                );
            }
            $partnerManager->update($partner);
            header('Location:/partners/show?id=' . $id);
            return null;
        }

        return $this->twig->render('Partner/edit.html.twig', ['partner' => $partner,]);
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $partnerManager = new PartnerManager();
            $partnerManager->delete((int)$id);

            header('Location:/partners');
        }
    }
    public function validate(array $partner): array
    {
        $partner['description'] = filter_var($partner['description'], FILTER_SANITIZE_ENCODED);
        $partner['lastname'] = filter_var($partner['lastname'], FILTER_SANITIZE_ENCODED);
        $partner['firstname'] = filter_var($partner['firstname'], FILTER_SANITIZE_ENCODED);
        $this->checkLength($partner, 'lastname', 100, 'last_length');
        $this->checkLength($partner, 'firstname', 100, 'first_length');
        $this->checkLength($partner, 'email', 100, 'email_length');
        $this->checkLength($partner, 'address', 250, 'adress_length');
        $this->checkLength($partner, 'description', 1000, 'description_length');
        $this->checkIfEmpty($partner, 'lastname', 'empty_lastname');
        $this->checkIfEmpty($partner, 'firstname', 'empty_firstname');
        $this->checkIfEmpty($partner, 'email', 'empty_email');
        $this->checkIfEmpty($partner, 'address', 'empty_address');
        $this->checkIfEmpty($partner, 'phone', 'empty_phone');

        if (!filter_var($partner['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'L\'email n\'est pas valide';
        }

        if (!filter_var($partner['phone'], FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[0-9]{10}+$/"]])) {
            $this->errors['phone'] = "Numéro invalide. Le numéro doit contenir 10 chiffres.";
        }
        return $this->errors ?? [];
    }
    public function checkLength(array $partner, string $field, int $maxLength, string $key)
    {
        if (strlen($partner[$field]) > $maxLength && isset($partner[$field]) && !empty($partner[$field])) {
            $this->errors[$key] = "C'est trop long, $maxLength caractères MAX";
        }
    }

    public function checkIfEmpty(array $partner, string $field, string $key)
    {
        if (!isset($partner[$field]) || empty($partner[$field])) {
            $this->errors[$key] = "Ce champ est aussi vide que mon verre";
        }
    }
    public function login(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            //      @todo make some controls on email and password fields and if errors, send them to the view
            $partnerManager = new PartnerManager();
            $this->errors = $this->checkProFields($credentials);
            $pro = $partnerManager->selectOneByEmail($credentials['email']);

            if ($pro && password_verify($credentials['password'], $pro['password'])) {
                $_SESSION['pro_id'] = $pro['id'];
                header('Location: /');
                return null;
            }

            if ($pro == false || !password_verify($credentials['password'], $pro['password'])) {
                $this->errors['wrong'] = 'L\'email et le mot de passe ne correspondent pas.';
            }
        }
        if (!empty($this->errors)) {
            return $this->twig->render('Professional/login.html.twig', ['errors' => $this->errors]);
        }

        return $this->twig->render('Professional/login.html.twig');
    }

    public function checkProFields(array $credentials): array
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

    public function setPassword()
    {
        $partnerManager = new PartnerManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            $partnerManager->selectOneByEmail($credentials['email']);
            if (empty($credentials['password']) || empty($credentials['password2'])) {
                $this->errors['empty_password'] = 'Veuillez saisir votre mot de passe.';
            }
            if ((!empty($credentials['email'])) && (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL))) {
                $this->errors['email'] = "L'adresse e-mail saisie est incorrecte. ";
            }
            if (!empty($this->errors && $credentials['password'] === $credentials['password2'])) {
                return $this->twig->render('Professional/set_password.html.twig', ['errors' => $this->errors]);
            }
                //      @todo make some controls and if errors send them to the view
            if (empty($this->errors)) {
                $partnerManager->addPassword($credentials);
                return $this->login();
            }
        }
        return $this->twig->render('Professional/set_password.html.twig');
    }
}
