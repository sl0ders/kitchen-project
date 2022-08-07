<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StepController extends AbstractController
{
    #[Route('/admin/step', name: 'app_admin_step')]
    public function index(): Response
    {
        return $this->render('admin/step/index.html.twig', [
            'controller_name' => 'StepController',
        ]);
    }
}
