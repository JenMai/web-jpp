<?php
namespace App\Controller;

use App\Form\RestaurantType;
use App\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends Controller
{

    /**
     * @Route("/admin/restaurants", name="liste_restaurants")
     */
     public function show()
     {
       $restaurants = $this->getDoctrine()
                          ->getRepository(Restaurant::class)
                          ->findAll();
       // in the template, print items with {{ restaurants }}
      return $this->render('admininterface/restaurants/listrestaurants.html.twig',
            ['restaurants' => $restaurants]);
     }

    /**
     * @Route("/admin/restaurants/ajouter-restaurant", name="nouv_restaurant")
     */
     public function new(Request $request)
     {
       // 1) build the form
       $restaurant = new Restaurant();
       $form = $this->createForm(RestaurantType::class, $restaurant);

       // 2) handle the submit (will only happen on POST)
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid())
       {
         // 3) Save into db
         $em = $this->getDoctrine()->getManager();
         $em->persist($restaurant);
         $em->flush();

        // todo: displays 4 times ?
         $this->addFlash(
            'notice',
            'Restaurant ajoute !');

         return $this->redirectToRoute('nouv_restaurant');
       }

       return $this->render(
            'admininterface/restaurants/addrestaurant.html.twig',
            array('form' => $form->createView())
        );
     }

     /**
      * @Route("/admin/restaurants/supprimer={slug}", name="suppr_restaurant")
      */
     public function delete($slug)
     {
       // get restaurant with id
       $restaurantdel = $this->getDoctrine()
                          ->getRepository(Restaurant::class)
                          ->find($slug);

       if (!$restaurantdel)
       {
            throw $this->createNotFoundException(
                'Aucun restaurant avec l\'id ! '.$slug
            );
        }

       // Delete from db
       $em = $this->getDoctrine()->getManager();
       $em->remove($restaurantdel);
       $em->flush;

       $this->addFlash(
          'notice',
          'restaurant supprime !');

       // todo: refresh
       return $this->render('admininterface/restaurants/listrestaurants.html.twig');
     }

     // Todo
     /**
      * @Route("/admin/restaurants/editer/{slug}", name="edit_restaurant")
      */
     public function edit($slug)
     {
       // get restaurant with id
       $restaurantedit = $this->getDoctrine()
                          ->getRepository(Restaurant::class)
                          ->find($slug);

      if (!$restaurantedit)
      {
           throw $this->createNotFoundException(
               'Aucune restaurant avec l\'id ! '.$slug
           );
       }

       // Delete from db
       $em = $this->getDoctrine()->getManager();
       $em->remove($restaurantdel);
       $em->flush;

       $this->addFlash(
          'notice',
          'restaurant supprime !');

       // todo: refresh
       return $this->render('admininterface/restaurants/listrestaurants.html.twig');
     }

}
?>
