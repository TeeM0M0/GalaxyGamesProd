<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Form\AjoutFichierType;
use App\Form\AjoutArticleType;
use App\Form\ModifArticleType;
use App\Entity\Fichier;
use App\Entity\Articles;
use App\Entity\ImageArticle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

class ArticleController extends AbstractController
{
    #[Route('/article{id}', name: 'article')]
    public function article(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $id = $request->get('id');
        $article = $entityManagerInterface->getRepository(Articles::class)->find($id);
        return $this->render('article/article.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/private-supp-article', name: 'supp-article')]
    public function supparticle(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $id = $request->get('id');
        $article = $entityManagerInterface->getRepository(Articles::class)->find($id);
        $images=$article->getImageArticles();
        $filesystem = new Filesystem();
        foreach ($images as $image) {
            $path = $this->getParameter('file_directory').'/articles/'.$image->getNom();
            if ($filesystem->exists($path)) {
                $filesystem->remove($path);
            }
        }
        // Supprimer l'article
        $entityManagerInterface->remove($article);
        $entityManagerInterface->flush();
        $this->addFlash('notice', 'article supprimé');
        return $this->redirectToRoute('listeArticles');
        return $this->render('article/index.html.twig', [
            
        ]);
    }

    #[Route('/private-ajout-article', name: 'ajout-article')]
    public function addarticle(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManagerInterface): Response
    {
        $article = new Articles();
        $article->setQteVendu(0);
        $form = $this->createForm(AjoutArticleType::class,$article);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $fichiers = $form->get('images')->getData();
                foreach($fichiers as $fichier){
                    if($fichier){
                        $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                        $nomFichier = $slugger->slug($nomFichier);
                        $nomFichier = $nomFichier.'-'.uniqid().'.'.$fichier->guessExtension();    
                        try{      
                            $fichier->move($this->getParameter('file_directory')."/articles", $nomFichier);
                            $image = new ImageArticle();
                            $image->setNom($nomFichier);
                            $image->setArticle($article);
                            $entityManagerInterface->persist($image);
                            $entityManagerInterface->flush();
                            $entityManagerInterface->persist($article);
                            $entityManagerInterface->flush();   
                            $this->addFlash('notice', 'article créé');
                        }
                        catch(FileException $e){
                            $this->addFlash('notice', 'Erreur d\'envoi');
                        }
                    }
                }     
                return $this->redirectToRoute('ajout-article');
            }
        }
        return $this->render('article/ajout-article.html.twig', [
            'form'=> $form->createView(),
        ]);
    }

    #[Route('/private-liste-articles', name: 'listeArticles')]
    public function listeArticles(EntityManagerInterface $entityManagerInterface): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        return $this->render('article/liste-article.html.twig', [
           'articles'=>$articles
        ]);
    }

    #[Route('/private-modif-article/{id}', name: 'modifarticle')]
    public function modifarticle(Request $request, EntityManagerInterface $entityManagerInterface, SluggerInterface $slugger): Response
    {
        $id = $request->get('id');
        $article = $entityManagerInterface->getRepository(Articles::class)->find($id);
        $images = $article->getImageArticles();
        $form = $this->createForm(ModifArticleType::class,$article);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManagerInterface->persist($article);
                $entityManagerInterface->flush();
                $fichiers = $form->get('images')->getData();
                foreach($fichiers as $fichier){
                    if($fichier){
                        $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                        $nomFichier = $slugger->slug($nomFichier);
                        $nomFichier = $nomFichier.'-'.uniqid().'.'.$fichier->guessExtension();    
                        try{      
                            $fichier->move($this->getParameter('file_directory')."/articles", $nomFichier);
                            $image = new ImageArticle();
                            $image->setNom($nomFichier);
                            $image->setArticle($article);
                            $entityManagerInterface->persist($image);
                            $entityManagerInterface->flush();
                            $entityManagerInterface->persist($article);
                            $entityManagerInterface->flush();   
                            $this->addFlash('notice', 'article modifié');
                        }
                        catch(FileException $e){
                            $this->addFlash('notice', 'Erreur d\'envoi');
                        }
                    }
                }     
                return $this->redirectToRoute('listeArticles');
            }
        }
        return $this->render('article/modif-article.html.twig', [
            'form' => $form->createView(),
            'images'=>$images,

        ]);
    }

    #[Route('/private-supp-imgarticle', name: 'supp-imgarticle')]
    public function suppimgarticle(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $id = $request->get('id');
        $image = $entityManagerInterface->getRepository(ImageArticle::class)->find($id);
        $article = $image->getArticle();
        $images = $article->getImageArticles();
        $filesystem = new Filesystem();
        if (count($images) == 1) {
            $this->addFlash('notice', 'erreur : 1 image est requis au minimum');
        }else {
            $path = $this->getParameter('file_directory').'/articles/'.$image->getNom();
            if ($filesystem->exists($path)) {
                $filesystem->remove($path);
            }
            $entityManagerInterface->remove($image);
            $entityManagerInterface->flush();
            $this->addFlash('notice', 'image supprimé');
        }
        return $this->redirectToRoute('modifarticle', ['id' => $article->getId()]);
        return $this->render('article/index.html.twig', [
            
        ]);
    }
}
