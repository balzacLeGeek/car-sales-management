<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @Vich\Uploadable
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $numClient;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoProfil;

    /**
     * @Vich\UploadableField(mapping="client_upload", fileNameProperty="photoProfil")
     * @var File
     */
    private $photoProfilFile;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vente", mappedBy="client", orphanRemoval=true)
     */
    private $ventes;

    private $clientInput;
    private $numero;

    public function __construct()
    {
        $this->ventes = new ArrayCollection();
    }

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPhotoProfil(): ?string
    {
        return $this->photoProfil;
    }

    public function setPhotoProfil(string $photoProfil = null): self
    {
        $this->photoProfil = $photoProfil;

        return $this;
    }

    public function setPhotoProfilFile(File $photoProfilFile = null)
    {
        $this->photoProfilFile = $photoProfilFile;
    }

    public function getPhotoProfilFile()
    {
        return $this->photoProfilFile;
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
            $vente->setClient($this);
        }

        return $this;
    }

    public function removeVente(Vente $vente): self
    {
        if ($this->ventes->contains($vente)) {
            $this->ventes->removeElement($vente);
            // set the owning side to null (unless already changed)
            if ($vente->getClient() === $this) {
                $vente->setClient(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    /**
     * Get the value of clientInput
     */ 
    public function getClientInput()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    /**
     * Get the value of numClient
     */ 
    public function getNumClient()
    {
        $prefix = 'CL';
        $id = $this->id;
        return ($id < 10 ) ? ($prefix . '0' . $this->id) : ($prefix . $this->id);
    }

    /**
     * Set the value of numClient
     *
     * @return  self
     */ 
    public function setNumClient($numClient)
    {
        $this->numClient = $numClient;

        return $this;
    }

    /**
     * Get the value of numero
     *
     * @return  self
     */ 
    public function getNumero()
    {
        $prefix = 'CL';
        $id = $this->id;
        return ($id < 10 ) ? ($prefix . '0' . $this->id) : ($prefix . $this->id);
    }
}
