<?php
namespace App\Controller;

use App\Form\AttractionType;
use App\Form\TAttractionType;
use App\Entity\Attraction;
use App\Entity\TypeAttraction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;

class AttractionController extends Controller
{
    /**
     * @Route("/attractions", name="front_attractions")
     */
     public function show()
     {
       $attractions = $this->getDoctrine()
                          ->getRepository(Attraction::class)
                          ->findAll();
       // print items with {{ attractions }}
      return $this->render('frontinterface/attractions/listattractions.html.twig',
            ['attractions' => $attractions]);
     }

    /**
     * @Route("/attractions/{name}", name="front_attraction_info")
     */
    public function attraction($name)
    {
        $repository = $this->getDoctrine()
                           ->getRepository(Attraction::class);
        $name = str_replace('_',' ',$name);
        //$name = str_replace('-',' ',$name);

        $attraction = $repository->findOneBy(['libelle' => $name]);

        if (!$attraction) {
            throw $this->createNotFoundException(
                'Pas d\'attraction trouvée portant le nom : '.$name
            );
        }

        return $this->render('frontinterface/attractions/infoattraction.html.twig',
            ['attraction' => $attraction]);

    }


    /**
     * @Route("/admin/attractions", name="liste_attractions")
     */
     public function adminShow()
     {
       $attractions = $this->getDoctrine()
                          ->getRepository(Attraction::class)
                          ->findAll();
       // print items with {{ attractions }}
      return $this->render('admininterface/attractions/listattractions.html.twig',
            ['attractions' => $attractions]);
     }

    /**
     * @Route("/admin/attractions/ajouter-attraction", name="nouv_attraction")
     */
     public function new(Request $request)
     {
       // 1) build the form
       $attraction = new Attraction();
       $form = $this->createForm(AttractionType::class, $attraction);

       // 2) handle the submit (will only happen on POST)
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid())
       {
         // 3) Save into db

         // $file stores the uploaded file
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
         $file = $attraction->getImage();

         $filename = md5(uniqid()).'.'.$file->guessExtension();

         // moves the file to the directory where images are stored
         $file->move(
             $this->getParameter('images_directory_a'),
             $filename
         );

         $attraction->setImage($filename);

         $em = $this->getDoctrine()->getManager();
         $em->persist($attraction);
         $em->flush();

         $this->addFlash(
            'notice',
            'Attraction ajoutée !');

         return $this->redirectToRoute('nouv_attraction');
       }

       return $this->render(
            'admininterface/attractions/addattraction.html.twig',
            ['form' => $form->createView()]
        );
     }

    /**
     * @Route("/admin/attractions/supprimer={slug}", name="suppr_attraction")
     */
    public function delete($slug)
    {
      // get attraction with id
      $attractiondel = $this->checkID($slug);

      // Delete from db
      $em = $this->getDoctrine()->getManager();
      $em->remove($attractiondel);
      $em->flush();

      $this->addFlash(
         'notice',
         'Attraction supprimée !');

      // todo: refresh
      return $this->redirectToRoute('liste_attractions');
    }

    // Todo : fix img upload
    /**
     * @Route("/admin/attractions/editer={slug}", name="edit_attraction")
     */
    public function edit($slug, Request $request)
    {
      // get attraction with id
      $attractionedit = $this->checkID($slug);

      // build the form
      // todo: fix empty filetype form?
      $attractionedit->setImage(
        new File($this->getParameter('images_directory_a').'/'.$attractionedit->getImage())
    );
      $form = $this->createForm(AttractionType::class, $attractionedit);

      // handle the submit (will only happen on POST)
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid())
      {

        $data= $form->getData();
        // Edit in database
        $em = $this->getDoctrine()->getManager();
        $attractionedit->setLibelle($data->getLibelle());
        $attractionedit->setType($data->getType());
        $attractionedit->setTaillemini($data->getTaillemini());
        $attractionedit->setAge($data->getAge());
        $attractionedit->setDescription($data->getDescription());

        // $file stores the uploaded PDF file
       /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $data->getImage();

        $filename = md5(uniqid()).'.'.$file->guessExtension();

        // moves the file to the directory where images are stored
        $file->move(
            $this->getParameter('images_directory_a'),
            $filename
        );

        $data->setImage($filename);

        $em->flush();

       // todo: displays 4 times ?
        $this->addFlash(
           'notice',
           'Attraction modifiée !');

        return $this->redirectToRoute('liste_attractions');
      }

      return $this->render(
           'admininterface/attractions/editattraction.html.twig',
           ['form' => $form->createView(),
                'attraction' => $attractionedit]
       );
    }


    /**
     * @Route("/admin/attractions/commentaires={slug}", name="commentaires_attraction")
     */
    public function showComments($slug)
    {
      // get attraction with id
      $attraction = $this->checkID($slug);

      $linkedcomments = $attraction->getComments();

      // print items with {{ comments }}
     return $this->render('admininterface/attractions/listcomments.html.twig',
           ['comments' => $linkedcomments]);

    }

    /**
     * @Route("/admin/attractions/commentaires={slug}/suppr={slugcom}", name="suppr_commentaire_attr")
     */
    public function deleteComments($slug, $slugcom)
    {
      // get attraction with id
      $attraction = $this->checkID($slug);

      // get comment with id
      $comment = $this->getDoctrine()
                         ->getRepository(Comment::class)
                         ->find($slugcom);

      if (!$comment)
      {
          throw $this->createNotFoundException(
              'Aucun commentaire avec l\'id '.$slugcom
          );
      }

      // Delete from db
      $em = $this->getDoctrine()->getManager();
      $em->remove($comment);
      $em->flush();

      $this->addFlash(
         'notice',
         'Commentaire supprimé !');

      // todo: refresh
      return $this->redirectToRoute('commentaires_attraction',
                                      array('slug' => $slug));

    }

    // types

    /**
     * @Route("/admin/attractions/types", name="liste_type_attraction")
     */
     public function showtype()
     {
       $types = $this->getDoctrine()
                          ->getRepository(TypeAttraction::class)
                          ->findAll();
       // print items with {{ typeattractions }}
      return $this->render('admininterface/attractions/listtype.html.twig',
            ['types' => $types]);
     }

     /**
      * @Route("/admin/attractions/types/ajouter", name="nouv_type_attraction")
      */
      public function newtype(Request $request)
      {
        // 1) build the form
        $type = new TypeAttraction();
        $form = $this->createForm(TAttractionType::class, $type);

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

          return $this->redirectToRoute('nouv_type_attraction');
        }

        return $this->render(
             'admininterface/attractions/addtype.html.twig',
             ['form' => $form->createView()]
         );
      }

     /**
      * @Route("/admin/attractions/types/supprimer={slug}", name="suppr_type_attraction")
      */
     public function deletetype($slug)
     {
       // get attraction with id
       $typedel = $this->getDoctrine()
                          ->getRepository(TypeAttraction::class)
                          ->find($slug);

       if (!$typedel)
       {
            throw $this->createNotFoundException(
                'Aucun type d\'attraction avec l\'id '.$slug
            );
        }

       // check whether type is linked to existing attractions
       $linkedattractions = $typedel->getAttractions();

       if(!($linkedattractions->isEmpty()))
       {
         throw $this->createNotFoundException(
             'Des attractions sont liées à ce type, veuillez les supprimer au préalable'
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
       return $this->redirectToRoute('liste_type_attraction');
     }

     private function checkID($input)
     {
       // get entity with id
       $entity = $this->getDoctrine()
                      ->getRepository(Attraction::class)
                      ->find($input);

       if (!$entity)
       {
            throw $this->createNotFoundException(
                'Aucune attraction avec l\'id '.$input
            );
        }
        else
        {
          return $entity;
        }
     }
}
?>
