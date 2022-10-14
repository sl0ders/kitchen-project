<?php

namespace App\Entity;

use App\Repository\StepRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StepRepository::class)]
class Step
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $time = '';

    #[ORM\Column]
    private ?bool $isCooking = null;

    #[ORM\ManyToOne(inversedBy: 'steps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\ManyToOne(inversedBy: 'steps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipe = null;

    #[ORM\OneToMany(mappedBy: 'step', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'step', targetEntity: Mark::class)]
    private Collection $marks;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'step', targetEntity: Ingredients::class)]
    private Collection $ingredients;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->marks = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(?string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function isIsCooking(): ?bool
    {
        return $this->isCooking;
    }

    public function setIsCooking(bool $isCooking): self
    {
        $this->isCooking = $isCooking;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setStep($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getStep() === $this) {
                $comment->setStep(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mark>
     */
    public function getMarks(): Collection
    {
        return $this->marks;
    }

    public function addMark(Mark $mark): self
    {
        if (!$this->marks->contains($mark)) {
            $this->marks->add($mark);
            $mark->setStep($this);
        }

        return $this;
    }

    public function removeMark(Mark $mark): self
    {
        if ($this->marks->removeElement($mark)) {
            // set the owning side to null (unless already changed)
            if ($mark->getStep() === $this) {
                $mark->setStep(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Ingredients>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredients $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setStep($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredients $ingredient): self
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getStep() === $this) {
                $ingredient->setStep(null);
            }
        }

        return $this;
    }
}
