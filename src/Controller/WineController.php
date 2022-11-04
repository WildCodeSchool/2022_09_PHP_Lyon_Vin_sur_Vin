<?php

namespace App\Controller;

use App\Model\WineManager;

class WineController extends AbstractController
{
    private array $errors = [];


    public function list(): string
    {
        $wineManager = new WineManager();
        $wines = $wineManager->selectAll();
        return $this->twig->render('Wine/list.html.twig', ['wines' => $wines]);
    }

    public function show(int $id): string
    {
        $wineManager = new WineManager();
        $wine = $wineManager->selectOneById($id);
        return $this->twig->render('Wine/show.html.twig', ['wine' => $wine]);
    }

    public function edit(int $id): ?string
    {
        $wineManager = new WineManager();
        $wine = $wineManager->selectOneById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $wine = array_map('trim', $_POST);
            $this->errors = $this->validate($wine);
            if (empty($this->errors)) {
                return $this->twig->render('Wine/edit.html.twig', ['errors' => $this->errors]);
            }
            $wineManager->update($wine);
            header('Location: /wines/show?id=' . $id);
            return null;
        }
        return $this->twig->render('Wine/edit.html.twig', ['wine' => $wine]);
    }

    public function add(): ?string
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $wine = array_map('trim', $_POST);
            $this->errors = $this->validate($wine);

            if (!empty($this->errors)) {
                return $this->twig->render('Wine/add.html.twig', ['errors' => $this->errors]);
            }
            $wineManager = new WineManager();
            $id = $wineManager->insert($wine);
            header('Location:/wines/show?id=' . $id);
            return null;
        }
        return $this->twig->render('Wine/add.html.twig');
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
        $this->checkInputValues($wine, 'name', 100);
        $this->checkInputValues($wine, 'year', 4);
        $this->checkInputValues($wine, 'price', 1000);
        $this->checkInputValues($wine, 'partner_id', 100);

        if (strlen($wine['description']) > 1000) {
            $this->errors[] = 'C\'est trop long, 1000 caractères MAX';
        }
        if (
            filter_var(
                $wine['year'],
                FILTER_VALIDATE_INT,
                array("options" => array("min_range" => 1800, "max_range" => 2022))
            ) === false
        ) {
            $this->errors[] = 'L\'année doit être comprise entre 1800 et 2023';
        }
        if (
            filter_var(
                $wine['price'],
                FILTER_VALIDATE_FLOAT,
                array("options" => array("min_range" => 1, "max_range" => 10000))
            ) === false
        ) {
            $this->errors[] = 'Le prix n\'est pas correct';
        }
        if (!filter_var($wine['partner_id'], FILTER_VALIDATE_INT)) {
            $this->errors[] = "Seuls les chiffres sont acceptés.";
        }
        // A FAIRE : MODIFIER partner_id pour qu'il soit automatiquement associer à un partnenaire
        return $this->errors ?? [];
    }

    public function checkInputValues(array $wine, string $field, int $maxLength)
    {
        if (!isset($wine[$field]) || empty($wine[$field])) {
            $this->errors[] = "Ce champ est aussi vide que mon verre";
        }
        if (strlen($wine[$field]) > $maxLength) {
            $this->errors[] = "C'est trop long, $maxLength caractères MAX";
        }
    }
    public function showFavorites(): string
    {
        $wineManager = new WineManager();
        $wines = $wineManager->selectFavorites();
        return $this->twig->render('Home/index.html.twig', ['wines' => $wines]);
    }

    public function addSuper(): void
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $wineManager = new WineManager();
            $wineManager->addFavorite((int)$id);
            header('Location:/wines');
        }
    }

    public function deleteSuper(): void
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $wineManager = new WineManager();
            $wineManager->deleteFavorite((int)$id);
            header('Location:/wines');
        }
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
