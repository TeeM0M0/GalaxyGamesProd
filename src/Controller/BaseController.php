<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Articles;
use App\Entity\Carousel;
use App\Entity\CarouselCollector;
use App\Entity\CarouselLicence;
use App\Form\ModifProfilType;

class BaseController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $date = new \Datetime();
        
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $carousel = $entityManagerInterface->getRepository(Carousel::class)->findAll();
        $carouselCollector = $entityManagerInterface->getRepository(CarouselCollector::class)->findAll();
        $carouselLicence = $entityManagerInterface->getRepository(CarouselLicence::class)->findAll();


        return $this->render('base/index.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
            'carousel'=>$carousel,
            'carouselCollector'=>$carouselCollector,
            'carouselLicence'=>$carouselLicence,

        ]);
    }
    
    #[Route('/qui-sommes-nous', name: 'quiSommesNous')]
    public function quiSommesNous(): Response
    {
        return $this->render('base/quiSommesNous.html.twig', [
            
        ]);
    }

     
    #[Route('/mentions-legales', name: 'mentionslegales')]
    public function mentionslegales(): Response
    {
        return $this->render('base/mentionslegale.html.twig', [
            
        ]);
    }

      
    #[Route('/conditions-vente', name: 'conditionsVente')]
    public function conditionsVente(): Response
    {
        return $this->render('base/conditionsVente.html.twig', [
            
        ]);
    }

    #[Route('/contacter', name: 'contacter')]
    public function contacter(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $contact = new Contact();
        $contact->setStatut(0);
        $form = $this->createForm(ContactType::class, $contact);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $this->addFlash('notice','Message envoyé');
                $entityManagerInterface->persist($contact);
                $entityManagerInterface->flush();
                return $this->redirectToRoute('contacter');
            }
        }
        return $this->render('base/contacter.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/profil', name: 'profil')]
    public function profil(EntityManagerInterface $entityManagerInterface): Response
    {
        $repoUtilisateur = $entityManagerInterface->getRepository(User::class);
        $utilisateur = $repoUtilisateur->findAll();
        return $this->render('base/profil.html.twig', [
            'utilisateurs' => $utilisateur
        ]);
    }

    #[Route('/modif-profil', name: 'modifprofil')]
    public function modifcategorie(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {   
        $id = $this->getUser()->getId();
        $repoUtilisateur = $entityManagerInterface->getRepository(User::class);
        $utilisateur = $repoUtilisateur->find($id);
        $form = $this->createForm(ModifProfilType::class, $utilisateur);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $entityManagerInterface->persist($utilisateur);
                $entityManagerInterface->flush();

                $this->addFlash('notice','profil modifier');
                return $this->redirectToRoute('profil');
            }
        }
        return $this->render('base/modifProfil.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
