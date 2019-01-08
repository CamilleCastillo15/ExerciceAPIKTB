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
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="productsCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $products_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="productsCategories")
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

    public function setProductsId(?Product $products_id): self
    {
        $this->products_id = $products_id;

        return $this;
    }

    public function getCategoriesId(): ?Category
    {
        return $this->categories_id;
    }

    public function setCategoriesId(?Category $categories_id): self
    {
        $this->categories_id = $categories_id;

        return $this;
    }
}
