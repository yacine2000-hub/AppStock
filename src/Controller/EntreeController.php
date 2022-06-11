<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Form\AddEntree;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EntreeRepository;

class EntreeController extends AbstractController
{
    #[Route('/entree', name: 'app_entree')]
    public function index(): Response
    {
        return $this->render('entree/add.html.twig', [
            'controller_name' => 'EntreeController',
        ]);
    }
    #[Route('/listeentree', name: 'listeentree')]
    public function liste(EntreeRepository $repo): Response
     {

        return $this->render('entree/liste.html.twig', [
            'entrees'=> $repo->findAll()
        ]);
    
     }
    #[Route('/entree/add', name: 'entree_add')]
    public function add(Request $request, EntityManagerInterface $em, EntreeRepository $repo){
        $entree = new Entree();
        $form = $this->createForm(AddEntree::class, $entree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ref = substr($entree->getproduit(),0, 3);
//            enregistrement local des changements
            $em->persist($entree);
//            sauvegarde dans la db
//            suppression d'un client
//            $em->remove($client);
            $em->flush();
            $this->addFlash('success', 'Enregistrement OK');
            return $this->redirectToRoute('listeentree');
        }

        return $this->render('entree/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
