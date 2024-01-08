<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $subtotal = null;

    #[ORM\Column]
    private ?float $vat = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?bool $paid = null;

    #[ORM\Column]
    private ?bool $delivered = null;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class, cascade: ['persist'])]
    private Collection $orderitems;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderComment::class, cascade: ['persist'])]
    private Collection $ordercomments;

    public function __construct()
    {
        $this->subtotal = 0;
        $this->vat = 0;
        $this->total = 0;
        $this->date = new \DateTime();
        $this->paid = false;
        $this->delivered = false;
        $this->orderitems = new ArrayCollection();
        $this->ordercomments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    public function setSubtotal(float $subtotal): static
    {
        $this->subtotal = $subtotal;
        return $this;
    }
    
    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): static
    {
        $this->vat = $vat;
        return $this;
    }
    
    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function isPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): static
    {
        $this->paid = $paid;

        return $this;
    }

    public function isDelivered(): ?bool
    {
        return $this->delivered;
    }

    public function setDelivered(bool $delivered): static
    {
        $this->delivered = $delivered;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrderItemsQuantity(): int
    {
        $quantity = 0;
        foreach ($this->orderitems as $orderitem) {
            $quantity += $orderitem->getQuantity();
        }
        return $quantity;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderitems;
    }

    public function addOrderItem(OrderItem $orderitem): static
    {
        if (!$this->orderitems->contains($orderitem)) {
            $this->orderitems->add($orderitem);
            $orderitem->setOrder($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderitem): static
    {
        if ($this->orderitems->removeElement($orderitem)) {
            if ($orderitem->getOrder() === $this) {
                $orderitem->setOrder(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderComment>
     */
    public function getOrderComments(): Collection
    {
        return $this->ordercomments;
    }

    public function addOrderComment(OrderComment $ordercomment): static
    {
        if (!$this->ordercomments->contains($ordercomment)) {
            $this->ordercomments->add($ordercomment);
            $ordercomment->setOrder($this);
        }

        return $this;
    }

    public function removeOrderComment(OrderComment $ordercomment): static
    {
        if ($this->ordercomments->removeElement($ordercomment)) {
            if ($ordercomment->getOrder() === $this) {
                $ordercomment->setOrder(null);
            }
        }

        return $this;
    }
}
