<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    const TYPES = [
        'Contractor' => 'contractor',
        'Agent' => 'agent'
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $personalId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pType;

    /**
     * @ORM\ManyToMany(targetEntity=Contract::class, mappedBy="contractParties")
     */
    private $contracts;

    /**
     * @ORM\ManyToOne(targetEntity=Contract::class, inversedBy="residents")
     * @ORM\JoinColumn(name="resident_id", referencedColumnName="id", nullable=true)
     */
    private $resident;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPersonalId(): ?string
    {
        return $this->personalId;
    }

    public function setPersonalId(string $personalId): self
    {
        $this->personalId = $personalId;

        return $this;
    }

    /**
     * @return Collection|Contract[]
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contract $contract): self
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts[] = $contract;
            $contract->addResident($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): self
    {
        if ($this->contracts->removeElement($contract)) {
            $contract->removeResident($this);
        }

        return $this;
    }

    public function getPType(): ?string
    {
        return $this->pType;
    }

    public function setPType(string $pType): self
    {
        $this->pType = $pType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResident()
    {
        return $this->resident;
    }

    /**
     * @param mixed $resident
     */
    public function setResident($resident): void
    {
        $this->resident = $resident;
    }
}
