<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)] //creation d'un table
class Author
{
    #[ORM\Id] //matedbadlech
    #[ORM\GeneratedValue]//auto-generate
    #[ORM\Column] //creation  des colonnes
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $username = null;

    #[ORM\Column(length: 30)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_class = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Book::class)]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNbClass(): ?int
    {
        return $this->nb_class;
    }

    public function setNbClass(?int $nb_class): static
    {
        $this->nb_class = $nb_class;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setAuthor($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null);
            }
        }

        return $this;
    }
}
