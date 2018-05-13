<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="accueil_admin")
     */
    public function admin()
    {
      return $this->render('admininterface/adminindex.html.twig');
    }

    
}
?>
