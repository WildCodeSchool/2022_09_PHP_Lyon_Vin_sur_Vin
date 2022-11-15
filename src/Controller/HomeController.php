<?php

namespace App\Controller;

use App\Model\WineManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        return $this->twig->render('Home/index.html.twig');
    }
    public function displayCatalog(): string
    {
        return $this->twig->render('Home/catalog.html.twig');
    }

    public function showCatalog(): string
    {

        $wineManager = new WineManager();
        $wines = $wineManager->selectAll();
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
