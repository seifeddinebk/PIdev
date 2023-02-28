<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Ignore;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(min: 4,minMessage: "CE n est pas une region existante" )]
    #[Assert\NotBlank(message:"il est obligatoire d'ajouter une region")]
    #[ORM\Column(length: 255)]
    private ?string $region = null;


    #[Assert\Length(min: 2,minMessage: "Cette adresse n existe pas" )]
    #[Assert\NotBlank(message:"il est obligatoire d'ajouter une adresse")]
    #[ORM\Column(length: 255)]
    private ?string $adresse = null;
    #[Ignore]
    #[ORM\OneToMany(mappedBy: 'region', targetEntity: Assurance::class)]
    private Collection $id_assurance;
    #[Ignore]
    #[ORM\OneToMany(mappedBy: 'Region', targetEntity: Assurance::class)]
    private Collection $assurances;

 

    public function __construct()
    {
        $this->id_assurance = new ArrayCollection();
        $this->assurances = new ArrayCollection();
      
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Assurance>
     */
    public function getIdAssurance(): Collection
    {
        return $this->id_assurance;
    }

    public function addIdAssurance(Assurance $idAssurance): self
    {
        if (!$this->id_assurance->contains($idAssurance)) {
            $this->id_assurance->add($idAssurance);
            $idAssurance->setRegion($this);
        }

        return $this;
    }

    public function removeIdAssurance(Assurance $idAssurance): self
    {
        if ($this->id_assurance->removeElement($idAssurance)) {
            // set the owning side to null (unless already changed)
            if ($idAssurance->getRegion() === $this) {
                $idAssurance->setRegion(null);
            }
        }

        return $this;
    }

     public function __toString()
   {
       return (string)$this->getRegion();
   }

     /**
      * @return Collection<int, Assurance>
      */
     public function getAssurances(): Collection
     {
         return $this->assurances;
     }

     public function addAssurance(Assurance $assurance): self
     {
         if (!$this->assurances->contains($assurance)) {
             $this->assurances->add($assurance);
             $assurance->setRegion($this);
         }

         return $this;
     }

     public function removeAssurance(Assurance $assurance): self
     {
         if ($this->assurances->removeElement($assurance)) {
             // set the owning side to null (unless already changed)
             if ($assurance->getRegion() === $this) {
                 $assurance->setRegion(null);
             }
         }

         return $this;
     }

     
}
