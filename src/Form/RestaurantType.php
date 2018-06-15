<?php
namespace App\Form;

use App\Entity\Restaurant;
use App\Entity\TypeRestaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RestaurantType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('libelle', TextType::class, array(
        'label' => 'Libelle'
      ))
      ->add('type', EntityType::class, array(
        'label' => 'Type',
        'class' => TypeRestaurant::class
      ))
      ->add('vege', CheckboxType::class, array(
        'label' => 'Options végétariennes disponibles',
        'required' => false
      ))

      ->add('image', FileType::class, array('label' => 'Image'))

      ->add('description', TextType::class, array(
        'label' => 'Description'
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => Restaurant::class
      ));
  }
}

?>
