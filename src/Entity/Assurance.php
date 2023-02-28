<?php

namespace App\Entity;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\AssuranceRepository;
use Symfony\Component\Serializer\Annotation\Ignore;
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

 

  
    #[Assert\Length(min: 8,minMessage: "CE n est pas un num" )]
    #[Assert\NotBlank(message:"il est obligatoire de mettre un numero de telephone")]
    #[Assert\Positive(message:"le numero doit etre positif")]
    #[ORM\Column]
    private ?int $telephone = null;

    #[Assert\Email(message:"vous devez entrez votre mail")]
    #[Assert\NotBlank(message:"il est obligatoire d'ajouter un mail a l assurance")]
    #[ORM\Column(length: 255)]
    private ?string $mail = null;

  
    #[ORM\JoinColumn(onDelete:"CASCADE")]
    #[ORM\ManyToOne(inversedBy: 'id_assurance')]
    #[Ignore]
    private ?Region $region = null;

    
    #[Assert\NotBlank(message:"il est obligatoire de mettre la region")]
    #[ORM\ManyToOne(inversedBy: 'assurances')]
    #[Ignore]
    private ?Region $Region = null;

    
  

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

    public function getRegion(): ?Region
    {
        return $this->Region;
    }

    public function setRegion(?Region $Region): self
    {
        $this->Region = $Region;

        return $this;
    }

    public function getAdresse(): ?Region
    {
        return $this->adresse;
    }

    public function setAdresse(?Region $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }


  
    

  

}
