<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbDoors;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbSeats;

    /**
     * @ORM\Column(type="float")
     */
    private $cost;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    // Getters and Setters (Omitted for brevity)

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbDoors(): ?int
    {
        return $this->nbDoors;
    }

    public function setNbDoors(int $nbDoors): self
    {
        $this->nbDoors = $nbDoors;

        return $this;
    }

    public function getNbSeats(): ?int
    {
        return $this->nbSeats;
    }

    public function setNbSeats(int $nbSeats): self
    {
        $this->nbSeats = $nbSeats;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
