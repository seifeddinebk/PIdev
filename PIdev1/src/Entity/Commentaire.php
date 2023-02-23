<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idUser = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCommentaire = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    private ?Actualite $Actualite = null;

    #[ORM\OneToMany(mappedBy: 'commentaire', targetEntity: NbLike::class)]
    private Collection $nb_like;

    public function __construct()
    {
        $this->nb_like = new ArrayCollection();
    } 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $id_user): self
    {
        $this->idUser = $id_user;

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

    public function getDateCommentaire(): ?\DateTimeInterface
    {
        return $this->dateCommentaire;
    }

    public function setDateCommentaire(\DateTimeInterface $date_commentaire): self
    {
        $this->dateCommentaire = $date_commentaire;

        return $this;
    }

    public function getActualite(): ?Actualite
    {
        return $this->Actualite;
    }

    public function setActualite(?Actualite $Actualite): self
    {
        $this->Actualite = $Actualite;

        return $this;
    }

    /**
     * @return Collection<int, NbLike>
     */
    public function getNbLike(): Collection
    {
        return $this->nb_like;
    }

    public function addNbLike(NbLike $nbLike): self
    {
        if (!$this->nb_like->contains($nbLike)) {
            $this->nb_like->add($nbLike);
            $nbLike->setCommentaire($this);
        }

        return $this;
    }

    public function removeNbLike(NbLike $nbLike): self
    {
        if ($this->nb_like->removeElement($nbLike)) {
            // set the owning side to null (unless already changed)
            if ($nbLike->getCommentaire() === $this) {
                $nbLike->setCommentaire(null);
            }
        }

        return $this;
    }
    
}
