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
}
