<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeHotelRepository")
 * @UniqueEntity(fields="libelle", message="Ce type existe deja")
 */
class TypeHotel
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
  * @ORM\OneToMany(targetEntity="App\Entity\Hotel", mappedBy="type")
  */
  private $hotels;

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
      $this->hotels = new ArrayCollection();
  }

  /**
   * @return Collection|Hotel[]
   */
  public function getHotels()
  {
      return $this->hotels;
  }
}
