<?php
namespace App\Controller;

use App\Entity\Attraction;
use App\Entity\Restaurant;
use App\Entity\Hotel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        // Todo: randomize
        $attraction = $this->getDoctrine()
                        ->getRepository(Attraction::class)
                        ->find(1);


        return $this->render('frontinterface/index.html.twig',
                ['attraction' => $attraction]);
    }


}
?>
