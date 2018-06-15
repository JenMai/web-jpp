<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Table(name="app_attraction")
 * @ORM\Entity(repositoryClass="App\Repository\AttractionRepository")
 * @UniqueEntity(fields="libelle", message="Une attraction porte déjà ce nom.")
 */
class Attraction
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
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeAttraction", inversedBy="attractions")
     */
     private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $taillemini;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="text", length=255)
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
     *    mimeTypesMessage = "Le format de l'image est invalide ({{ type }}). Veuillez envoyer une image au format {{ types }}"
     * )
     */
    private $image;

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="attraction")
    */
    private $comments;

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

    public function getTaillemini()
    {
        return $this->taillemini;
    }

    public function setTaillemini($taillemini)
    {
        $this->taillemini = $taillemini;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
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

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }
}
