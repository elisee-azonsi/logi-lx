<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
class Employe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\OneToMany(mappedBy: 'employe', targetEntity: Shift::class)]
    #[ORM\JoinColumn(onDelete: 'CASCADE' )]
    private Collection $shift;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->shift = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, Shift>
     */
    public function getShift(): Collection
    {
        return $this->shift;
    }

    public function addShift(Shift $shift): static
    {
        if (!$this->shift->contains($shift)) {
            $this->shift->add($shift);
            $shift->setEmploye($this);
        }

        return $this;
    }

    public function removeShift(Shift $shift): static
    {
        if ($this->shift->removeElement($shift)) {
            // set the owning side to null (unless already changed)
            if ($shift->getEmploye() === $this) {
                $shift->setEmploye(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
