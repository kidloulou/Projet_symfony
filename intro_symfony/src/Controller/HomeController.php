<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\ArticleRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'latest_articles' => $articleRepository->findBy([], ['createdAt' => 'DESC'], 3),
        ]);
    }
}
