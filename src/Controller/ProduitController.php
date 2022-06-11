<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

use App\Entity\Produit;
use App\Form\AddProduit;
use App\Form\EditProduit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
     #[Route('/produit', name: 'app_produit')]
     public function produit(): Response
     {
         return $this->render('produit/index.html.twig', [
             'controller_name' => 'ProduitController',
         ]);
    }
    #[Route('/listeproduit', name: 'listeproduit')]
    public function index(ProduitRepository $db): Response
     {
         
        return $this->render('produit/liste.html.twig', [
            'produits'=> $db->findAll()
        ]);
    
     }
    #[Route('/produit/add', name: 'produit_add')]
    public function add(Request $request, EntityManagerInterface $em, ProduitRepository $repo){
        $produit = new Produit();
        $form = $this->createForm(AddProduit::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ref = substr($produit->getLibelle(),0, 3);

           
//            enregistrement local des changements
            $em->persist($produit);
//            sauvegarde dans la db
//            suppression d'un client
//            $em->remove($client);
            $em->flush();
            $this->addFlash('success', 'Enregistrement OK');
            return $this->redirectToRoute('listeproduit');
        }

        return $this->render('produit/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/produit/delete/{id}', name: 'produit_delete')]
    public function delete( $id, EntityManagerInterface $em,ProduitRepository $repo){
        $produit = $repo->find($id);
        if ($produit === null ){
            throw new NotFoundHttpException();
        }
        $em->flush();
        $this->addFlash('success','suppression OK');

        return $this->redirectToRoute('produit');
    }
    #[Route('/produit/update/{id}', name: 'produit_update')]
    public function update($id, Request $request, EntityManagerInterface $em,ProduitRepository $repo){

        $produit = $repo->find($id);
        $form = $this->createForm(EditProduit::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            dump($form);
            $em->persist($produit);
            $em->flush();
            $this->addFlash('success','modification OK');
            return $this->redirectToRoute('produit');
        }

        return $this->render('produit/edit.html.twig', [
            'form' => $form->createView(),
            'produit' => $produit
        ]);
    }

     #[Route('produit/search', name: 'produit_search')]
     public function getByLibelle(Request $request, ProduitRepository $repo)
     {
         $libelle = $request->query->get('libelle');
        $products = $repo->findByName($libelle);

        return new JsonResponse(
            array_map(
                function ($item) {return $item->serialize();},
                $products
            )
        );
     }

}
