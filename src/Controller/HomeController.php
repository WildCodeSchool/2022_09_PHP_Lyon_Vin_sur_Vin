<?php

namespace App\Controller;

use App\Model\WineManager;

class HomeController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Home/index.html.twig', ['session' => $_SESSION]);
    }


    public function showCatalog(): string
    {

        $wineManager = new WineManager();
        $wines = $wineManager->getAllWithPartner();

        return $this->twig->render('Home/catalog.html.twig', ['wines' => $wines]);
    }

    public function searchCatalog($search): string
    {
        $search = trim($search);
        $wineManager = new WineManager();
        $wines = $wineManager->selectSearch($search);

        return $this->twig->render('Home/catalog.html.twig', ['wines' => $wines]);
    }
}
