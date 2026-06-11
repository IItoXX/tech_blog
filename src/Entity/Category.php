<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
    ],
    normalizationContext: ['groups' => ['category:read']],
)]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:read'])]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    #[Groups(['category:read'])]
    private ?string $name = null;
    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'categories')]
    private Collection $posts;
    public function __construct() {
        $this->posts = new ArrayCollection();
    }
    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static {
        $this->name = $name;
        return $this;
    }
    public function getPosts(): Collection { return $this->posts; }
    public function addPost(Post $post): static {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->addCategory($this);
        }
        return $this;
    }
    public function removePost(Post $post): static {
        if ($this->posts->removeElement($post)) {
            $post->removeCategory($this);
        }
        return $this;
    }
    public function __toString(): string {
        return $this->name ?? '';
    }
}