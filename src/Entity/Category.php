<?php

namespace App\Entity;



use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_str", type="string", length=255, nullable=true)
     */
    private $descriptionStr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imagen", type="string", length=20, nullable=true)
     */
    private $imagen;



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Streak", mappedBy="category")
     */
    private $streaks;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescriptionStr(): ?string
    {
        return $this->descriptionStr;
    }

    public function setDescriptionStr(?string $descriptionStr): self
    {
        $this->descriptionStr = $descriptionStr;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }


     /**
     *  @return Collection|Streak[]
     * 
     */
    public function getStreaks():Collection{

        return $this->streaks;

    }


}
