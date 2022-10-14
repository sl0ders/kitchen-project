<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LayoutController extends AbstractController
{
    public function headerAction(): Response
    {
        return $this->render('admin/layout/_header.html.twig', []);
    }

    public function leftSideAction(): Response
    {
        return $this->render('admin/layout/_left-side.html.twig', []);
    }
}