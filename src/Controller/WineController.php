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
}
