<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;



class ChangePassword
{
    
    private $ancienPassword;


    private $nouveauPassword;


    /**
    * @Assert\EqualTo(propertyPath="nouveauPassword" , message="Les deux mots de passe ne sont pas identiques")
    */
    private $confirmPassword;


    public function getAncienPassword(): ?string
    {
        return $this->ancienPassword;
    }

    public function setAncienPassword(string $ancienPassword): self
    {
        $this->ancienPassword = $ancienPassword;

        return $this;
    }

    public function getNouveauPassword(): ?string
    {
        return $this->nouveauPassword;
    }

    public function setNouveauPassword(string $nouveauPassword): self
    {
        $this->nouveauPassword = $nouveauPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
