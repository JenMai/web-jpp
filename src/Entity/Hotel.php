<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
/**
 * @ORM\Table(name="app_hotel")
 * @ORM\Entity(repositoryClass="App\Repository\HotelRepository")
 * @UniqueEntity(fields="libelle", message="Un hotel porte deja ce nom.")
 */
class Hotel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=65, unique=true)
     * @Assert\NotBlank()
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeHotel", inversedBy="hotels")
     * @ORM\JoinColumn(nullable=true)
     */
     private $type;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Un hotel ne peut pas avoir en dessous de {{ limit }} etoiles.",
     *      maxMessage = "Un hotel ne peut pas avoir au dessus de {{ limit }} etoiles."
     * )
     */
    private $etoiles;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Image manquante")
     * @Assert\File(
     *    maxSize = "1024k",
     *    maxSizeMessage = "L'image est trop lourde ({{ size }} {{ suffix }}), veuillez envoyer une image pesant moins de {{ limit }} {{ suffix }}",
     *    mimeTypes={ "image/jpeg" },
     *    mimeTypesMessage = "Le format de l'image est invalide ({{ type}}). Veuillez envoyer une image au format {{ types }}"
     * )
     */
    private $image;

    // gets and sets

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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getEtoiles()
    {
        return $this->etoiles;
    }

    public function setEtoiles($etoiles)
    {
        $this->etoiles = $etoiles;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }
}
