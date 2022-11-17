<?php

namespace App\Controller;

use App\Model\PartnerManager;

class PartnerController extends AbstractController
{
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
        $partner['email'] = filter_var($partner['email'], FILTER_SANITIZE_ENCODED);
        $partner['address'] = filter_var($partner['address'], FILTER_SANITIZE_ENCODED);
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

    public function partnerList(): string
    {
        $partnersManager = new PartnerManager();
        $partnersForUsers = $partnersManager->selectAll();
        return $this->twig->render('Shared/partnersForUsers.html.twig', ['partnersForUser' => $partnersForUsers]);
    }

    public function partnerShow(int $id): string
    {
        $partnerManager = new PartnerManager();
        $partner = $partnerManager->selectOneById($id);

        $wineManager = new PartnerManager();
        $wines = $wineManager->showPartnerWine($id);

        return $this->twig->render('Shared/onePartner.html.twig', ['partner' => $partner, 'wines' => $wines]);
    }
}
