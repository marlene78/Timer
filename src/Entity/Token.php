<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TokenRepository;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TokenRepository::class)
 * @UniqueEntity("emailInvite", message="Une invitation a dèjà été envoyé à cette adresse e-mail.")
 */
class Token
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message = "'{{ value }}' n'est pas un e-mail valide.")
     * @Assert\NotBlank(message = "l'adress e-mail est obligatoire.")
     */
    private $emailInvite;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     *  @ORM\Column(type="integer")
     */
    private $project;

    /**
     * @ORM\ManyToMany(targetEntity=Group::class, inversedBy="tokens")
     */
    private $groupInvite;

    public function __construct()
    {
        $this->groupInvite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getEmailInvite(): ?string
    {
        return $this->emailInvite;
    }

    public function setEmailInvite(string $emailInvite): self
    {
        $this->emailInvite = $emailInvite;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getProject(): ?int
    {
        return $this->project;
    }

    public function setProject($project): ?int
    {
        return $this->project = $project;;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroupInvite(): Collection
    {
        return $this->groupInvite;
    }

    public function addGroupInvite(Group $groupInvite): self
    {
        if (!$this->groupInvite->contains($groupInvite)) {
            $this->groupInvite[] = $groupInvite;
        }

        return $this;
    }

    public function removeGroupInvite(Group $groupInvite): self
    {
        if ($this->groupInvite->contains($groupInvite)) {
            $this->groupInvite->removeElement($groupInvite);
        }

        return $this;
    }
}
