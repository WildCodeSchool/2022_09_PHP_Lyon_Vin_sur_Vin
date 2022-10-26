<?php

namespace App\Controller;

use App\Model\WineManager;

class WineController extends AbstractController
{
    public function list(): string
    {
        $wineManager = new WineManager();
        $wines = $wineManager->selectAll();

        return $this->twig->render('Wine/list.html.twig', ['wines' => $wines]);
    }

    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $wine = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $wineManager = new WineManager();
            $id = $wineManager->insert($wine);

            header('Location:/wines/show?id=' . $id);
            return null;
        }

        return $this->twig->render('Wine/add.html.twig');
    }
    
    public function delete(int $id)
    {
        $this->model->delete($id);
        header('Location:/wines/show?id=' . $id);
    }

}

