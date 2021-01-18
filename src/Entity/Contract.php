<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContractRepository::class)
 */
class Contract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $noticePeriod;

    /**
     * @ORM\Column(type="integer")
     */
    private $rent;

    /**
     * @ORM\OneToMany(targetEntity=Person::class, mappedBy="contract")
     */
    private $residents;

    /**
     * @ORM\ManyToMany(targetEntity=Person::class, inversedBy="contracts")
     * @ORM\JoinTable(name="contracts_parties")
     */
    private $contractParties;

    /**
     * @ORM\OneToOne(targetEntity=RentalObject::class, mappedBy="contract", cascade={"persist", "remove"})
     */
    private $rentalObject;

    public function __construct()
    {
        $this->residents = new ArrayCollection();
        $this->contractParties = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) 'Contract #' . $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getNoticePeriod(): ?int
    {
        return $this->noticePeriod;
    }

    public function setNoticePeriod(int $noticePeriod): self
    {
        $this->noticePeriod = $noticePeriod;

        return $this;
    }

    public function getRent(): ?int
    {
        return $this->rent;
    }

    public function setRent(int $rent): self
    {
        $this->rent = $rent;

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getResidents(): Collection
    {
        return $this->residents;
    }

    public function addResident(Person $resident): self
    {
        if (!$this->residents->contains($resident)) {
            $this->residents[] = $resident;
        }

        return $this;
    }

    public function setResidents(ArrayCollection $residents): self
    {
        $this->residents = $residents;

        return $this;
    }

    public function removeResident(Person $resident): self
    {
        $this->residents->removeElement($resident);

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getContractParties(): Collection
    {
        return $this->contractParties;
    }

    public function addContractParty(Person $contractParty): self
    {
        if (!$this->contractParties->contains($contractParty)) {
            $this->contractParties[] = $contractParty;
        }

        return $this;
    }

    public function setContractParties(ArrayCollection $contractParties): self
    {
        $this->contractParties = $contractParties;

        return $this;
    }

    public function removeContractParty(Person $contractParty): self
    {
        $this->contractParties->removeElement($contractParty);

        return $this;
    }

    public function getRentalObject(): ?RentalObject
    {
        return $this->rentalObject;
    }

    public function setRentalObject(?RentalObject $rentalObject): self
    {
        // unset the owning side of the relation if necessary
        if ($rentalObject === null && $this->rentalObject !== null) {
            $this->rentalObject->setContract(null);
        }

        // set the owning side of the relation if necessary
        if ($rentalObject !== null && $rentalObject->getContract() !== $this) {
            $rentalObject->setContract($this);
        }

        $this->rentalObject = $rentalObject;

        return $this;
    }
}
