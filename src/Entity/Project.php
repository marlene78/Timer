<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("nom", message="Ce projet existe déjà")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer") 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get:info")
     * @Groups("get:user")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get:info")
     */
    private $etat;

    /**
     * @ORM\Column(type="date")
     * @Groups("get:info")
     */
    private $dateDeDebut;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="dateDeDebut" , message="La date de fin doit être supérieur à la date de début")
     * @Groups("get:info")
     * 
     */
    private $DateDeFin;



    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projetCree")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createur;

    /**
     * @ORM\OneToMany(targetEntity=Group::class, mappedBy="project", orphanRemoval=true , cascade={"persist", "remove"})
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="projet", orphanRemoval=true)
     * @Groups("get:info")
     */
    private $tasks;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**

     * @ORM\OneToMany(targetEntity=Token::class, mappedBy="project")
     */
    private $tokenInvitation;
    
    /** 
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="project", orphanRemoval=true)
     */
    private $messages;



    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->tokenInvitation = new ArrayCollection();
        $this->messages = new ArrayCollection();

    }



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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat)
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDateDeDebut(): ?\DateTimeInterface
    {
        return $this->dateDeDebut;
    }

    public function setDateDeDebut(\DateTimeInterface $dateDeDebut): self
    {
        $this->dateDeDebut = $dateDeDebut;

        return $this;
    }

    public function getDateDeFin(): ?\DateTimeInterface
    {
        return $this->DateDeFin;
    }

    public function setDateDeFin(\DateTimeInterface $DateDeFin): self
    {
        $this->DateDeFin = $DateDeFin;

        return $this;
    }




    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->setProject($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            // set the owning side to null (unless already changed)
            if ($group->getProject() === $this) {
                $group->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setProjet($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getProjet() === $this) {
                $task->setProjet(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->nom; 
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
    public function Prepersist()
    {
        $now = new \DateTime('now'); 
        $day = $now->format('Y-m-d'); 
        $day < $this->dateDeDebut ? $this->etat = "Démarre prochainement" : $this->etat = "cours"; 
   
    }


    /**
     * @ORM\PrePersist 
     * @ORM\PreUpdate
     */
    public function timerProject(){
        date_default_timezone_set('Europe/Paris');
        $debut = strtotime($this->dateDeDebut->format('Y/m/d'));
        $fin = strtotime($this->DateDeFin->format('Y/m/d'));
        $diff = $fin - $debut;
        $timeNow = strtotime('now');
        $heures = $diff / 3600;
        $jour = $heures /24;
        $interval =  $debut -$timeNow;

       
       if($timeNow < $debut ){
           
           $days =round($interval*1000 / (1000 * 60 * 60 * 24));
           //$t = date('d F Y', $diff);
           $resultat = ($days!==0)? "Le projet débutera dans ". $days. " jour(s)." :  "Le projet débutera dans quelques heures. ";
           return $resultat;
       }
       else{
            //si le temps restant est 1jour on convertis en heure
            if($jour == 0){
                $heure = 24;
                $tempsRestant = $heure - date('h');

                if($tempsRestant == 0){
                    $resultat = "Projet terminé";
                }
                $resultat = $tempsRestant;
                return "Le projet débutera dans ". $resultat. ' heures';

            } 
            else{ 
                return 'Temps restant du projet :'.$jour.' j';
            }
        }

        
    }



    
    /**
     * On vérifie si le projet a débuté ou pas 
     * @ORM\PrePersist 
     * @ORM\PreUpdate
     */
    public function StartProjet(){
        $diff =  strtotime($this->dateDeDebut->format('Y/m/d')) - strtotime('now');
        $days = round($diff*1000 / (1000 * 60 * 60 * 24));
        $start = ($days >= 1)?'false': 'true';  

        return $start;
    }
    /**
     * Calcule de la durée du projet entre sa date de début et la date de fin,
     * indique aussi si le projet est fini ou pas 
     * @ORM\PrePersist 
     * @ORM\PreUpdate
     */
    public function DureeProjet(){
        $dateDeDebut = date_create($this->dateDeDebut->format('Y/m/d')); 
        $DateDeFin = date_create($this->DateDeFin->format('Y/m/d')); 
        $dateDuJour = date_create();
        $interval = date_diff($dateDeDebut, $DateDeFin);
        $diff = date_diff($dateDuJour, $DateDeFin) ;

        //Traitement du cas ou la date de fin est égale à la date de début 
        if($interval->format('%d')==='0'){
            $message  = 'Erreur';
        }
        //Traitement du cas ou la date du jour est égale à la date de fin du projet
        elseif($diff->format('%d')==='0'){
            $message = 'Temps écoulé';

        }
        else {
            $message = $interval->format('%d  jour(s)');
        }
        
        return $message;
        
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setProject($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getProject() === $this) {
                $message->setProject(null);
            }
        }

        return $this;
    }




}
