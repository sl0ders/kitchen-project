<?php

namespace App\Controller\Admin;

use App\Entity\Ingredients;
use App\Form\IngredientsType;
use App\Repository\IngredientsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ingredients')]
class IngredientsController extends AbstractController
{
    #[Route('/', name: 'admin_ingredients_index', methods: ['GET'])]
    public function index(IngredientsRepository $ingredientsRepository): Response
    {
        return $this->render('admin/ingredients/index.html.twig', [
            'ingredients' => $ingredientsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_ingredients_new', methods: ['GET', 'POST'])]
    public function new(Request $request, IngredientsRepository $ingredientsRepository): Response
    {
        $ingredient = new Ingredients();
        $form = $this->createForm(IngredientsType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredientsRepository->add($ingredient, true);

            return $this->redirectToRoute('admin_ingredients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/ingredients/new.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_ingredients_show', methods: ['GET'])]
    public function show(Ingredients $ingredient): Response
    {
        return $this->render('admin/ingredients/show.html.twig', [
            'ingredient' => $ingredient,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_ingredients_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ingredients $ingredient, IngredientsRepository $ingredientsRepository): Response
    {
        $form = $this->createForm(IngredientsType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredientsRepository->add($ingredient, true);

            return $this->redirectToRoute('admin_ingredients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/ingredients/edit.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_ingredients_delete', methods: ['POST'])]
    public function delete(Request $request, Ingredients $ingredient, IngredientsRepository $ingredientsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingredient->getId(), $request->request->get('_token'))) {
            $ingredientsRepository->remove($ingredient, true);
        }

        return $this->redirectToRoute('admin_ingredients_index', [], Response::HTTP_SEE_OTHER);
    }
}
