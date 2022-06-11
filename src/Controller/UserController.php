<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddUser ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('registration/register.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/user/add', name: 'user_add')]
    public function add(Request $request, EntityManagerInterface $em, UserRepository $repo){
        $user = new User();
        $form = $this->createForm(AddUser::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ref = substr($user->getNom(),0, 3);
//            enregistrement local des changements
            $em->persist($user);
//            sauvegarde dans la db
//            suppression d'un client
//            $em->remove($client);
            $em->flush();
            $this->addFlash('success', 'Enregistrement OK');
            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
