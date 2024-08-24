<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Streak
 *
 * @ORM\Table(name="streaks", indexes={@ORM\Index(name="pk_category_streaks", columns={"category_id"}), @ORM\Index(name="pk_streak_user", columns={"user_id"})})
 * @ORM\Entity
 */
class Streak
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
     * @ORM\Column(name="content", type="text", length=65535, nullable=true)
     */
    private $content;

    /**
     * @var string|null
     *
     * @ORM\Column(name="priority", type="string", length=20, nullable=true)
     */
    private $priority;

    /**
     * @var int|null
     *
     * @ORM\Column(name="hours", type="integer", nullable=true)
     */
    private $hours;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=true)
     */
    private $createAt;


      /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_modified", type="datetime", nullable=true)
     */
    private $last_modified;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @var int|null
     *
     * @ORM\Column(name="repeat_streak", type="integer", nullable=true)
     */
    private $repeatStreak;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category",inversedBy="Streaks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="Streaks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(?string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getHours(): ?int
    {
        return $this->hours;
    }

    public function setHours(?int $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }



    public function setCreateAt(?\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getLast_modified(): ?\DateTimeInterface
    {
        return $this->last_modified;
    }
    
    public function setLast_modified(?\DateTimeInterface $last_modified): self
    {
        $this->last_modified = $last_modified;
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

    public function getRepeatStreak(): ?int
    {
        return $this->repeatStreak;
    }

    public function setRepeatStreak(?int $repeatStreak): self
    {
        $this->repeatStreak = $repeatStreak;

        return $this;
    }

    //public function getCategory(): ?Category
    
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
