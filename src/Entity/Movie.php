<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getMovies", "getPeoples", "getTypes"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getMovies", "getPeoples", "getTypes"])]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups(["getMovies", "getPeoples", "getTypes"])]
    private ?int $duration = null;

    #[ORM\ManyToMany(targetEntity: Type::class, inversedBy: 'movies')]
    #[ORM\JoinTable(name: "movie_has_type")]
    #[Groups(["getMovies", "getPeoples"])]
    private Collection $type;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: MovieHasPeople::class, orphanRemoval: true)]
    #[Groups(["getMovies", "getTypes"])]
    private Collection $movieHasPeople;


    public function __construct()
    {
        $this->type = new ArrayCollection();
        $this->movieHasPeople = new ArrayCollection();
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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Type>
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(Type $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type->add($type);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        $this->type->removeElement($type);

        return $this;
    }

    /**
     * @return Collection<int, MovieHasPeople>
     */
    public function getMovieHasPeople(): Collection
    {
        return $this->movieHasPeople;
    }

    public function addMovieHasPerson(MovieHasPeople $movieHasPerson): self
    {
        if (!$this->movieHasPeople->contains($movieHasPerson)) {
            $this->movieHasPeople->add($movieHasPerson);
            $movieHasPerson->setMovie($this);
        }

        return $this;
    }

    public function removeMovieHasPerson(MovieHasPeople $movieHasPerson): self
    {
        if ($this->movieHasPeople->removeElement($movieHasPerson)) {
            // set the owning side to null (unless already changed)
            if ($movieHasPerson->getMovie() === $this) {
                $movieHasPerson->setMovie(null);
            }
        }

        return $this;
    }
}
