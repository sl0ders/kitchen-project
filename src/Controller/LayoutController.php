<?php

namespace App\Controller;

use App\Repository\NotifyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LayoutController extends AbstractController
{
    public function headerAction(NotifyRepository $repository): Response
    {
        $notifies = $repository->findBy(["receiver" => $this->getUser()], [], 10);
        return $this->render('layout/_header.html.twig', [
            "notifies" => $notifies
        ]);
    }

    public function leftSideAction(): Response
    {
        return $this->render('layout/_left-side.html.twig', []);
    }
}