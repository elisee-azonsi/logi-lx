<?php

namespace App\Entity;

use App\Repository\ShiftRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method delete()
 */
#[ORM\Entity(repositoryClass: ShiftRepository::class)]
class Shift
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $chantier = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_de_debut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_de_fin = null;

    #[ORM\Column(nullable: true)]
    private ?float $heures_normales = null;

    #[ORM\Column(nullable: true)]
    private ?float $heures_supp = null;

    #[ORM\Column(nullable: true)]
    private ?float $heures_nuit = null;

    #[ORM\Column(nullable: true)]
    private ?float $ferie = null;

    #[ORM\Column(nullable: true)]
    private ?float $maladie = null;

    #[ORM\Column(nullable: true)]
    private ?float $cp = null;

    #[ORM\Column(nullable: true)]
    private ?float $autre = null;

    #[ORM\Column(nullable: true)]
    private ?float $nombre_total_heures = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'shift')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Employe $employe = null;

    public function calculHeuresNormales(): float
    {

        if (!is_float($this->heures_normales) || !is_float($this->heures_supp) || !is_float($this->heures_nuit)
            || !is_float($this->ferie) || !is_float($this->maladie) || !is_float($this->cp) || !is_float($this->autre)) {
            if(is_null($this->heures_normales)){
                $this->heures_normales = 0;
            }
            if(is_null($this->heures_supp)){
                $this->heures_supp = 0;
            }
            if(is_null($this->heures_nuit)){
                $this->heures_nuit = 0;
            }
            if(is_null($this->ferie)){
                $this->ferie = 0;
            }
            if(is_null($this->maladie)){
                $this->maladie = 0;
            }
            if(is_null($this->cp)){
                $this->cp= 0;
            }

            if(is_null($this->autre)){
                $this->autre= 0;
            }


        }


        $this->nombre_total_heures = $this->heures_normales + $this->heures_supp + $this->heures_nuit + $this->ferie
        + $this->maladie + $this->cp + $this->autre;
        return $this->nombre_total_heures;// Heures de différence
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getChantier(): ?string
    {
        return $this->chantier;
    }

    public function setChantier(string $chantier): static
    {
        $this->chantier = $chantier;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getHeureDeDebut(): ?\DateTimeInterface
    {
        return $this->heure_de_debut;
    }

    public function setHeureDeDebut(\DateTimeInterface $heure_de_debut): static
    {
        $this->heure_de_debut = $heure_de_debut;

        return $this;
    }

    public function getHeureDeFin(): ?\DateTimeInterface
    {
        return $this->heure_de_fin;
    }

    public function setHeureDeFin(\DateTimeInterface $heure_de_fin): static
    {
        $this->heure_de_fin = $heure_de_fin;

        return $this;
    }

    public function getHeuresNormales(): ?float
    {
        return $this->heures_normales;
    }

    public function setHeuresNormales(?float $heures_normales): static
    {
        $this->heures_normales = $heures_normales;

        return $this;
    }

    public function getHeuresSupp(): ?float
    {
        return $this->heures_supp;
    }

    public function setHeuresSupp(?float $heures_supp): static
    {
        $this->heures_supp = $heures_supp;

        return $this;
    }

    public function getHeuresNuit(): ?float
    {
        return $this->heures_nuit;
    }

    public function setHeuresNuit(?float $heures_nuit): static
    {
        $this->heures_nuit = $heures_nuit;

        return $this;
    }

    public function getFerie(): ?float
    {
        return $this->ferie;
    }

    public function setFerie(?float $ferie): static
    {
        $this->ferie = $ferie;

        return $this;
    }

    public function getMaladie(): ?float
    {
        return $this->maladie;
    }

    public function setMaladie(?float $maladie): static
    {
        $this->maladie = $maladie;

        return $this;
    }

    public function getCp(): ?float
    {
        return $this->cp;
    }

    public function setCp(?float $cp): static
    {
        $this->cp = $cp;

        return $this;
    }

    public function getAutre(): ?float
    {
        return $this->autre;
    }

    public function setAutre(?float $autre): static
    {
        $this->autre = $autre;

        return $this;
    }

    public function getNombreTotalHeures(): ?float
    {
        return $this->nombre_total_heures;
    }

    public function setNombreTotalHeures(?float $nombre_total_heures): static
    {
        $this->nombre_total_heures = $nombre_total_heures;

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

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(?Employe $employe): static
    {
        $this->employe = $employe;

        return $this;
    }
}
