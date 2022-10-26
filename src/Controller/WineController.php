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
            // clean $_POST data
            $wine = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $wineManager->update($wine);

            header('Location: /wines/show?id=' . $id);

            // we are redirecting so we don't want any content rendered
            return null;
        }

        return $this->twig->render('Wine/edit.html.twig', [
            'wine' => $wine,
        ]);
    }
}
