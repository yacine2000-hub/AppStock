<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\AddSortie;
use App\Form\AddSortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SortieRepository;

class SortieController extends AbstractController
{
    #[Route('/sortie', name: 'app_sortie')]
    public function index(): Response
    {
        return $this->render('sortie/add.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }
    #[Route('/listesortie', name: 'listesortie')]
    public function liste(SortieRepository $repo): Response
     {

        return $this->render('sortie/liste.html.twig', [
            'sorties'=> $repo->findAll()
        ]);
    
     }
    #[Route('/sortie/add', name: 'sortie_add')]
    public function add(Request $request, EntityManagerInterface $em, SortieRepository $repo){
        $sortie = new Sortie();
        $form = $this->createForm(AddSortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ref = substr($sortie->getproduit(),0, 3);
//            enregistrement local des changements
            $em->persist($sortie);
//            sauvegarde dans la db
//            suppression d'un client
//            $em->remove($client);
            $em->flush();
            $this->addFlash('success', 'Enregistrement OK');
            return $this->redirectToRoute('listesortie');
        }

        return $this->render('sortie/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
