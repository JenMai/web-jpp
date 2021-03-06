<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
  /**
   * @Route("/login", name="login")
   */
  public function login(Request $request, AuthenticationUtils $authUtils)
  {
    // login error (if any)
    $error = $authUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authUtils->getLastUsername();

    return $this->render('security/login.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error
    ));
  }
}

?>
