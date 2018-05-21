<?php
namespace App\Controller;

use App\Form\RestaurantType;
use App\Form\TRestaurantType;
use App\Entity\Restaurant;
use App\Entity\TypeRestaurant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;

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

         // $file stores the uploaded file
         /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
         $file = $restaurant->getImage();

         $filename = md5(uniqid()).'.'.$file->guessExtension();

         // moves the file to the directory where images are stored
         $file->move(
             $this->getParameter('images_directory_r'),
             $filename
         );

         $restaurant->setImage($filename);

         $em = $this->getDoctrine()->getManager();
         $em->persist($restaurant);
         $em->flush();


         $this->addFlash(
            'notice',
            'Restaurant ajouté !');

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
       $restaurantdel = $this->checkID($slug);

       // Delete from db
       $em = $this->getDoctrine()->getManager();
       $em->remove($restaurantdel);
       $em->flush();

       $this->addFlash(
          'notice',
          'Restaurant supprimé !');

       return $this->redirectToRoute('liste_restaurants');
     }

     // Todo : fix img upload
     /**
      * @Route("/admin/restaurants/editer={slug}", name="edit_restaurant")
      */
     public function edit($slug, Request $request)
     {
       // get restaurant with id
       $restaurantedit = $this->checkID($slug);
       // build the form
       // todo: fix empty filetype form?
       $restaurantedit->setImage(
         new File($this->getParameter('images_directory_r').'/'.$restaurantedit->getImage())
     );
       $form = $this->createForm(RestaurantType::class, $restaurantedit);

       // handle the submit (will only happen on POST)
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid())
       {

         $data= $form->getData();
         // Edit in database
         $em = $this->getDoctrine()->getManager();
         $restaurantedit->setLibelle($data->getLibelle());
         $restaurantedit->setType($data->getType());
         $restaurantedit->setVege($data->getVege());
         $restaurantedit->setDescription($data->getDescription());

         // $file stores the uploaded image file
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
         $file = $data->getImage();

         $filename = md5(uniqid()).'.'.$file->guessExtension();

         // moves the file to the directory where images are stored
         $file->move(
             $this->getParameter('images_directory_r'),
             $filename
         );

         $data->setImage($filename);

         $em->flush();

         $this->addFlash(
            'notice',
            'Restaurant modifié !');

          return $this->redirectToRoute('liste_restaurants');
        }

          return $this->render(
               'admininterface/restaurants/editrestaurant.html.twig',
               ['form' => $form->createView(),
                    'restaurant' => $restaurantedit]
           );
     }

     // types

     /**
      * @Route("/admin/restaurants/types", name="liste_type_restaurant")
      */
      public function showtype()
      {
        $types = $this->getDoctrine()
                           ->getRepository(TypeRestaurant::class)
                           ->findAll();
        // print items with {{ typerestaurants }}
       return $this->render('admininterface/restaurants/listtype.html.twig',
             ['types' => $types]);
      }

      /**
       * @Route("/admin/restaurants/types/ajouter", name="nouv_type_restaurant")
       */
       public function newtype(Request $request)
       {
         // 1) build the form
         $type = new TypeRestaurant();
         $form = $this->createForm(TRestaurantType::class, $type);

         // 2) handle the submit (will only happen on POST)
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid())
         {
           // 3) Save into db
           $em = $this->getDoctrine()->getManager();
           $em->persist($type);
           $em->flush();

          // todo: displays 4 times ?
           $this->addFlash(
              'notice',
              'Type ajouté !');

           return $this->redirectToRoute('nouv_type_restaurant');
         }

         return $this->render(
              'admininterface/restaurants/addtype.html.twig',
              ['form' => $form->createView()]
          );
       }

      /**
       * @Route("/admin/restaurants/types/supprimer={slug}", name="suppr_type_restaurant")
       */
      public function deletetype($slug)
      {
        // get type restaurant with id
        $typedel = $this->getDoctrine()
                           ->getRepository(TypeRestaurant::class)
                           ->find($slug);

        if (!$typedel)
        {
             throw $this->createNotFoundException(
                 'Aucun type de restaurant avec l\'id '.$slug
             );
         }

        // check whether type is linked to existing restaurants
        $linkedrestaurants = $typedel->getrestaurants();

        if(!($linkedrestaurants->isEmpty()))
        {
          throw $this->createNotFoundException(
              'Des restaurants sont liés à ce type, veuillez les supprimer au préalable'
          );
        }


        // Delete from db
        $em = $this->getDoctrine()->getManager();
        $em->remove($typedel);
        $em->flush();

        $this->addFlash(
           'notice',
           'Type supprimé !');

        // Refresh
        return $this->redirectToRoute('liste_type_restaurant');
      }

      private function checkID($input)
      {
        // get entity with id
        $entity = $this->getDoctrine()
                       ->getRepository(Restaurant::class)
                       ->find($input);

        if (!$entity)
        {
             throw $this->createNotFoundException(
                 'Aucun restaurant avec l\'id '.$input
             );
         }
         else
         {
           return $entity;
         }
      }
}
?>
