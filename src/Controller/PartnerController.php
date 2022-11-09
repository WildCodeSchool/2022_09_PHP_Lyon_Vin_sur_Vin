<?php

namespace App\Controller;

use App\Model\PartnerManager;


class PartnerController extends AbstractController
{

    public function list(): string
    {
        if (!$this->admin) {
            echo 'Seuls les adminsitrateurs ont accès à cette page';
            header('HTTP/1.1 401 Unauthorized');
            exit();
        }        
        $partnerManager = new PartnerManager();
        $partners = $partnerManager->selectAll();

        return $this->twig->render('Partner/list.html.twig', ['partners' => $partners]);
    }

    public function show(int $id): string
    {
        $partnerManager = new PartnerManager();
        $partner = $partnerManager->selectOneById($id);

        return $this->twig->render('Partner/show.html.twig', ['partner' => $partner]);
    }

    public function add(): ?string
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data

            $partner = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $partnerManager = new PartnerManager();
            $id = $partnerManager->insert($partner);

            header('Location:/partners/show?id=' . $id);
            return null;
        }

        return $this->twig->render('Partner/add.html.twig');
    }

    public function edit(int $id): ?string
    {
        $partnerManager = new PartnerManager();
        $partner = $partnerManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $partner = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $partnerManager->update($partner);

            header('Location: /partners/show?id=' . $id);

            return null;
        }

        return $this->twig->render('Partner/edit.html.twig', [
            'partner' => $partner,
        ]);
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $partnerManager = new PartnerManager();
            $partnerManager->delete((int)$id);

            header('Location:/partners');
        }
    }
}
