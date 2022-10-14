<?php

namespace App\Controller\Admin;

use App\Entity\Mark;
use App\Form\MarkType;
use App\Repository\MarkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/mark')]
class MarkController extends AbstractController
{
    #[Route('/', name: 'admin_mark_index', methods: ['GET'])]
    public function index(MarkRepository $markRepository): Response
    {
        return $this->render('admin/mark/index.html.twig', [
            'marks' => $markRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_mark_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MarkRepository $markRepository): Response
    {
        $mark = new Mark();
        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $markRepository->add($mark, true);

            return $this->redirectToRoute('admin_mark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/mark/new.html.twig', [
            'mark' => $mark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_mark_show', methods: ['GET'])]
    public function show(Mark $mark): Response
    {
        return $this->render('admin/mark/show.html.twig', [
            'mark' => $mark,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_mark_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mark $mark, MarkRepository $markRepository): Response
    {
        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $markRepository->add($mark, true);

            return $this->redirectToRoute('admin_mark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/mark/edit.html.twig', [
            'mark' => $mark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_mark_delete', methods: ['POST'])]
    public function delete(Request $request, Mark $mark, MarkRepository $markRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mark->getId(), $request->request->get('_token'))) {
            $markRepository->remove($mark, true);
        }

        return $this->redirectToRoute('admin_mark_index', [], Response::HTTP_SEE_OTHER);
    }
}
