<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RecipeRepository;
use App\Repository\UserConsultationRepository;
use App\Repository\UserFavoriteRecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(UserConsultationRepository $userConsultationRepository, RecipeRepository $recipeRepository, UserFavoriteRecipeRepository $favoriteRecipeRepository): Response
    {
        $lastRecipeConsulting = [];
        $favoriteRecipeIds = [];
        $lastRecipe = $recipeRepository->findBy([], ['createdAt' => 'ASC'], 6);
        $lastConsultation = $userConsultationRepository->getLastConsultation($this->getUser());
        foreach ($lastConsultation as $consultation) {
            $lastRecipeConsulting[] = $consultation->getRecipe();
        }
        $favoriteUsers = $favoriteRecipeRepository->findBy(["user" => $this->getUser()]);
        foreach ($favoriteUsers as $favoriteUser) {
            $favoriteRecipeIds[] = $favoriteUser->getRecipe()->getId();
        }

        return $this->render('index.html.twig', [
           "lastRecipeConsulting" => $lastRecipeConsulting,
            "lastRecipe" => $lastRecipe,
            "favoritesUsersIds" => $favoriteRecipeIds
        ]);
    }

    #[Route('/Account/{firstname}', name: 'app_user_account')]
    public function userAccount(User $user): Response
    {
        return $this->render('user/account.html.twig', [
            'user' => $user,
        ]);
    }
}
