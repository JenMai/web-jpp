<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="E-mail déjà pris")
 * @UniqueEntity(fields="username", message="Pseudo déjà pris")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email(
     *  message = "L'e-mail '{{ value }}' n'est pas valide",
     *  checkMX = true
     * )
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * Encrypted password
     * @ORM\Column(type="string", length=80)
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumberOfChildren;

    /**
     * @ORM\Column(type="integer")
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $roles;

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="comment")
    */
    private $comments;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
      $this->isActive = true;
      $this->comments = new ArrayCollection();
    }

    // gets and sets
    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getNumberOfChildren()
    {
        return $this->NumberOfChildren;
    }

    public function setNumberOfChildren($NumberOfChildren)
    {
        $this->NumberOfChildren = $NumberOfChildren;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    public function setRoles($roles)
    {
      return $this->roles = $roles;
    }

    public function getRoles()
    {
      return array($this->roles);
    }

    public function getSalt()
    {
    // you *may* need a real salt depending on your encoder
    // see section on salt below
    return null;
    }

    public function eraseCredentials()
    {

    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    /** @see \Serializable:serialize() */
    public function serialize()
    {
      return serialize(array(
        $this->id,
        $this->username,
        $this->password,
        $this->isActive
      ));
    }
    /** @see \Serializable:unserialize() */
    public function unserialize($serialized)
    {
      list(
        $this->id,
        $this->username,
        $this->password,
        $this->isActive
        ) = unserialize($serialized);
    }
}
?>
