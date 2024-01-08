<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    #przewodność elektryczna
    private ?bool $conductivity = null;

    #[ORM\Column]
    #ognioodporność
    private ?bool $incombustible = null;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: ProductMaterial::class, cascade: ['persist'])]
    private Collection $productmaterials;

    public function __construct()
    {
        $this->productmaterials = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isConductivity(): ?bool
    {
        return $this->conductivity;
    }

    public function setConductivity(bool $conductivity): static
    {
        $this->conductivity = $conductivity;

        return $this;
    }

    public function isIncombustible(): ?bool
    {
        return $this->incombustible;
    }

    public function setIncombustible(bool $incombustible): static
    {
        $this->incombustible = $incombustible;

        return $this;
    }

    /**
     * @return Collection<int, ProductMaterial>
     */
    public function getProductmaterials(): Collection
    {
        return $this->productmaterials;
    }

    public function addProductmaterial(ProductMaterial $productmaterial): static
    {
        if (!$this->productmaterials->contains($productmaterial)) {
            $this->productmaterials->add($productmaterial);
            $productmaterial->setMaterial($this);
        }

        return $this;
    }

    public function removeProductmaterial(ProductMaterial $productmaterial): static
    {
        if ($this->productmaterials->removeElement($productmaterial)) {
            if ($productmaterial->getMaterial() === $this) {
                $productmaterial->setMaterial(null);
            }
        }

        return $this;
    }
}
