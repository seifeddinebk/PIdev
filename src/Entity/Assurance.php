<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\AssuranceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssuranceRepository::class)]
class Assurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message:"il est obligatoire d'ajouter un nom a l assurance")]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Assert\NotBlank(message:"il est obligatoire d'ajouter une region a l assurance")]
    #[ORM\Column(length: 255)]
    private ?string $region = null;

  
    #[Assert\NotBlank(message:"il est obligatoire de mettre un numero de telephone")]
    #[Assert\Positive(message:"le numero doit etre positif")]
    #[ORM\Column]
    private ?int $telephone = null;

    #[Assert\Email(message:"vous devez entrez votre mail")]
    #[Assert\NotBlank(message:"il est obligatoire d'ajouter un mail a l assurance")]
    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[Assert\NotBlank(message:"il est obligatoire d'ajouter une adresse a l assurance")]
    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
}
