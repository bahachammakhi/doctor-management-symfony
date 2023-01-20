<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $dateConsultation = null;

    #[ORM\Column(length: 255)]
    public ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'consultations')]
    #[ORM\JoinColumn(nullable: false)]
    private $patient;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $doctor = null;

    /**
     * @return mixed
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @param mixed $patient
     */
    public function setPatient($patient): void
    {
        $this->patient = $patient;
    }

    /**
     * @return User|null
     */
    public function getDoctor(): ?User
    {
        return $this->doctor;
    }

    /**
     * @param User|null $doctor
     */
    public function setDoctor(?User $doctor): void
    {
        $this->doctor = $doctor;
    }







    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateConsultation(): ?String
    {
        return $this->dateConsultation;
    }

    public function setDateConsultation(String $dateConsultation): self
    {
        $this->dateConsultation = $dateConsultation;

        return $this;
    }
}
