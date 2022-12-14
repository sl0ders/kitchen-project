<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[UniqueEntity(fields: "title", message: "constraint.Recipe.unique", errorPath: "title")]
#[Vich\Uploadable]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 70, maxMessage: "constraint.recipe.title.length.max")]
    #[Assert\NotBlank(message: "constraint.recipe.title.notBlank")]
    private ?string $title = null;


    #[Vich\UploadableField(mapping:"backgroundRecipe", fileNameProperty:"backgroundFilename" )]
    #[Assert\File]
    private $backgroundFile;

    #[ORM\Column(type: 'string')]
    private $backgroundFilename;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updateAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $resume = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\Column]
    private ?bool $enabled = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Step::class, orphanRemoval: true)]
    private Collection $steps;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Mark::class)]
    private Collection $marks;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Picture::class, cascade:["persist"])]
    private Collection $pictures;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: RecipeParticipation::class)]
    private Collection $recipeParticipations;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: UserConsultation::class, orphanRemoval: true)]
    private Collection $userConsultations;

    #[ORM\Column(length: 255)]
    private ?string $pathBackground = null;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->marks = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->recipeParticipations = new ArrayCollection();
        $this->userConsultations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

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

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getUpdateAt(): ?DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): self
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): self
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

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
            $comment->setRecipe($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getRecipe() === $this) {
                $comment->setRecipe(null);
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
            $mark->setRecipe($this);
        }

        return $this;
    }

    public function removeMark(Mark $mark): self
    {
        if ($this->marks->removeElement($mark)) {
            // set the owning side to null (unless already changed)
            if ($mark->getRecipe() === $this) {
                $mark->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setRecipe($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getRecipe() === $this) {
                $picture->setRecipe(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }

    /**
     * @return Collection<int, RecipeParticipation>
     */
    public function getRecipeParticipations(): Collection
    {
        return $this->recipeParticipations;
    }

    public function addRecipeParticipation(RecipeParticipation $recipeParticipation): self
    {
        if (!$this->recipeParticipations->contains($recipeParticipation)) {
            $this->recipeParticipations->add($recipeParticipation);
            $recipeParticipation->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeParticipation(RecipeParticipation $recipeParticipation): self
    {
        if ($this->recipeParticipations->removeElement($recipeParticipation)) {
            // set the owning side to null (unless already changed)
            if ($recipeParticipation->getRecipe() === $this) {
                $recipeParticipation->setRecipe(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, UserConsultation>
     */
    public function getUserConsultations(): Collection
    {
        return $this->userConsultations;
    }

    public function addUserConsultation(UserConsultation $userConsultation): self
    {
        if (!$this->userConsultations->contains($userConsultation)) {
            $this->userConsultations->add($userConsultation);
            $userConsultation->setRecipe($this);
        }

        return $this;
    }

    public function removeUserConsultation(UserConsultation $userConsultation): self
    {
        if ($this->userConsultations->removeElement($userConsultation)) {
            // set the owning side to null (unless already changed)
            if ($userConsultation->getRecipe() === $this) {
                $userConsultation->setRecipe(null);
            }
        }

        return $this;
    }

    public function getBackgroundFilename()
    {
        return $this->backgroundFilename;
    }

    public function setBackgroundFilename($backgroundFilename)
    {
        $this->backgroundFilename = $backgroundFilename;

        return $this;
    }

    public function setBackgroundFile(File $backgroundFilename = null): void
    {
        $this->backgroundFile = $backgroundFilename;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($backgroundFilename) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updateAt = new \DateTime('now');
        }
    }

    public function getBackgroundFile()
    {
        return $this->backgroundFile;
    }

    public function getPathBackground(): ?string
    {
        return $this->pathBackground;
    }

    public function setPathBackground(string $pathBackground): self
    {
        $this->pathBackground = $pathBackground;

        return $this;
    }
}
