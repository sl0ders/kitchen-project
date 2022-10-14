<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
#[Vich\Uploadable]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping:"pictureRecipe", fileNameProperty:"url" )]
    #[Assert\File]
    private $pictureFile;

    #[ORM\Column(type: 'string')]
    private $url;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updateAt = null;

    #[ORM\Column(length: 4)]
    #[ORM\JoinColumn(nullable: true)]
    private ?string $extention = null;

    #[ORM\ManyToOne(targetEntity:Recipe::class, inversedBy: 'pictures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipe = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $fileName = null;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getExtention(): ?string
    {
        return $this->extention;
    }

    public function setExtention(string $extention): self
    {
        $this->extention = $extention;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    /**
     * @param File|null $url
     */
    public function setPictureFile(File $url = null): void
    {
        $this->pictureFile = $url;
        if ($url) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updateAt = new \DateTime('now');
        }
    }
}