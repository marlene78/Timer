<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TimerRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TimerRepository::class)
 */
class Timer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\OneToOne(targetEntity=Task::class, inversedBy="timer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $task;
    
    /**
     * @ORM\Column(type="integer")
     * 
     */
    private $progress;

    /**
     * @ORM\Column(type="integer")
     * @Groups("get:info")
     */
    private $heure;

    /**
     * @ORM\Column(type="integer")
     * @Groups("get:info")
     */
    private $minute;

    /**
     * @ORM\Column(type="integer")
     * @Groups("get:info")
     */
    private $seconde;



    public function getId(): ?int
    {
        return $this->id;
    }



    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getprogress(): ?int
    {
        return $this->progress;
    }

    public function setprogress(int $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    public function __toString()
    {
        return $this->time;
    }

    public function getHeure(): ?int
    {
        return $this->heure;
    }

    public function setHeure(int $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getMinute(): ?int
    {
        return $this->minute;
    }

    public function setMinute(int $minute): self
    {
        $this->minute = $minute;

        return $this;
    }

    public function getSeconde(): ?int
    {
        return $this->seconde;
    }

    public function setSeconde(int $seconde): self
    {
        $this->seconde = $seconde;

        return $this;
    }


    /**
    * @ORM\PrePersist
    */
    public function PrePersist()
    {
    
        $this->heure = 0; 
        $this->minute = 0;
        $this->seconde = 0;
        
    }


}