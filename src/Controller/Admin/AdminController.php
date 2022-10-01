<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;

class AdminController extends AbstractController
{
    public function users(UserRepository $repo)
    {
        $users = $repo->findall();
        return $this->render(
            'Admin/users.html.twig',
            [
                'users' => $users,
            ]
        );
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

