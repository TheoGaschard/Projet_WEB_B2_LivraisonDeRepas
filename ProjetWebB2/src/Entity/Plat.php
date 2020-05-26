<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlatRepository")
 */
class Plat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=800)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=1500, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $idRestaurant;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlatCommande", mappedBy="plat")
     */
    private $platCommandes;

    public function __construct()
    {
        $this->commande = new ArrayCollection();
        $this->platCommandes = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIdRestaurant(): ?int
    {
        return $this->idRestaurant;
    }

    public function setIdRestaurant(int $idRestaurant): self
    {
        $this->idRestaurant = $idRestaurant;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('prix', new Assert\Positive());
    }

    /**
     * @return Collection|PlatCommande[]
     */
    public function getPlatCommandes(): Collection
    {
        return $this->platCommandes;
    }

    public function addPlatCommande(PlatCommande $platCommande): self
    {
        if (!$this->platCommandes->contains($platCommande)) {
            $this->platCommandes[] = $platCommande;
            $platCommande->setPlat($this);
        }

        return $this;
    }

    public function removePlatCommande(PlatCommande $platCommande): self
    {
        if ($this->platCommandes->contains($platCommande)) {
            $this->platCommandes->removeElement($platCommande);
            // set the owning side to null (unless already changed)
            if ($platCommande->getPlat() === $this) {
                $platCommande->setPlat(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

}
