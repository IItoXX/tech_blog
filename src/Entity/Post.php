<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $title = null;
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;
    #[ORM\ManyToMany(targetEntity: Category::class)]
    private Collection $categories;
    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $commentaires;
    public function __construct() {
        $this->categories = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }
    public function getId(): ?int { return $this->id; }
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): static {
        $this->title = $title;
        return $this;
    }
    public function getContent(): ?string { return $this->content; }
    public function setContent(string $content): static {
        $this->content = $content;
        return $this;
    }
    public function getCategories(): Collection { return $this->categories; }
    public function addCategory(Category $category): static {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }
        return $this;
    }
    public function removeCategory(Category $category): static {
        $this->categories->removeElement($category);
        return $this;
    }
    public function getCommentaires(): Collection { return $this->commentaires; }
    public function addCommentaire(Comment $commentaire): static {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setPost($this);
        }
        return $this;
    }
    public function removeCommentaire(Comment $commentaire): static {
        if ($this->commentaires->removeElement($commentaire)) {
            if ($commentaire->getPost() === $this) {
                $commentaire->setPost(null);
            }
        }
        return $this;
    }
}