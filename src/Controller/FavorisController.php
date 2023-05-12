<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Articles;

class FavorisController extends AbstractController
{
    #[Route('/private-liste-favoris', name: 'listfav')]
    public function listfav(): Response
    {
        return $this->render('favoris/index.html.twig', [
            
        ]);
    }

    #[Route('/private-favoris', name: 'favoris')]
    public function favoris(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id = $request->get('id');
        $article = $entityManagerInterface->getRepository(Articles::class)->find($id);
        $action = $request->get('action');
        $page = $request->get('page');
        if($action == 'ajouter'){
            $this->getUser()->addFavori($article);
        }
        if ($action == 'supprimer') {
            $this->getUser()->removeFavori($article);
        }
        $entityManagerInterface->persist($this->getUser());
        $entityManagerInterface->flush();
        return $this->redirectToRoute($page, ['id' => $id]);
        return $this->render('favoris/index.html.twig', [
        ]);
    }
}
