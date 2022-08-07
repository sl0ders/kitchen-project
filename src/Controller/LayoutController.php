<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LayoutController extends AbstractController
{
    public function headerAction(): Response
    {
        ;        return $this->render('layout/_header.html.twig', [
    ]);
    }

    public function leftSideAction(): Response
    {
        return $this->render('layout/_left-side.html.twig', []);
    }
}