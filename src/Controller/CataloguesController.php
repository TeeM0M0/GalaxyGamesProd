<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CataloguesController extends AbstractController
{
    #[Route('/catalogueNintendo', name: 'catalogueNintendo')]
    public function catalogueNintendo(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/catalogueNintendo.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/catalogueNintendob', name: 'catalogueNintendob')]
    public function catalogueNintendob(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/catalogueNintendob.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/catalogueNintendon', name: 'catalogueNintendon')]
    public function catalogue(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/catalogueNintendon.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/catalogueNintendop', name: 'catalogueNintendop')]
    public function catalogueNintendop(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/catalogueNintendop.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/catalogueNintendoSwitch', name: 'catalogueNintendoSwitch')]
    public function catalogueNintendoSwitch(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/catalogueNintendoSwitch.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/cataloguePC', name: 'cataloguePC')]
    public function cataloguePC(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/cataloguePC.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/cataloguePCb', name: 'cataloguePCb')]
    public function cataloguePCb(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/cataloguePCb.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/cataloguePCn', name: 'cataloguePCn')]
    public function cataloguePCn(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/cataloguePCn.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/cataloguePCp', name: 'cataloguePCp')]
    public function cataloguePCp(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/cataloguePCp.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/cataloguePlay', name: 'cataloguePlay')]
    public function cataloguePlay(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/cataloguePlay.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/cataloguePlay4', name: 'cataloguePlay4')]
    public function cataloguePlay4(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/cataloguePlay4.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/cataloguePlay5', name: 'cataloguePlay5')]
    public function cataloguePlay5(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/cataloguePlay5.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/cataloguePlayb', name: 'cataloguePlayb')]
    public function cataloguePlayb(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/cataloguePlayb.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/cataloguePlayn', name: 'cataloguePlayn')]
    public function cataloguePlayn(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/cataloguePlayn.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/cataloguePlayp', name: 'cataloguePlayp')]
    public function cataloguePlayp(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/cataloguePlayp.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/catalogueXbox', name: 'catalogueXbox')]
    public function catalogueXbox(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/catalogueXbox.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/catalogueXboxn', name: 'catalogueXboxn')]
    public function catalogueXboxn(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/catalogueXboxn.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/catalogueXboxOne', name: 'catalogueXboxOne')]
    public function catalogueXboxOne(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/catalogueXboxOne.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/catalogueXboxp', name: 'catalogueXboxp')]
    public function catalogueXboxp(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/catalogueXboxp.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/catalogueXboxXS', name: 'catalogueXboxXS')]
    public function catalogueXboxXS(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/catalogueXboxXS.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }

    #[Route('/catalogueXboxb', name: 'catalogueXboxb')]
    public function catalogueXboxb(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $articles = $entityManagerInterface->getRepository(Articles::class)->findAll();
        $date = new \Datetime();
        return $this->render('catalogues/catalogueXboxb.html.twig', [
            'articles'=>$articles,
            'date'=>$date,
        ]);
    }
}
