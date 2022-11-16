<?php

namespace App\Controller;

use App\Model\WineManager;

class WineController extends AbstractController
{
    public array $errors = [];

    public function list(): ?string
    {
        if (!$this->admin) {
            echo 'Seuls les administrateurs ont accès à cette page';
            header('HTTP/1.1 401 Unauthorized');
            return null;
        }
        $wineManager = new WineManager();
        $wines = $wineManager->selectAll();
        return $this->twig->render('Wine/list.html.twig', ['wines' => $wines]);
    }

    public function show(int $id): ?string
    {
        if (!$this->admin) {
            echo 'Seuls les administrateurs ont accès à cette page';
            header('HTTP/1.1 401 Unauthorized');
            return null;
        }
        $wineManager = new WineManager();
        $wine = $wineManager->selectOneWineById($id);
        return $this->twig->render('Wine/show.html.twig', ['wine' => $wine]);
    }

    public function edit(int $id): ?string
    {
        if (!$this->admin) {
            echo 'Seuls les administrateurs ont accès à cette page';
            header('HTTP/1.1 401 Unauthorized');
            return null;
        }
        $wineManager = new WineManager();
        $wine = $wineManager->selectOneById($id);
        $partners = $wineManager->selectPartner();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $wine = array_map('trim', $_POST);
            $this->errors = $this->validate($wine);
            if (!empty($this->errors)) {
                return $this->twig->render(
                    'Wine/edit.html.twig',
                    ['errors' => $this->errors, 'wine' => $wine, 'partners' => $partners]
                );
            }
            $wineManager->update($wine);
            header('Location: /wines/show?id=' . $id);
            return null;
        }
        return $this->twig->render('Wine/edit.html.twig', ['wine' => $wine, 'partners' => $partners]);
    }

    public function add(): ?string
    {
        if (!$this->admin) {
            echo 'Seuls les administrateurs ont accès à cette page';
            header('HTTP/1.1 401 Unauthorized');
            return null;
        }
        $wineManager = new WineManager();
        $partners = $wineManager->selectPartner();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $wine = array_map('trim', $_POST);
            $this->errors = $this->validate($wine);

            if (!empty($this->errors)) {
                return $this->twig->render('Wine/add.html.twig', ['errors' => $this->errors, 'partners' => $partners]);
            }

            $id = $wineManager->insert($wine);
            header('Location:/wines/show?id=' . $id);
            return null;
        }
        return $this->twig->render('Wine/add.html.twig', ['partners' => $partners]);
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $wineManager = new WineManager();
            $wineManager->delete((int)$id);
            header('Location:/wines');
        }
    }

    public function validate(array $wine): array
    {
        $wine['description'] = filter_var($wine['description'], FILTER_SANITIZE_ENCODED);
        $wine['name'] = filter_var($wine['name'], FILTER_SANITIZE_ENCODED);
        $this->checkLength($wine, 'name', 100, 'name_length');
        $this->checkLength($wine, 'description', 1000, 'description_length');
        $this->checkIfEmpty($wine, 'name', 'empty_name');
        $this->checkIfEmpty($wine, 'price', 'empty_price');
        $this->checkIfEmpty($wine, 'year', 'empty_year');
        $this->checkIfEmpty($wine, 'color', 'empty_color');
        $this->checkIfEmpty($wine, 'region', 'empty_region');

        if (
            filter_var(
                $wine['year'],
                FILTER_VALIDATE_INT,
                array("options" => array("min_range" => 1901, "max_range" => 2023))
            ) === false
        ) {
            $this->errors['year'] = 'L\'année doit être comprise entre 1901 et 2023';
        }
        //verification que le prix contient bien un point et accepte la virgule

        $wine['price'] = (strpos($wine['price'], ","))?str_replace(",",".",$wine['price']):$wine['price']; 
        if (
            filter_var(
                $wine['price'],                
                FILTER_VALIDATE_FLOAT,
                array("options" => array("min_range" => 1, "max_range" => 10000)),
            ) === false
        ) {
            $this->errors['price'] = 'Le prix n\'est pas correct';
            
        }
        if (!isset($wine['partner_id']) || empty($wine['partner_id'])) {
            $this->errors['partner'] = "Veuillez sélectionner un partenaire";
        }
        // A FAIRE : MODIFIER partner_id pour qu'il soit automatiquement associer à un partnenaire
        var_dump($wine['price']);
       
        return $this->errors ?? [];
    }
    public function checkLength(array $wine, string $field, int $maxLength, string $key)
    {
        if (strlen($wine[$field]) > $maxLength && isset($wine[$field]) && !empty($wine[$field])) {
            $this->errors[$key] = "C'est trop long, $maxLength caractères MAX";
        }
    }

    public function checkIfEmpty(array $wine, string $field, string $key)
    {
        if (!isset($wine[$field]) || empty($wine[$field])) {
            $this->errors[$key] = "Ce champ est aussi vide que mon verre";
        }
    }

    public function showFavorites(): string
    {
        $wineManager = new WineManager();
        $wines = $wineManager->selectFavorites();
        return $this->twig->render('Home/index.html.twig', ['wines' => $wines]);
    }

    public function toggleSuper(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $wineManager = new WineManager();
            $isSuper = $wineManager->checkIfFavorite((int)$id);
            if ($isSuper['favorite'] === 1) {
                $wineManager->deleteFavorite((int)$id);
                header('Location:/wines');
            } else {
                $wineManager->addFavorite((int)$id);
                header('Location:/wines');
            }
        }
    }
}
