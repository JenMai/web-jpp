<?php
namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class HotelType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('libelle', TextType::class, array(
        'label' => 'Libelle'
      ))
      ->add('type', EntityType::class, array(
        'label' => 'Type',
        'class' => TypeHotel::class
      ))
      ->add('etoiles', ChoiceType::class, array(
        'label' => 'Etoiles',
        'choices' => array(
          '1' => 1,
          '2' => 2,
          '3' => 3,
          '4' => 4,
          '5' => 5
        )
      ))
      ->add('prix', TextType::class, array(
        'label' => 'Prix actuel d\'une nuité'
      ))

      ->add('image', FileType::class, array('label' => 'Image'))

      ->add('description', TextType::class, array(
        'label' => 'Description'
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => Hotel::class,
      ));
  }
}

?>
