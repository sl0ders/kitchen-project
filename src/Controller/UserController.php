<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RecipeParticipationRepository;
use App\Repository\RecipeRepository;
use App\Repository\UserFavoriteRecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/User')]
class UserController extends AbstractController
{
    #[Route("/MesRecettes/{firstname}", name: "user_recipe")]
    public function userRecipe(User $user, RecipeRepository $recipeRepository): Response
    {
        $userRecipes = $recipeRepository->findBy(["author" => $user]);
        return $this->render("user/myRecipe.html.twig", [
            "userRecipes" => $userRecipes
        ]);
    }

    #[Route("/MesParticipation/{firstname}", name: "user_participation")]
    public function userParticipation(User $user, RecipeParticipationRepository $recipeParticipationRepository): Response
    {
        $userParticipations = $recipeParticipationRepository->findBy(["user" => $user]);
        $recipes = [];
        foreach ($userParticipations as $userParticipation) {
            $recipes[] = $userParticipation->getRecipe();
        }
        return $this->render("user/userParticipation.html.twig", [
            'recipes' => $recipes
        ]);
    }

    #[Route("/mesFavorite/{firstname}", name: "user_favorite")]
    public function userFavorite(User $user, UserFavoriteRecipeRepository $recipeFavoriteRepository): Response
    {
        $userFavorites = $recipeFavoriteRepository->findBy(["user" => $user]);
        $recipes = [];
        foreach ($userFavorites as $userFavorite) {
            $recipes[] = $userFavorite->getRecipe();
        }
        return $this->render("user/userFavorite.html.twig", [
            'recipes' => $recipes
        ]);
    }


}