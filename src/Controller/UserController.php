<?php
namespace App\Controller;
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
      return $this->render('admininterface/attractions/listattractions.html.twig',
            ['users' => $users]);
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
          $useredit->setNumberOfChildren($data->getNumberOfChildren());
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

        // todo: refresh
        return $this->redirectToRoute('liste_utilisateurs');
      }
}
?>
