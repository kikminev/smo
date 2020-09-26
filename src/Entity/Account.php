<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
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
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=BusinessUnit::class, mappedBy="account", orphanRemoval=true)
     */
    private $businessUnits;

    public function __construct()
    {
        $this->businessUnits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|BusinessUnit[]
     */
    public function getBusinessUnits(): Collection
    {
        return $this->businessUnits;
    }

    public function addBusinessUnit(BusinessUnit $businessUnit): self
    {
        if (!$this->businessUnits->contains($businessUnit)) {
            $this->businessUnits[] = $businessUnit;
            $businessUnit->setAccount($this);
        }

        return $this;
    }

    public function removeBusinessUnit(BusinessUnit $businessUnit): self
    {
        if ($this->businessUnits->contains($businessUnit)) {
            $this->businessUnits->removeElement($businessUnit);
            // set the owning side to null (unless already changed)
            if ($businessUnit->getAccount() === $this) {
                $businessUnit->setAccount(null);
            }
        }

        return $this;
    }
}
