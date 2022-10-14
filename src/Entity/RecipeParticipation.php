<?php

namespace App\Entity;

use App\Repository\RecipeParticipationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeParticipationRepository::class)]
class RecipeParticipation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipeParticipations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipe = null;

    #[ORM\ManyToOne(inversedBy: 'recipeParticipations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
