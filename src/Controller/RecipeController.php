<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Entity\Mark;
use App\Entity\Notify;
use App\Entity\Picture;
use App\Entity\Recipe;
use App\Entity\Step;
use App\Entity\UserConsultation;
use App\Entity\UserFavoriteRecipe;
use App\Form\RecipeType;
use App\Repository\MarkRepository;
use App\Repository\RecipeRepository;
use App\Repository\UserConsultationRepository;
use App\Repository\UserFavoriteRecipeRepository;
use App\Repository\UserRepository;
use App\Services\FileUploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route("/Recipe")]
class RecipeController extends AbstractController
{
    private TranslatorInterface $translator;
    private FileUploader $fileUploader;

    public function __construct(TranslatorInterface $translator, FileUploader $fileUploader)
    {
        $this->translator = $translator;
        $this->fileUploader = $fileUploader;
    }

    #[Route('/', name: 'app_recipes_index')]
    public function index(RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/Show/{id}', name: 'app_recipe_show')]
    public function show(Recipe $recipe, UserConsultationRepository $userConsultationRepository, EntityManagerInterface $em): Response
    {
        $userConsulting = $userConsultationRepository->findOneBy(["user" => $this->getUser(), "recipe" => $recipe]);
        if ($userConsulting == null) {
            $userConsulting = new UserConsultation();
            $userConsulting->setUser($this->getUser());
            $userConsulting->setRecipe($recipe);
            $userConsulting->setConsultationAt(new DateTime());
            $em->persist($userConsulting);
        }
        $em->flush();
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/New', name: 'app_recipe_new')]
    public function new(Request $request, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        $stepList = [];
        $recipe = new Recipe();
        if ($request->isXmlHttpRequest()) {
            if ($request->get("stepArray")) {
                $steps = $request->get("stepArray");
                foreach ($steps as $step) {
                    $newStep = new Step();
                    $newStep->setContent($step["content"]);
                    $newStep->setTime($step["time"]);
                    $newStep->setTitle($step["title"]);
                    $newStep->setIsCooking($step["cooking"]);
                    $newStep->setAuthor($this->getUser());

                    if ($request->get("ingredientArray")) {
                        $ingredients = $request->get("ingredientArray");
                        foreach ($ingredients as $ingredient) {
                            $newingredient = new Ingredients();
                            $newingredient->setName($ingredient["name"]);
                            $newingredient->setQuantity($ingredient["quantity"]);
                            $newingredient->setUnity($ingredient["unity"]);
                            $em->persist($newingredient);
                            $step->addIngredient($newingredient);
                        }
                    }
                    $em->persist($newStep);
                    $stepList[] = $newStep;
                }
            }
        }
        $formRecipe = $this->createForm(RecipeType::class, $recipe);
        $formRecipe->handleRequest($request);
        if ($formRecipe->isSubmitted() && $formRecipe->isValid()) {
            $backgroundRecipe = $formRecipe->get('backgroundPicture')->getData();
            if ($backgroundRecipe) {
                $backgroundRecipeFileName = $this->fileUploader->upload($backgroundRecipe, "background");
                $recipe->setBackgroundFilename($backgroundRecipeFileName[0]);
                $recipe->setPathBackground($backgroundRecipeFileName[1]);
            }
            $picturesRecipe = $formRecipe->get('pictures')->getData();
            if ($picturesRecipe) {
            foreach ($picturesRecipe as $picture) {
                    $picturesRecipeFileName = $this->fileUploader->upload($picture, "picture");
                    $picture = new Picture();
                    $picture->setUrl($picturesRecipeFileName[1]);
                    $picture->setExtention($picturesRecipeFileName[2]);
                    $picture->setFileName($picturesRecipeFileName[0]);
                    $recipe->addPicture($picture);
                }
            }
            $recipe->setCreatedAt(new DateTime());
            $recipe->setAuthor($this->getUser());
            $recipe->setEnabled(false);
            $notify = new Notify();
            $messageNotify = $this->translator->trans("notify.success.objectCreated", ["%object%" => "recette"], "kitchen-project");
            $notify->setContent($messageNotify);
            $notify->setEnabled(true);
            $notify->setReason($messageNotify);
            $userAdmin = $userRepository->findOneBy(["roles" => "[ROLE_ADMIN]"]);
            $notify->setReceiver($userAdmin);
            if (count($stepList) > 0) {
                foreach ($stepList as $step)
                    $recipe->addStep($step);
            }
            $em->persist($recipe);
            $em->flush();
            $message = $this->translator->trans("recipe.success.create", [], "kitchen-project");
            $this->addFlash("success", $message);
            return $this->redirectToRoute("app_recipe_show", ["id" => $recipe->getId()]);
        }
        return $this->render('recipe/new.html.twig', [
            'formRecipe' => $formRecipe->createView()
        ]);
    }

    #[Route("/add-like/{id}", name: "addLike")]
    public function addLike(Recipe $recipe, EntityManagerInterface $em, MarkRepository $markRepository): RedirectResponse
    {
        $mark = $markRepository->findOneBy(["marker" => $this->getUser(), "recipe" => $recipe]);
        if ($mark instanceof Mark) {
            return $this->redirectToRoute("recipes");
        }
        $mark = new Mark();
        $mark->setMarker($this->getUser());
        $mark->setRecipe($recipe);
        $mark->setCreatedAt(new DateTime());
        $mark->setQuantity($mark->getQuantity() + 1);
        $em->persist($mark);
        $recipe->addMark($mark);
        $em->persist($recipe);
        $em->flush();
        $message = $this->translator->trans("message.addLikeRecipeSuccessfully", [], "kitchen-project");
        return $this->redirectToRoute("recipes", ["message" => $message]);
    }

    #[Route("/change-favorite/{id}", name: "change_favorite")]
    public function addFavorite(Recipe $recipe, EntityManagerInterface $em, UserFavoriteRecipeRepository $favoriteRecipeRepository): RedirectResponse
    {
        $favoriteLink = $favoriteRecipeRepository->findOneBy(["user" => $this->getUser(), "recipe" => $recipe]);
        if (!$favoriteLink instanceof UserFavoriteRecipe) {
            $favoriteLink = new UserFavoriteRecipe();
            $favoriteLink->setRecipe($recipe);
            $favoriteLink->setUser($this->getUser());
            $em->persist($favoriteLink);
            $message = $this->translator->trans("message.addFavoriteRecipeSuccessfully", [], "kitchen-project");
        } else {
            $em->remove($favoriteLink);
            $message = $this->translator->trans("message.removeFavoriteRecipeSuccessfully", [], "kitchen-project");
            $em->flush();
        }
        $em->flush();
        $this->addFlash("success", $message);
        return $this->redirectToRoute("app_home");
    }
}
