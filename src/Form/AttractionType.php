<?php
namespace App\Form;

use App\Entity\Attraction;
use App\Entity\TypeAttraction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AttractionType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('libelle', TextType::class, array(
        'label' => 'Libelle'
      ))
      ->add('type', EntityType::class, array(
        'label' => 'Type',
        'class' => TypeAttraction::class
      ))
      ->add('taillemini', TextType::class, array(
        'label' => 'Taille minimale requise'
      ))
      ->add('age', IntegerType::class, array(
        'label' => 'Age cible'
      ))
      ->add('image', FileType::class, array(
        'label' => 'Image'
      ))

      ->add('description', TextareaType::class, array(
        'label' => 'Description'
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => Attraction::class,
      ));
  }
}

?>
