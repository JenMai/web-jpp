<?php
namespace App\Controller;

use App\Form\HotelType;
use App\Entity\Hotel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

// todo : centralize list and type list?

class HotelController extends Controller
{
    /**
     * @Route("/admin/hotels", name="liste_hotels")
     */
     public function show()
     {
       $hotels = $this->getDoctrine()
                          ->getRepository(Hotel::class)
                          ->findAll();
       // in the template, print items with {{ hotels }}
      return $this->render('admininterface/hotels/listhotels.html.twig',
            ['hotels' => $hotels]);
     }

    /**
     * @Route("/admin/hotels/ajouter-hotel", name="nouv_hotel")
     */
     public function new(Request $request)
     {
       // 1) build the form
       $hotel = new Hotel();
       $form = $this->createForm(HotelType::class, $hotel);

       // 2) handle the submit (will only happen on POST)
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid())
       {
         // 3) Save into db
         $em = $this->getDoctrine()->getManager();
         $em->persist($hotel);
         $em->flush();

        // todo: displays 4 times ?
         $this->addFlash(
            'notice',
            'Hotel ajoute !');

         return $this->redirectToRoute('nouv_hotel');
       }

       return $this->render(
            'admininterface/hotels/addhotel.html.twig',
            array('form' => $form->createView())
        );
     }

     /**
      * @Route("/admin/hotels/supprimer={slug}", name="suppr_hotel")
      */
     public function delete($slug)
     {
       // get hotel with id
       $hoteldel = $this->getDoctrine()
                          ->getRepository(Hotel::class)
                          ->find($slug);

       if (!$hoteldel)
       {
            throw $this->createNotFoundException(
                'Aucun hotel avec l\'id ! '.$slug
            );
        }

       // Delete from db
       $em = $this->getDoctrine()->getManager();
       $em->remove($hoteldel);
       $em->flush;

       $this->addFlash(
          'notice',
          'Hotel supprime !');

       // todo: refresh
       return $this->render('admininterface/hotels/listhotels.html.twig');
     }

     // Todo
     /**
      * @Route("/admin/hotels/editer/{slug}", name="edit_hotel")
      */
     public function edit($slug)
     {
       // get hotel with id
       $hoteledit = $this->getDoctrine()
                          ->getRepository(Hotel::class)
                          ->find($slug);

      if (!$hoteledit)
      {
           throw $this->createNotFoundException(
               'Aucune hotel avec l\'id ! '.$slug
           );
       }

       // Delete from db
       $em = $this->getDoctrine()->getManager();
       $em->remove($hoteldel);
       $em->flush;

       $this->addFlash(
          'notice',
          'Hotel supprime !');

       // todo: refresh
       return $this->render('admininterface/hotels/listhotels.html.twig');
     }
}
?>
