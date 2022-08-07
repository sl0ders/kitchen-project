<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    #[Route('/admin/ingredient', name: 'app_admin_ingredient')]
    public function index(): Response
    {
        return $this->render('admin/ingredient/index.html.twig', [
            'controller_name' => 'IngredientController',
        ]);
    }
}
