<?php

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
    'login/admin' => ['AdminController', 'login',],
    'partners' => ['PartnerController', 'list',],
    'partners/edit' => ['PartnerController', 'edit', ['id']],
    'partners/show' => ['PartnerController', 'show', ['id']],
    'partners/add' => ['PartnerController', 'add',],
    'partners/delete' => ['PartnerController', 'delete',],
    'nospartenaires' => ['PartnerController', 'partnerList',],
    'wines/togglesuper' => ['WineController', 'toggleSuper', ['id']],
    'logout' => ['UserController', 'logout',],
    'login' => ['UserController', 'login',],
    'register' => ['UserController', 'register',],
    'login/professional' => ['ProController', 'login',],
    'register/professional' => ['ProController', 'setPassword', ['id']],
    'professional' => ['ProController', 'index', ['id']],
    'catalog' => ['HomeController', 'showCatalog',],
    'catalog/search' => ['HomeController', 'searchCatalog', ['search']],
    'onePartner' => ['PartnerController', 'partnerShow', ['id']],
];
