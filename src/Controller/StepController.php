<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Step')]
class StepController extends AbstractController
{
    #[Route('/', name: 'app_admin_step')]
    public function index(): Response
    {
        return $this->render('step/index.html.twig', [
            'controller_name' => 'StepController',
        ]);
    }
}
