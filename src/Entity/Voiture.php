<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoitureRepository")
 * @Vich\Uploadable
 */
class Voiture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $prixUnitaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $thumbail;

    /**
     * @Vich\UploadableField(mapping="voiture_upload", fileNameProperty="thumbail")
     * @var File
     */
    private $thumbailFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", inversedBy="voitures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vente", mappedBy="voiture", orphanRemoval=true)
     */
    private $ventes;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $type;

    private $voitureType;

    public function __construct()
    {
        $this->ventes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixUnitaire(): ?int
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(int $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getThumbail(): ?string
    {
        return $this->thumbail;
    }

    public function setThumbail(?string $thumbail): self
    {
        $this->thumbail = $thumbail;

        return $this;
    }

    public function getThumbailFile()
    {
        return $this->thumbailFile;
    }

    public function setThumbailFile(File $thumbailFile = null)
    {
        $this->thumbailFile = $thumbailFile;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection|Vente[]
     */
    public function getVentes(): Collection
    {
        return $this->ventes;
    }

    public function addVente(Vente $vente): self
    {
        if (!$this->ventes->contains($vente)) {
            $this->ventes[] = $vente;
            $vente->setVoiture($this);
        }

        return $this;
    }

    public function removeVente(Vente $vente): self
    {
        if ($this->ventes->contains($vente)) {
            $this->ventes->removeElement($vente);
            // set the owning side to null (unless already changed)
            if ($vente->getVoiture() === $this) {
                $vente->setVoiture(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of voitureType
     */ 
    public function getVoitureType()
    {
        return $this->getMarque() . ' ' . $this->type;
    }

    /**
     * Set the value of voitureType
     *
     * @return  self
     */ 
    public function setVoitureType($voitureType)
    {
        $this->voitureType = $voitureType;

        return $this;
    }

    public function __toString()
    {
        return $this->getVoitureType();
    }
}
