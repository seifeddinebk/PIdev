<?php

namespace App\Entity;

use App\Repository\ActualiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints as Assert;

use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 */


#[ORM\Entity(repositoryClass: ActualiteRepository::class)]
class Actualite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Ce champs doit etre rempli")]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"Ce champs doit etre rempli")]
    private ?string $contenu = null;

 
 

    #[ORM\Column(type: Types::DATE_MUTABLE,name:"date_actualite")]
   
    private ?\DateTimeInterface $dateActualite = null;

     #[ORM\Column(length: 255) ]
     private $imageFile;


   

    

    #[ORM\OneToMany(mappedBy: 'Actualite', targetEntity: Commentaire::class)]
    private Collection $commentaires;

  

    

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    

    public function getDateActualite(): ?\DateTimeInterface
    {
        return $this->dateActualite;
    }

    public function setDateActualite(\DateTimeInterface $date_actualite): self
    {
        $this->dateActualite = $date_actualite;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setActualite($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getActualite() === $this) {
                $commentaire->setActualite(null);
            }
        }

        return $this;
    }

     public function getImageFile()
     {
         return $this->imageFile;
     }

     public function setImageFile( $ImageFile)
     {
         $this->imageFile = $ImageFile;

       return $this;
    }
    
    public function __toString()
    {
        return $this->titre;
    }
   
}
