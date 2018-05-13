<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRestaurantRepository")
* @UniqueEntity(fields="libelle", message="Ce type existe deja")
 */
class TypeRestaurant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $libelle;

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Restaurant", mappedBy="type")
    */
    private $restaurants;

    public function getId()
    {
        return $this->id;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    public function __construct()
    {
        $this->restaurants = new ArrayCollection();
    }

    /**
     * @return Collection|Restaurant[]
     */
    public function getRestaurants()
    {
        return $this->restaurants;
    }
}
