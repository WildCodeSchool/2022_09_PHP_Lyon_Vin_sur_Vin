<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['WineController', 'showFavorites',],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
    'wines' => ['WineController', 'list',],
    'wines/show' => ['WineController', 'show', ['id']],
    'wines/edit' => ['WineController', 'edit', ['id']],
    'wines/add' => ['WineController', 'add',],
    'wines/delete' => ['WineController', 'delete',],
    'admin' => ['AdminController', 'index',],
    'partners' => ['PartnerController', 'list',],
    'partners/edit' => ['PartnerController', 'edit', ['id']],
    'partners/show' => ['PartnerController', 'show', ['id']],
    'partners/add' => ['PartnerController', 'add',],
    'partners/delete' => ['PartnerController', 'delete',],
    'wines/togglesuper' => ['WineController', 'toggleSuper', ['id']],
    'catalog' => ['HomeController', 'showCatalog'],
    'catalog/search' => ['HomeController', 'searchCatalog'],



];
