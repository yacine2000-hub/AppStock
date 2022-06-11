<?php

namespace App\Controller;
use App\Form\AddCategorie;
use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategorieRepository;

class CategorieController extends AbstractController
{
   
    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $db): Response
     {

        return $this->render('categorie/liste.html.twig', [
            'categorie'=> $db->findAll()
        ]);
     }
     
    #[Route('/categorie/add', name: 'categorie_add')]
    public function add(Request $request, EntityManagerInterface $em, CategorieRepository $repo){
        $categorie = new Categorie();
        $form = $this->createForm(AddCategorie::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ref = substr($categorie->getNom(),0, 3);
//            enregistrement local des changements
            $em->persist($categorie);
//            sauvegarde dans la db
//            suppression d'un client
//            $em->remove($client);
            $em->flush();
            $this->addFlash('success', 'Enregistrement OK');
            return $this->redirectToRoute('app_categorie');
        }

        return $this->render('categorie/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
