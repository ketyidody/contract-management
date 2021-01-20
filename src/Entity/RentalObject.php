<?php

namespace App\Entity;

use App\Repository\RentalObjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass=RentalObjectRepository::class)
 */
class RentalObject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberOfRooms;

    /**
     * @ORM\OneToMany(targetEntity=Contract::class, mappedBy="rentalObject", cascade={"persist", "remove"})
     */
    private $contracts;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("contractIds")
     */
    public function contractIds()
    {
        $contractIds = [];
        foreach ($this->getContracts() as $contract) {
            $contractIds[$contract->getId()] = $contract->__toString();
        }
        return $contractIds;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getNumberOfRooms(): ?int
    {
        return $this->numberOfRooms;
    }

    public function setNumberOfRooms(int $numberOfRooms): self
    {
        $this->numberOfRooms = $numberOfRooms;

        return $this;
    }

    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contract $contract): self
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts[] = $contract;
        }

        return $this;
    }

    public function setContracts(ArrayCollection $contracts): self
    {
        $this->contracts = $contracts;

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
}
