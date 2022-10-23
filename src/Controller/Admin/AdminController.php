<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserEdit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;



class AdminController extends AbstractController
{
    public function users(UserRepository $repo)
    {
        $users = $repo->findAll(); 
        return $this->render(
            'Admin/users.html.twig',
            [
                'users' => $users,

            ]

        );
    }





    /**
     * @Route("/admin/edit/{id}", name="editUser")
     */
    public function editUser(Request $request, User $user, UserRepository $repo, $id): Response
    {
        
        $user = $repo->findOneById($id);
        $form = $this->createForm(UserEdit::class, $user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 

        {
       
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute("admin");
        }
        
        return $this->render
            ('Admin/update.html.twig',
            array('form' => $form->createView())
        );
    }
    


    




    public function removeUser(UserRepository $repo, $id)
    {
        $user = $repo->findOneById($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute("admin");
    }
}