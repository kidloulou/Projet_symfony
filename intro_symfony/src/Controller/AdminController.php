<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(\App\Repository\UserRepository $userRepository, \App\Repository\ArticleRepository $articleRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users_count' => $userRepository->count([]),
            'articles_count' => $articleRepository->count([]),
            'recent_users' => $userRepository->findBy([], ['id' => 'DESC'], 5),
        ]);
    }
}
