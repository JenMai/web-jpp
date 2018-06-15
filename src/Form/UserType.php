<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;

class UserType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('username', TextType::class, array(
        'label' => 'Nom d\'utilisateur'
      ))
      ->add('email', EmailType::class, array(
        'label' => 'Adresse e-mail'
      ))
      ->add('plainPassword', RepeatedType::class, array(
        'type' => PasswordType::class,
        'first_options' => array('label' => 'Mot de passe'),
        'second_options' => array('label' => 'Confirmation du mot de passe')
      ))
      ->add('NumberOfChildren', ChoiceType::class, array(
        'label' => 'Combien d\'enfants avez-vous ?',
        'choices' => array(
          'aucun' => 0,
          '1' => 1,
          '2' => 2,
          '3' => 3,
          '4' => 4,
          '5' => 5,
          '6 ou plus' => 6
        )
      ))
      ->add('country', ChoiceType::class, array(
        'label' => 'Pays / Region',
        'choices' => array(
          'France' => 0,
          'Autre' => 1
        )
        ))
      ->add('magicalworld', ChoiceType::class, array(
        'mapped' => false,
        'label' => 'A quel point aimez-vous le monde magique de Jean-Pierre Coffe ?',
        'choices' => array(
          'Pas du tout' => 0,
          'Un peu' => 1,
          'Beaucoup' => 2,
          'A LA FOLIE' => 3
        )
      ))

      ->add('termsAccepted', CheckboxType::class, array(
        'label' => 'J\'accepte les termes et conditions',
        'mapped' => false,
        'constraints' => new IsTrue()
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => User::class,
      ));
  }
}

?>
