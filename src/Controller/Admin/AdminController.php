<?php
namespace App\Controller\Admin;

use App\Form\UserType;
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
   
    public function updateUser(UserRepository $repo, $id)
    {
        $user = $repo->findOneById($id);
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(UserType::class, $user);
        return $this->render('Admin/update.html.twig');

    }
    
    public function removeUser(UserRepository $repo, $id)
    {
        $user = $repo->findOneById($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute("Admin");
    }

    
}


