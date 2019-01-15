<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

//Classe de l'entité 'Product'
//Qui correspond à la table 'Product' dans la base de données

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    // l'id sera automatiquement généré à chaque création d'instance
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    // brand_id correspond à une clé étrangère qui pointe sur l'entité 'Brand'
    // Elle ne peut être nulle
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductsCategories", mappedBy="products_id")
     */
    private $productsCategories;

    public function __construct()
    {
        $this->productsCategories = new ArrayCollection();
    }

    // Les fonctions 'get...' permettent de récupérer chaque attribut de la classe
    // Les fonctions 'set...' permettent de les modifier
    // Elles sont générées automatiquement quand un nouvel attribut est crée
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrandId(): ?Brand
    {
        return $this->brand_id;
    }

    public function setBrandId(?Brand $brand_id): self
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    // L'attribut 'productsCategories' étant une relation oneToMany
    // Le générateur d'entité de Symfony permet de récupérer toutes les entités productsCategories
    // Liées à un product sous forme de tableau
    
    // D'ajouter des productsCategories liées au product
    // Ou d'en supprimer
    /**
     * @return Collection|ProductsCategories[]
     */
    public function getProductsCategories(): Collection
    {
        return $this->productsCategories;
    }

    public function addProductsCategory(ProductsCategories $productsCategory): self
    {
        if (!$this->productsCategories->contains($productsCategory)) {
            $this->productsCategories[] = $productsCategory;
            $productsCategory->setProductsId($this);
        }

        return $this;
    }

    public function removeProductsCategory(ProductsCategories $productsCategory): self
    {
        if ($this->productsCategories->contains($productsCategory)) {
            $this->productsCategories->removeElement($productsCategory);
            // set the owning side to null (unless already changed)
            if ($productsCategory->getProductsId() === $this) {
                $productsCategory->setProductsId(null);
            }
        }

        return $this;
    }
    
}
