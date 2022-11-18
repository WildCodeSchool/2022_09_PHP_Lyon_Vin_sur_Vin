<?php

namespace App\Controller;

use App\Controller\AccountController;
use App\Model\WineManager;
use App\Model\PartnerManager;

class ProController extends AbstractController
{
    public function index(): ?string
    {
        if (!$this->pro) {
            echo 'Seuls les professionels ont accès à cette page';
            header('HTTP/1.1 401 Unauthorized');
            return null;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->add();
        }
        $wineManager = new WineManager();
        $wines = $wineManager->selectWinesFromPartner($this->pro['id']);

        return $this->twig->render(
            'Professional/pro_space.html.twig',
            ['wines' => $wines, 'session' => $_SESSION, 'errors' => $this->errors]
        );
    }
    public function add()
    {

        $wineManager = new WineManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $wine = array_map('trim', $_POST);
            $this->errors = $this->validate($wine);

            if (!empty($this->errors)) {
                return $this->twig->render('Professional/pro_space.html.twig', ['errors' => $this->errors]);
            }

            $wineManager->insert($wine);
            header('Location:/');
            return null;
        }
    }

    public function validate(array $wine): array
    {
        $wine['description'] = filter_var($wine['description'], FILTER_SANITIZE_ENCODED);
        $wine['name'] = filter_var($wine['name'], FILTER_SANITIZE_ENCODED);
        $accountController = new AccountController();
        $accountController->checkLength($wine, 'name', 100, 'name_length');
        $accountController->checkLength($wine, 'description', 1000, 'description_length');
        $accountController->checkIfEmpty($wine, 'name', 'empty_name');
        $accountController->checkIfEmpty($wine, 'price', 'empty_price');
        $accountController->checkIfEmpty($wine, 'year', 'empty_year');
        $accountController->checkIfEmpty($wine, 'color', 'empty_color');
        $accountController->checkIfEmpty($wine, 'region', 'empty_region');

        if (
            filter_var(
                $wine['year'],
                FILTER_VALIDATE_INT,
                array("options" => array("min_range" => 1901, "max_range" => 2023))
            ) === false
        ) {
            $this->errors['year'] = 'L\'année doit être comprise entre 1901 et 2023';
        }
        if (
            filter_var(
                $wine['price'],
                FILTER_VALIDATE_FLOAT,
                array("options" => array("min_range" => 1, "max_range" => 10000))
            ) === false
        ) {
            $this->errors['price'] = 'Le prix n\'est pas correct';
        }
        // A FAIRE : MODIFIER partner_id pour qu'il soit automatiquement associer à un partnenaire
        return $this->errors ?? [];
    }

    public function login(): ?string
    {
        session_destroy();

        if ($this->pro != false) {
            header('Location: /professional');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            //      @todo make some controls on email and password fields and if errors, send them to the view
            $partnerManager = new PartnerManager();
            $accountController = new AccountController();
            $this->errors = $accountController->checkLoginFields($credentials);
            $pro = $partnerManager->selectOneByEmail($credentials['email']);

            if ($pro && password_verify($credentials['password'], $pro['password'])) {
                $_SESSION['pro_id'] = $pro['id'];
                header('Location: /professional');
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

    public function setPassword()
    {
        $partnerManager = new PartnerManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            $partnerManager->selectOneByEmail($credentials['email']);
            $accountController = new AccountController();
            $this->errors = $accountController->checkLoginFields($credentials);
            if (empty($credentials['password']) || empty($credentials['password2'])) {
                $this->errors['do_not_match'] = 'Les deux mots de passe doivent être identiques';
            }
            if (!empty($thisunset($_SESSION['admin_id']);
            unset($_SESSION['pro_id']);->errors && $credentials['password'] === $credentials['password2'])) {
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
