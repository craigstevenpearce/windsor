<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $FNAME;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $LNAME;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DATE;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $NOTES;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $EMAIL;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setID(int $ID): self
    {
        $this->ID = $ID;

        return $this;
    }

    public function getFNAME(): ?string
    {
        return $this->FNAME;
    }

    public function setFNAME(string $FNAME): self
    {
        $this->FNAME = $FNAME;

        return $this;
    }

    public function getLNAME(): ?string
    {
        return $this->LNAME;
    }

    public function setLNAME(string $LNAME): self
    {
        $this->LNAME = $LNAME;

        return $this;
    }

    public function getDATE(): ?\DateTimeInterface
    {
        return $this->DATE;
    }

    public function setDATE(\DateTimeInterface $DATE): self
    {
        $this->DATE = $DATE;

        return $this;
    }

    public function getNOTES(): ?string
    {
        return $this->NOTES;
    }

    public function setNOTES(?string $NOTES): self
    {
        $this->NOTES = $NOTES;

        return $this;
    }

    public function getEMAIL(): ?string
    {
        return $this->EMAIL;
    }

    public function setEMAIL(string $EMAIL): self
    {
        $this->EMAIL = $EMAIL;

        return $this;
    }
}
