<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    #[Route('/admin/picture', name: 'app_admin_picture')]
    public function index(): Response
    {
        return $this->render('admin/picture/index.html.twig', [
            'controller_name' => 'PictureController',
        ]);
    }
}
