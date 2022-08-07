<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/admin/comment', name: 'app_admin_comment')]
    public function index(): Response
    {
        return $this->render('admin/comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }
}
