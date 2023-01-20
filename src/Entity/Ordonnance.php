<?php

namespace App\Entity;

use App\Repository\OrdonnanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdonnanceRepository::class)]
class Ordonnance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Medicament = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\Date $Date = null;


    #[ORM\OneToOne(targetEntity: Consultation::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $consulatation;

    #[ORM\OneToOne(targetEntity: Patient::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $patient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedicament(): ?string
    {
        return $this->Medicament;
    }

    public function setMedicament(string $Medicament): self
    {
        $this->Medicament = $Medicament;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->Date;
    }

    public function setDate(string $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getPatient(): ?string
    {
        return $this->patient;
    }

    public function setPatient(string $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConsulatation()
    {
        return $this->consulatation;
    }

    /**
     * @param mixed $consulatation
     */
    public function setConsulatation($consulatation): void
    {
        $this->consulatation = $consulatation;
    }
}
