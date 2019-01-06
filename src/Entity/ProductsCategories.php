<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsCategoriesRepository")
 */
class ProductsCategories
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\product", inversedBy="productsCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $products_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\category", inversedBy="productsCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductsId(): ?product
    {
        return $this->products_id;
    }

    public function setProductsId(?product $products_id): self
    {
        $this->products_id = $products_id;

        return $this;
    }

    public function getCategoriesId(): ?category
    {
        return $this->categories_id;
    }

    public function setCategoriesId(?category $categories_id): self
    {
        $this->categories_id = $categories_id;

        return $this;
    }
}
