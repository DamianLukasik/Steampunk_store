<?php 

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?bool $availability = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(type: "json", nullable: true)]
    private ?array $functions = null;

    #[ORM\ManyToOne(targetEntity: Producer::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Producer $producer = null;
    
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: OrderItem::class, cascade: ['persist'])]
    private Collection $orderitems;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductMaterial::class, cascade: ['persist'])]
    private Collection $productmaterials;

    public function __construct()
    {
        $this->orderitems = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(?bool $availability): static
    {
        $this->availability = $availability;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getFunctions(): ?array
    {
        return $this->functions;
    }

    public function setFunctions(array $functions): static
    {
        $this->functions = $functions;

        return $this;
    }

    public function getProducer(): ?Producer
    {
        return $this->producer;
    }

    public function setProducer(Producer $producer): static
    {
        $this->producer = $producer;

        return $this;
    }

    /**
     * @return Collection|ProductMaterial[]
     */
    public function getProductMaterials(): Collection
    {
        return $this->productmaterials;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderitems(): Collection
    {
        return $this->orderitems;
    }

    public function addOrderitem(OrderItem $orderitem): static
    {
        if (!$this->orderitems->contains($orderitem)) {
            $this->orderitems->add($orderitem);
            $orderitem->setProduct($this);
        }

        return $this;
    }

    public function removeOrderitem(OrderItem $orderitem): static
    {
        if ($this->orderitems->removeElement($orderitem)) {
            if ($orderitem->getProduct() === $this) {
                $orderitem->setProduct(null);
            }
        }

        return $this;
    }

    public function addProductmaterial(ProductMaterial $productmaterial): static
    {
        if (!$this->productmaterials->contains($productmaterial)) {
            $this->productmaterials->add($productmaterial);
            $productmaterial->setProduct($this);
        }

        return $this;
    }

    public function removeProductmaterial(ProductMaterial $productmaterial): static
    {
        if ($this->productmaterials->removeElement($productmaterial)) {
            if ($productmaterial->getProduct() === $this) {
                $productmaterial->setProduct(null);
            }
        }

        return $this;
    }
}
