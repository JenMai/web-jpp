<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Attraction;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeAttractionRepository")
 * @UniqueEntity(fields="libelle", message="Ce type existe deja")
 */
class TypeAttraction
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
    * @ORM\OneToMany(targetEntity="App\Entity\Attraction", mappedBy="type")
    */
    private $attractions;

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

    public function __toString() {
    return $this->libelle;
    }

    public function __construct()
    {
        $this->attractions = new ArrayCollection();
    }

    /**
     * @return Collection|Attraction[]
     */
    public function getAttractions()
    {
        return $this->attractions;
    }
}
