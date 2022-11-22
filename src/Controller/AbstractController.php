<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use App\Model\AdminManager;
use App\Model\UserManager;
use App\Model\PartnerManager;

abstract class AbstractController
{
    public array $errors = [];
    protected Environment $twig;
    protected array|false $user;
    protected array|false $admin;
    protected array|false $pro;


    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => true,
            ]
        );
        $this->twig->addExtension(new DebugExtension());
        $userManager = new UserManager();
        $this->user = isset($_SESSION['user_id']) ? $userManager->selectOneById($_SESSION['user_id']) : false;
        $this->twig->addGlobal('user', $this->user);

        $adminManager = new AdminManager();
        $this->admin = isset($_SESSION['admin_id']) ? $adminManager->selectOneById($_SESSION['admin_id']) : false;
        $this->twig->addGlobal('admin', $this->admin);

        $proManager = new PartnerManager();
        $this->pro = isset($_SESSION['pro_id']) ? $proManager->selectOneById($_SESSION['pro_id']) : false;
        $this->twig->addGlobal('pro', $this->pro);
    }
}
