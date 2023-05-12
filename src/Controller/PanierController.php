<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Articles;
use App\Entity\Panier;
use App\Entity\Ajouter;
use App\Entity\Commandes;
use App\Entity\AjoutCommandes;
use App\Entity\InfoCommande;
use App\Form\Commande1Type;
use App\Form\Commande2Type;

class PanierController extends AbstractController
{
    #[Route('/profile-panier', name: 'panier')]
    public function panier(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        if ($this->getUser()->getPanier() == null) {
            $this->getUser()->setPanier(new Panier());
            $entityManagerInterface->persist($this->getUser());
            $entityManagerInterface->flush();
        }
        return $this->render('panier/index.html.twig', [
            
        ]);
    }

    #[Route('/profile-panier-vide', name: 'paniervide')]
    public function paniervide(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $this->addFlash('notice', 'Erreur : panier vide');
        return $this->render('panier/index.html.twig', [
            
        ]);
    }

    #[Route('/profile-modif-panier', name: 'modifpanier')]
    public function modif_panier(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id = $request->get('id');
        $page = $request->get('page');
        $action = $request->get('action');
        $panier = $entityManagerInterface->getRepository(Panier::class)->find($this->getUser()->getPanier());
        $produits = $panier->getAjouters();
        $ajouter = $entityManagerInterface->getRepository(Ajouter::class)->find($id);
        $article = $entityManagerInterface->getRepository(Articles::class)->find($id);
        $existeAjouter = $entityManagerInterface->getRepository(Ajouter::class)->findOneBy([
            'panier' => $panier,
            'article' => $article
        ]);;
        if ($action == 'ajouter') {
            if ($this->getUser()->getPanier() == null) {
                $this->getUser()->setPanier(new Panier());
                $entityManagerInterface->persist($this->getUser());
                $entityManagerInterface->flush();
                $new_ajout = new Ajouter;
                $new_ajout->setPanier($panier);
                $new_ajout->setQte(1);
                $new_ajout->setArticle($article);
                $article->setQteStock($article->getQteStock()-1);
                $entityManagerInterface->persist($new_ajout);
                $entityManagerInterface->persist($article);
            } else if ($existeAjouter){
                $existeAjouter->setQte($existeAjouter->getQte()+1);
                $article->setQteStock($article->getQteStock()-1);
                $entityManagerInterface->persist($article);
                $entityManagerInterface->persist($existeAjouter);
            } else {
                $new_ajout = new Ajouter;
                $new_ajout->setPanier($panier);
                $new_ajout->setQte(1);
                $new_ajout->setArticle($article);
                $article->setQteStock($article->getQteStock()-1);
                $entityManagerInterface->persist($article);
                $entityManagerInterface->persist($new_ajout);
            }
        }
        if ($action == 'supprimer') {
            $ajouter->getArticle()->setQteStock($ajouter->getArticle()->getQteStock()+$ajouter->getQte());
            $panier->removeAjouter($ajouter);
            $entityManagerInterface->persist($panier);
        }
        if ($action == 'addqte') {
            $ajouter->setQte($ajouter->getQte()+1);
            $ajouter->getArticle()->setQteStock($ajouter->getArticle()->getQteStock()-1);
            $entityManagerInterface->persist($ajouter);
        }
        if ($action == 'suppqte') {
            if ($ajouter->getQte()>=1) {
                $ajouter->setQte($ajouter->getQte()-1);
                $ajouter->getArticle()->setQteStock($ajouter->getArticle()->getQteStock()+1);
            }
            if ($ajouter->getQte()==0) {
                $ajouter->getArticle()->setQteStock($ajouter->getArticle()->getQteStock()+1);
                $panier->removeAjouter($ajouter);
                $entityManagerInterface->persist($panier);
            }
            $entityManagerInterface->persist($ajouter);
        }
        if ($action == 'removePanier') {
            foreach($panier->getAjouters() as $ajout){
                $ajout->getArticle()->setQteStock($ajout->getArticle()->getQteStock()+$ajout->getQte());
                $panier->removeAjouter($ajout);
                $entityManagerInterface->persist($panier);
            }
        }
        
        $entityManagerInterface->flush();
        return $this->redirectToRoute($page, ['id' => $id]);
        return $this->render('panier/index.html.twig', [
            
        ]);
    }

    #[Route('/profile-commander-etape1', name: 'commander1')]
    public function commander1(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $panier = $entityManagerInterface->getRepository(Panier::class)->find($this->getUser()->getPanier());
        if (count($panier->getAjouters()) == 0) {
            $this->addFlash('notice', 'Erreur : panier vide');
        } else {
            $idcommande = new Commandes();
            $idcommande->setDate(new \Datetime());
            $this->getUser()->addCommande($idcommande);
            $infoCommande = new InfoCommande();
            $infoCommande->setCommande($idcommande);
            $form = $this->createForm(Commande1Type::class, $infoCommande);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                foreach($panier->getAjouters() as $ajout){
                    $new_ajout = new  AjoutCommandes();
                    $new_ajout->setQte($ajout->getQte());
                    $new_ajout->setPrixUnit($ajout->getArticle()->getPrix());
                    $new_ajout->setArticle($ajout->getArticle());
                    $new_ajout->setCommande($idcommande);
                    $idcommande->setTotalPrix($idcommande->getTotalPrix() + ($ajout->getArticle()->getPrix()*$ajout->getQte()));
                    $panier->removeAjouter($ajout);
                    $entityManagerInterface->persist($panier);
                    $entityManagerInterface->persist($new_ajout);
                }
                $entityManagerInterface->persist($infoCommande);
                $entityManagerInterface->flush();
                
                return $this->redirectToRoute('commander2'); // Redirige vers la page du panier
            }
        }
        
        return $this->render('panier/commande1.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile-commander-etape2', name: 'commander2')]
    public function commander2(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(Commande2Type::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('commander3'); // Redirige vers la page du panier
        }
        return $this->render('panier/commande2.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile-commander-etape3', name: 'commander3')]
    public function commander3(EntityManagerInterface $entityManager, Request $request): Response
    {
         $user = $this->getUser();
         $derniereCommande = $this->getDoctrine()->getRepository(Commandes::class)->findOneBy(
             ['User' => $user],
             ['date' => 'DESC']
         );
        return $this->render('panier/commande3.html.twig', [
            'commande' => $derniereCommande,
        ]);
    }
}
