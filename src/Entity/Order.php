<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DATE;

    /**
     * @ORM\Column(type="float")
     */
    private $NET;

    /**
     * @ORM\Column(type="float")
     */
    private $VAT;

    /**
     * @ORM\Column(type="float")
     */
    private $TOTAL;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $STAGE;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $TYPE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PRODUCT;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $NOTES;

    /**
     * @ORM\Column(type="integer")
     */
    private $USER;

    /**
     * @ORM\Column(type="integer")
     */
    private $CUSTOMER;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNET(): ?float
    {
        return $this->NET;
    }

    public function setNET(float $NET): self
    {
        $this->NET = $NET;

        return $this;
    }

    public function getVAT(): ?float
    {
        return $this->VAT;
    }

    public function setVAT(float $VAT): self
    {
        $this->VAT = $VAT;

        return $this;
    }

    public function getTOTAL(): ?float
    {
        return $this->TOTAL;
    }

    public function setTOTAL(float $TOTAL): self
    {
        $this->TOTAL = $TOTAL;

        return $this;
    }

    public function getSTAGE(): ?string
    {
        return $this->STAGE;
    }

    public function setSTAGE(string $STAGE): self
    {
        $this->STAGE = $STAGE;

        return $this;
    }

    public function getTYPE(): ?string
    {
        return $this->TYPE;
    }

    public function setTYPE(string $TYPE): self
    {
        $this->TYPE = $TYPE;

        return $this;
    }

    public function getPRODUCT(): ?string
    {
        return $this->PRODUCT;
    }

    public function setPRODUCT(string $PRODUCT): self
    {
        $this->PRODUCT = $PRODUCT;

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

    public function getUSER(): ?int
    {
        return $this->USER;
    }

    public function setUSER(int $USER): self
    {
        $this->USER = $USER;

        return $this;
    }

    public function getCUSTOMER(): ?int
    {
        return $this->CUSTOMER;
    }

    public function setCUSTOMER(int $CUSTOMER): self
    {
        $this->CUSTOMER = $CUSTOMER;

        return $this;
    }
}
