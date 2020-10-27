<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MessageRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("get:info")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups("get:info")
     */
    private $content;



    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("get:info")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     *  @Groups("get:info")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $task;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }



    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }



    /**
    * Initalisation de la date 
    * @ORM\PrePersist
    */
    public function Prepersist()
    {
        $this->createAt = new \DateTime('now');  
    }



   
}
