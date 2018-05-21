<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserAdminType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("/admin/utilisateurs", name="liste_utilisateurs")
     */
     public function show()
     {
       $users = $this->getDoctrine()
                          ->getRepository(User::class)
                          ->findAll();
       // print items with {{ users }}
      return $this->render('admininterface/adminutilisateurs/listutilisateurs.html.twig',
            ['utilisateurs' => $users]);
     }

     /**
      * @Route("/admin/utilisateurs/editer={slug}", name="edit_utilisateur")
      */
      public function edit($slug, Request $request)
      {
        // get user with id
        $useredit = $this->getDoctrine()
                           ->getRepository(User::class)
                           ->find($slug);

       if (!$useredit)
       {
            throw $this->createNotFoundException(
                'Aucun utilisateur avec l\'id '.$slug
            );
        }
        // build the form
        $form = $this->createForm(UserAdminType::class, $useredit);

        // handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

          $data= $form->getData();
          // Edit in database
          $em = $this->getDoctrine()->getManager();
          $useredit->setUsername($data->getUsername());
          $useredit->setEmail($data->getEmail());
          // todo: edit roles

          $em->flush();

          $this->addFlash(
             'notice',
             'Utilisateur modifié !');

          return $this->redirectToRoute('liste_utilisateurs');
        }

        return $this->render(
             'admininterface/adminutilisateurs/editutilisateur.html.twig',
             ['form' => $form->createView(),
                  'utilisateur' => $useredit]
         );
      }

      /**
       * @Route("/admin/utilisateurs/supprimer={slug}", name="suppr_utilisateur")
       */
      public function delete($slug)
      {
        // get user with id
        $userdel = $this->getDoctrine()
                           ->getRepository(User::class)
                           ->find($slug);

       if (!$userdel)
       {
            throw $this->createNotFoundException(
                'Aucun utilisateur avec l\'id '.$slug
            );
        }

        // Delete from db
        $em = $this->getDoctrine()->getManager();
        $em->remove($userdel);
        $em->flush();

        $this->addFlash(
           'notice',
           'Utilisateur supprimé !');

        return $this->redirectToRoute('liste_utilisateurs');
      }

      /**
       * @Route("/admin/utilisateurs/commentaires={slug}", name="commentaires_utilisateur")
       */
      public function showComments()
      {
        // get attraction with id
        // todo: make it a separate method
        $user = $this->getDoctrine()
                           ->getRepository(User::class)
                           ->find($slug);

        if (!$user)
        {
            throw $this->createNotFoundException(
                'Aucun utilisateur avec l\'id '.$slug
            );
        }

        $linkedcomments = $user->getComments();

        // print items with {{ typeattractions }}
       return $this->render('admininterface/utilisateurs/listcomments.html.twig',
             ['comments' => $comments]);

      }

}
?>
