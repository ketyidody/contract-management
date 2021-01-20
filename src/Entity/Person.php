<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

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

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("contractIds")
     */
    public function contractIds()
    {
        $contractIds = [];
        /** @var Contract $contract */
        foreach ($this->contracts as $contract) {
            $contractIds[$contract->getId()] = $contract->__toString();
        }

        return $contractIds;
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

    public function setContracts(ArrayCollection $contracts): self
    {
        $this->contracts = $contracts;

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
}
