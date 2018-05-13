<?php
namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
  /**
   * @Route("/signup", name="user_registration")
   */
   public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
   {
     // 1) build the form
     $user = new User();
     $form = $this->createForm(UserType::class, $user);

     // 2) handle the submit (will only happen on POST)
     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {

       // 3) encode the password (could be done via Doctrine listener)
       $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
       $user->setPassword($password);

       // set roles
       $user->setRoles('ROLE_USER');

       // 4) save the User
       $em = $this->getDoctrine()->getManager();
       $em->persist($user);
       $em->flush();

       // 5) redirect
       return $this->redirectToRoute('login');
     }

     return $this->render(
         'registration/signup.html.twig',
         array('form' => $form->createView())
     );
   }
}
 ?>
