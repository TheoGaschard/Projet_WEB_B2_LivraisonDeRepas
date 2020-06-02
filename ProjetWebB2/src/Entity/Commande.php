<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plat", mappedBy="commande")
     */
    private $plat;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=800)
     */
    private $adresseLivraison;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLivraison;

    /**
     * @ORM\Column(type="float")
     */
    private $frais;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlatCommande", mappedBy="commande")
     */
    private $platCommandes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $villeLivraison;



    public function __construct()
    {
        $this->plat = new ArrayCollection();
        $this->plats = new ArrayCollection();
        $this->platCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAdresseLivraison(): ?string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(string $adresseLivraison): self
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(\DateTimeInterface $dateLivraison): self
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(float $frais): self
    {
        $this->frais = $frais;

        return $this;
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
            $platCommande->setCommande($this);
        }

        return $this;
    }

    public function removePlatCommande(PlatCommande $platCommande): self
    {
        if ($this->platCommandes->contains($platCommande)) {
            $this->platCommandes->removeElement($platCommande);
            // set the owning side to null (unless already changed)
            if ($platCommande->getCommande() === $this) {
                $platCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getVilleLivraison(): ?string
    {
        return $this->villeLivraison;
    }

    public function setVilleLivraison(string $villeLivraison): self
    {
        $this->villeLivraison = $villeLivraison;

        return $this;
    }




}
