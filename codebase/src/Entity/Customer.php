<?php

namespace App\Entity;

use App\Enum\StatusEnumType;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true, hardDelete=false)
 */
class Customer
{
    /**
     * @Groups({"customer", "product"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private $uuid;

    /**
     * @Groups({"customer", "product"})
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     */
    private $firstName;

    /**
     * @Groups({"customer", "product"})
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     */
    private $lastName;

    /**
     * @Groups({"customer", "product"})
     * @ORM\Column(type="date", nullable=true)
     * @Assert\LessThan("-8 years")
     */
    private $dateOfBirth;

    /**
     * @Groups({"customer", "product"})
     * @ORM\Column(type="StatusEnumType", nullable=false)
     */
    private $status;

    /**
     * @Groups({"customer", "product"})
     * @ORM\Column(type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @Groups({"customer", "product"})
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @Groups({"customer", "product"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @Groups({"customer"})
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="customer", cascade={"PERSIST"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->setStatus(StatusEnumType::NEW_STATUS);
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (!StatusEnumType::isValidValue($status)) {
            throw new \Exception("invalid status enum type", 1);
        }

        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCustomer($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCustomer() === $this) {
                $product->setCustomer(null);
            }
        }

        return $this;
    }
}
