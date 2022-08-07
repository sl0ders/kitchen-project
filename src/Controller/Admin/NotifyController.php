<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotifyController extends AbstractController
{
    #[Route('/admin/notify', name: 'app_admin_notify')]
    public function index(): Response
    {
        return $this->render('admin/notify/index.html.twig', [
            'controller_name' => 'NotifyController',
        ]);
    }
}