<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Genres;
use App\Form\AjoutGenreType;
use App\Entity\Langues;
use App\Form\AjoutLangueType;
use App\Entity\Platforme;
use App\Form\AjoutPlateformeType;
use App\Entity\Commandes;
use App\Entity\Carousel;
use App\Entity\CarouselCollector;
use App\Entity\CarouselLicence;
use App\Form\AjoutImageType;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Filesystem\Filesystem;

class AdminController extends AbstractController
{
    #[Route('/private-panel-admin', name: 'panelAdmin')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commandesRepository = $entityManager->getRepository(Commandes::class);
        $commandes = $commandesRepository->findAll();
        $recettes = $commandesRepository->createQueryBuilder('r')
            ->select('SUM(r.totalPrix)')
            ->getQuery()
            ->getSingleScalarResult();

        $userRepository = $entityManager->getRepository(User::class);
        $totalUsers = $userRepository->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $contactRepository = $entityManager->getRepository(Contact::class);
        $totalContact = $contactRepository->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('admin/panelAdmin.html.twig', [
            'totalUsers' => $totalUsers,
            'totalContact' => $totalContact,
            'commandes' => $commandes,
            'recettes'=>$recettes
        ]);
    }

    #[Route('/private-ajout-genre', name: 'ajoutgenre')]
    public function ajoutgenre(Request $request,EntityManagerInterface $entityManagerInterface): Response
    {
        $genre = new Genres();
        $form = $this->createForm(AjoutGenreType::class, $genre);
        $genres = $entityManagerInterface->getRepository(Genres::class)->findAll();
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $entityManagerInterface->persist($genre);
                $entityManagerInterface->flush();

                $this->addFlash('notice','Genre créé');
                return $this->redirectToRoute('ajoutgenre');
            }
        }

        return $this->render('admin/addGenre.html.twig', [
            'form' => $form->createView(),
            'genres'=>$genres 
        ]);
    }

    #[Route('/private-supp-genre', name: 'suppgenre')]
    public function suppgenre(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id = $request->get('id');
        $genre = $entityManagerInterface->getRepository(Genres::class)->find($id);
        $entityManagerInterface->remove($genre);
        $entityManagerInterface->flush();
        $this->addFlash('notice','genre supprimé');
        return $this->redirectToRoute('ajoutgenre');
        return $this->render('admin/addGenre.html.twig', [
        ]);
    }

    #[Route('/private-ajout-langue', name: 'ajoutlangue')]
    public function ajoutlangue(Request $request,EntityManagerInterface $entityManagerInterface): Response
    {
        $langue = new Langues();
        $form = $this->createForm(AjoutLangueType::class, $langue);
        $langues = $entityManagerInterface->getRepository(Langues::class)->findAll();
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $entityManagerInterface->persist($langue);
                $entityManagerInterface->flush();

                $this->addFlash('notice','langue créé');
                return $this->redirectToRoute('ajoutlangue');
            }
        }

        return $this->render('admin/addLangue.html.twig', [
            'form' => $form->createView(),
            'langues'=>$langues 
        ]);
    }

    #[Route('/private-supp-langue', name: 'supplangue')]
    public function supplangue(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id = $request->get('id');
        $Langue = $entityManagerInterface->getRepository(Langues::class)->find($id);
        $entityManagerInterface->remove($Langue);
        $entityManagerInterface->flush();
        $this->addFlash('notice','Langue supprimé');
        return $this->redirectToRoute('ajoutlangue');
        return $this->render('admin/addLangue.html.twig', [
        ]);
    }

    #[Route('/private-ajout-plateforme', name: 'ajoutplateforme')]
    public function ajoutplateforme(Request $request,EntityManagerInterface $entityManagerInterface): Response
    {
        $plateforme = new Platforme();
        $form = $this->createForm(AjoutPlateformeType::class, $plateforme);
        $plateformes = $entityManagerInterface->getRepository(Platforme::class)->findAll();
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $entityManagerInterface->persist($plateforme);
                $entityManagerInterface->flush();

                $this->addFlash('notice','plateforme créé');
                return $this->redirectToRoute('ajoutplateforme');
            }
        }

        return $this->render('admin/addPlateforme.html.twig', [
            'form' => $form->createView(),
            'plateformes'=>$plateformes 
        ]);
    }

    #[Route('/private-supp-plateforme', name: 'suppplateforme')]
    public function suppplateforme(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id = $request->get('id');
        $plateforme = $entityManagerInterface->getRepository(Platforme::class)->find($id);
        $entityManagerInterface->remove($plateforme);
        $entityManagerInterface->flush();
        $this->addFlash('notice','plateforme supprimé');
        return $this->redirectToRoute('ajoutplateforme');
        return $this->render('admin/addPlateforme.html.twig', [
        ]);
    }

    #[Route('/private-liste-utilisateur', name: 'listeutilisateur')]
    public function listeutilisateur(EntityManagerInterface $entityManagerInterface): Response
    {
        $utilisateurs = $entityManagerInterface->getRepository(User::class)->findAll();
        return $this->render('admin/liste-utilisateur.html.twig', [
            'utilisateurs'=>$utilisateurs 
        ]);
    }

    #[Route('/private-supp-utilisateur', name: 'supputilisateur')]
    public function supputilisateur(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id = $request->get('id');
        $utilisateur = $entityManagerInterface->getRepository(User::class)->find($id);
        $entityManagerInterface->remove($utilisateur);
        $entityManagerInterface->flush();
        $this->addFlash('notice','utilisateur supprimé');
        return $this->redirectToRoute('listeutilisateur');
        return $this->render('admin/liste-utilisateur.html.twig', [
        ]);
    }

    #[Route('/private-liste-message', name: 'listemessage')]
    public function listemessage(EntityManagerInterface $entityManagerInterface): Response
    {
        $messages = $entityManagerInterface->getRepository(Contact::class)->findAll();
        return $this->render('admin/liste-message.html.twig', [
            'messages'=>$messages 
        ]);
    }

    #[Route('/private-info-message/{id}', name: 'infomessage')]
    public function infomessage(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id = $request->get('id');
        $message = $entityManagerInterface->getRepository(Contact::class)->find($id);
        return $this->render('admin/info-message.html.twig', [
            'message'=>$message,
        ]);
    }

    #[Route('/private-fermer-message', name: 'fermermessage')]
    public function fermermessage(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id = $request->get('id');
        $message = $entityManagerInterface->getRepository(Contact::class)->find($id);
        $message->setStatut(1);
        $entityManagerInterface->persist($message);
        $entityManagerInterface->flush();
        return $this->redirectToRoute('listemessage');
        return $this->render('admin/info-message.html.twig', [
            'message'=>$message,
        ]);
    }

    #[Route('/private-liste-commande', name: 'listecommande')]
    public function listecommande(EntityManagerInterface $entityManagerInterface): Response
    {
        $commandes = $entityManagerInterface->getRepository(Commandes::class)->findAll();
        return $this->render('admin/liste-commande.html.twig', [
            'commandes'=>$commandes 
        ]);
    }

    #[Route('/private-info-commande/{id}', name: 'infocommande')]
    public function infocommande(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id = $request->get('id');
        $commande = $entityManagerInterface->getRepository(Commandes::class)->find($id);
        $articles = $commande->getAjoutCommandes();
        return $this->render('admin/info-commande.html.twig', [
            'articles'=>$articles,
            'id'=>$id,
        ]);
    }

    #[Route('/private-ajout-imgcarousel', name: 'ajout-imgcarousel')]
    public function addimgcarousel(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManagerInterface): Response
    {
        $images = $entityManagerInterface->getRepository(Carousel::class)->findAll();
        $image = new Carousel();
        $form = $this->createForm(AjoutImageType::class,$image);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $fichier = $form->get('images')->getData();
                    if($fichier){
                        $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                        $nomFichier = $slugger->slug($nomFichier);
                        $nomFichier = $nomFichier.'-'.uniqid().'.'.$fichier->guessExtension();    
                        try{      
                            $fichier->move($this->getParameter('file_directory')."/carousel", $nomFichier);
                            $image->setNomImage($nomFichier);
                            $entityManagerInterface->persist($image);
                            $entityManagerInterface->flush();  
                            $this->addFlash('notice', 'image ajouté au carousel');
                        }
                        catch(FileException $e){
                            $this->addFlash('notice', 'Erreur d\'envoi');
                        }
                    }
                 
                return $this->redirectToRoute('ajout-imgcarousel');
            }
        }
        return $this->render('admin/addImgCarousel.html.twig', [
            'form'=> $form->createView(),
            'images'=> $images,
        ]);
    }

    #[Route('/private-supp-imgcarousel', name: 'supp-imgcarousel')]
    public function suppimgcarousel(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $id = $request->get('id');
        $image = $entityManagerInterface->getRepository(Carousel::class)->find($id);
        $images = $entityManagerInterface->getRepository(Carousel::class)->findAll();
        $filesystem = new Filesystem();
        if (count($images) == 1) {
            $this->addFlash('notice', 'erreur : 1 image est requis au minimum');
        }else {
            $path = $this->getParameter('file_directory').'/carousel/'.$image->getNomImage();
            if ($filesystem->exists($path)) {
                $filesystem->remove($path);
            }
            $entityManagerInterface->remove($image);
            $entityManagerInterface->flush();
            $this->addFlash('notice', 'image supprimé');
        }
        return $this->redirectToRoute('ajout-imgcarousel');
        return $this->render('admin/addImgCarousel.html.twig', [
            
        ]);
    }

    #[Route('/private-ajout-imgcarouselcollector', name: 'ajout-imgcarouselcollector')]
    public function imgcarouselcollector(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManagerInterface): Response
    {
        $images = $entityManagerInterface->getRepository(CarouselCollector::class)->findAll();
        $image = new CarouselCollector();
        $form = $this->createForm(AjoutImageType::class,$image);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $fichier = $form->get('images')->getData();
                    if($fichier){
                        $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                        $nomFichier = $slugger->slug($nomFichier);
                        $nomFichier = $nomFichier.'-'.uniqid().'.'.$fichier->guessExtension();    
                        try{      
                            $fichier->move($this->getParameter('file_directory')."/carousel-collector", $nomFichier);
                            $image->setNomImage($nomFichier);
                            $entityManagerInterface->persist($image);
                            $entityManagerInterface->flush();  
                            $this->addFlash('notice', 'image ajouté au carousel');
                        }
                        catch(FileException $e){
                            $this->addFlash('notice', 'Erreur d\'envoi');
                        }
                    }
                 
                return $this->redirectToRoute('ajout-imgcarouselcollector');
            }
        }
        return $this->render('admin/addImgCarouselCollector.html.twig', [
            'form'=> $form->createView(),
            'images'=> $images,
        ]);
    }

    #[Route('/private-supp-imgcarouselcollector', name: 'supp-imgcarouselcollector')]
    public function suppimgcarouselcollector(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $id = $request->get('id');
        $image = $entityManagerInterface->getRepository(CarouselCollector::class)->find($id);
        $images = $entityManagerInterface->getRepository(CarouselCollector::class)->findAll();
        $filesystem = new Filesystem();
        if (count($images) == 4) {
            $this->addFlash('notice', 'erreur : 4 image est requis au minimum');
        }else {
            $path = $this->getParameter('file_directory').'/carousel-collector/'.$image->getNomImage();
            if ($filesystem->exists($path)) {
                $filesystem->remove($path);
            }
            $entityManagerInterface->remove($image);
            $entityManagerInterface->flush();
            $this->addFlash('notice', 'image supprimé');
        }
        return $this->redirectToRoute('ajout-imgcarouselcollector');
        return $this->render('admin/addImgCarouselCollector.html.twig', [
            
        ]);
    }

    #[Route('/private-ajout-imgcarousellicence', name: 'ajout-imgcarousellicence')]
    public function imgcarousellicence(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManagerInterface): Response
    {
        $images = $entityManagerInterface->getRepository(CarouselLicence::class)->findAll();
        $image = new CarouselLicence();
        $form = $this->createForm(AjoutImageType::class,$image);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $fichier = $form->get('images')->getData();
                    if($fichier){
                        $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                        $nomFichier = $slugger->slug($nomFichier);
                        $nomFichier = $nomFichier.'-'.uniqid().'.'.$fichier->guessExtension();    
                        try{      
                            $fichier->move($this->getParameter('file_directory')."/carousel-licence", $nomFichier);
                            $image->setNomImage($nomFichier);
                            $entityManagerInterface->persist($image);
                            $entityManagerInterface->flush();  
                            $this->addFlash('notice', 'image ajouté au carousel');
                        }
                        catch(FileException $e){
                            $this->addFlash('notice', 'Erreur d\'envoi');
                        }
                    }
                 
                return $this->redirectToRoute('ajout-imgcarousellicence');
            }
        }
        return $this->render('admin/addImgCarouselLicence.html.twig', [
            'form'=> $form->createView(),
            'images'=> $images,
        ]);
    }

    #[Route('/private-supp-imgcarousellicence', name: 'supp-imgcarousellicence')]
    public function suppimgcarousellicence(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $id = $request->get('id');
        $image = $entityManagerInterface->getRepository(CarouselLicence::class)->find($id);
        $images = $entityManagerInterface->getRepository(CarouselLicence::class)->findAll();
        $filesystem = new Filesystem();
        if (count($images) == 1) {
            $this->addFlash('notice', 'erreur : 1 image est requis au minimum');
        }else {
            $path = $this->getParameter('file_directory').'/carousel-licence/'.$image->getNomImage();
            if ($filesystem->exists($path)) {
                $filesystem->remove($path);
            }
            $entityManagerInterface->remove($image);
            $entityManagerInterface->flush();
            $this->addFlash('notice', 'image supprimé');
        }
        return $this->redirectToRoute('ajout-imgcarousellicence');
        return $this->render('admin/addImgCarouselLicence.html.twig', [
            
        ]);
    }
    
}
