<?php

namespace App\Controller;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use App\Form\UserPassword;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPasswordController extends AbstractController
{   

    public function editPassword(Request $request, UserPasswordEncoderInterface $encoder, UserRepository $repo, $id)
    {

        $user = $repo->findOneById($id); 

        $form = $this->createForm(UserPassword::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $encoder->encodePassword($user, $user -> getPlainPassword());

            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();


            return $this->redirectToRoute('edit.password',['id' => $id]);
        }

        return $this->render('User/password.html.twig', array('form' => $form->createView()));
    }
}