<?php
namespace App\Controller;

use App\Form\HotelType;
use App\Form\THotelType;
use App\Entity\Hotel;
use App\Entity\TypeHotel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;

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

         $this->addFlash(
            'notice',
            'Hôtel ajouté !');

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
       $hoteldel = $this->checkID($slug);

       // Delete from db
       $em = $this->getDoctrine()->getManager();
       $em->remove($hoteldel);
       $em->flush();

       $this->addFlash(
          'notice',
          'Hôtel supprimé !');

       return $this->redirectToRoute('liste_hotels');
     }

     // Todo
     /**
      * @Route("/admin/hotels/editer={slug}", name="edit_hotel")
      */
     public function edit($slug)
     {
       // get hotel with id
       $hoteledit = $this->checkID($slug);

       // build the form
       // todo: fix empty filetype form?
       $hoteledit->setImage(
         new File($this->getParameter('images_directory_h').'/'.$hoteledit->getImage())
     );
       $form = $this->createForm(hotelType::class, $hoteledit);

       // handle the submit (will only happen on POST)
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid())
       {

         $data= $form->getData();
         // Edit in database
         $em = $this->getDoctrine()->getManager();
         $hoteledit->setLibelle($data->getLibelle());
         $hoteledit->setType($data->getType());
         $hoteledit->setEtoiles($data->getEtoiles());
         $hoteledit->setPrix($data->getPrix());
         $hoteledit->setDescription($data->getDescription());

         // $file stores the uploaded image file
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
         $file = $data->getImage();

         $filename = md5(uniqid()).'.'.$file->guessExtension();

         // moves the file to the directory where images are stored
         $file->move(
             $this->getParameter('images_directory_h'),
             $filename
         );

         $data->setImage($filename);

         $em->flush();

         $this->addFlash(
            'notice',
            'HÔtel modifié !');

          return $this->redirectToRoute('liste_hotels');
        }

          return $this->render(
               'admininterface/hotels/edithotel.html.twig',
               ['form' => $form->createView(),
                    'hotel' => $hoteledit]
           );
     }

     // types

     /**
      * @Route("/admin/hotels/types", name="liste_type_hotel")
      */
      public function showtype()
      {
        $types = $this->getDoctrine()
                           ->getRepository(TypeHotel::class)
                           ->findAll();
        // print items with {{ typehotels }}
       return $this->render('admininterface/hotels/listtype.html.twig',
             ['types' => $types]);
      }

      /**
       * @Route("/admin/hotels/types/ajouter", name="nouv_type_hotel")
       */
       public function newtype(Request $request)
       {
         // 1) build the form
         $type = new TypeHotel();
         $form = $this->createForm(THotelType::class, $type);

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

           return $this->redirectToRoute('nouv_type_hotel');
         }

         return $this->render(
              'admininterface/hotels/addtype.html.twig',
              ['form' => $form->createView()]
          );
       }

      /**
       * @Route("/admin/hotels/types/supprimer={slug}", name="suppr_type_hotel")
       */
      public function deletetype($slug)
      {
        // get type hotel with id
        $typedel = $this->getDoctrine()
                           ->getRepository(TypeHotel::class)
                           ->find($slug);

        if (!$typedel)
        {
             throw $this->createNotFoundException(
                 'Aucun type d\'hôtel avec l\'id '.$slug
             );
         }

        // check whether type is linked to existing hotels
        $linkedhotels = $typedel->gethotels();

        if(!($linkedhotels->isEmpty()))
        {
          throw $this->createNotFoundException(
              'Des hôtels sont liés à ce type, veuillez les supprimer au préalable'
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
        return $this->redirectToRoute('liste_type_hotel');
      }

     private function checkID($input)
     {
       // get entity with id
       $entity = $this->getDoctrine()
                      ->getRepository(Hotel::class)
                      ->find($input);

       if (!$entity)
       {
            throw $this->createNotFoundException(
                'Aucun hôtel avec l\'id '.$input
            );
        }
        else
        {
          return $entity;
        }
     }
}
?>
