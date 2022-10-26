<?php

namespace App\Controller;

use App\Model\PartnerManager;

class PartnerController extends AbstractController
{
    public function list(): string
    {
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

    public function edit(int $id): ?string
    {
        $partnerManager = new PartnerManager();
        $partner = $partnerManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $partner = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $partnerManager->update($partner);

            header('Location: /partner/show?id=' . $id);

            return null;
        }

        return $this->twig->render('partner/edit.html.twig', [
            'partner' => $partner,
        ]);
    }
}
