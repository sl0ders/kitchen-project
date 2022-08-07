<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarkController extends AbstractController
{
    #[Route('/admin/mark', name: 'app_admin_mark')]
    public function index(): Response
    {
        return $this->render('admin/mark/index.html.twig', [
            'controller_name' => 'MarkController',
        ]);
    }
}
