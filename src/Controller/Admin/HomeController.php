<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Admin')]
class HomeController extends AbstractController
{
    #[Route('/', name: "admin_homePage")]
    public function index() {
        return $this->render("admin/index.html.twig", [

        ]);
    }
}