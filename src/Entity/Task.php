<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TaskRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("get:user")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get:info")
     * @Groups("get:user")
     */
    private $nom;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("get:info")
     */
    private $demarre;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("get:info")
     */
    private $cloture;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("get:info")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("get:user")
     */
    private $projet;

    /**
     * @ORM\OneToOne(targetEntity=Timer::class, mappedBy="task", cascade={"persist", "remove"})
     * @Groups("get:info")
     * @Groups("get:user")
     */
    private $timer;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("get:info")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get:info")
     */
    private $priorite;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $tempsEstime;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDemarre(): ?bool
    {
        return $this->demarre;
    }

    public function setDemarre(bool $demarre): self
    {
        $this->demarre = $demarre;

        return $this;
    }

    public function getCloture(): ?bool
    {
        return $this->cloture;
    }

    public function setCloture(bool $cloture): self
    {
        $this->cloture = $cloture;

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

    public function getProjet(): ?Project
    {
        return $this->projet;
    }

    public function setProjet(?Project $projet): self
    {
        $this->projet = $projet;

        return $this;
    }




    public function getTimer(): ?Timer
    {
        return $this->timer;
    }

    public function setTimer(Timer $timer): self
    {
        $this->timer = $timer;

        // set the owning side of the relation if necessary
        if ($timer->getTask() !== $this) {
            $timer->setTask($this);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPriorite(): ?string
    {
        return $this->priorite;
    }

    public function setPriorite(string $priorite): self
    {
        $this->priorite = $priorite;

        return $this;
    }

    public function getTempsEstime(): ?int
    {
        return $this->tempsEstime;
    }

    public function setTempsEstime(int $tempsEstime): self
    {
        $this->tempsEstime = $tempsEstime;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @ORM\PrePersist
     */
    public function PrePersist()
    {
    
        $this->demarre = 0; 
        $this->cloture = 0;
        $this->createdAt = new \DateTime();
    }


}