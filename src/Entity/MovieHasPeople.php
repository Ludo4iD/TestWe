<?php

namespace App\Entity;

use App\Repository\MovieHasPeopleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MovieHasPeopleRepository::class)]
class MovieHasPeople
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'movieHasPeople')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["getPeoples"])]
    private ?Movie $movie = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'movieHasPeople')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["getMovies", "getTypes"])]
    private ?People $people = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getMovies", "getPeoples", "getTypes"])]
    private ?string $role = null;

    #[ORM\Column(type: 'enum_significance')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(["getMovies", "getPeoples", "getTypes"])]
    private ?string $significance = null;

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getPeople(): ?People
    {
        return $this->people;
    }

    public function setPeople(?People $people): self
    {
        $this->people = $people;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getSignificance(): ?string
    {
        return $this->significance;
    }

    public function setSignificance(string $significance): self
    {
        $this->significance = $significance;

        return $this;
    }
}
