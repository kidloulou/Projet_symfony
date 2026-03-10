<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/article')]
final class ArticleController extends AbstractController
{
    #[Route(name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_PROF')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $article->setCreatedAt(new \DateTimeImmutable());
        $article->setAuthor($this->getUser());

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    #[IsGranted('ROLE_PROF')]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($article->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Vous ne pouvez supprimer que vos propres articles.');
        }

        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->getPayload()->get('_token'))) {
            $title = $article->getTitle();
            $entityManager->remove($article);
            $entityManager->flush();
            
            $this->addFlash('success', 'L\'article "' . $title . '" a été supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Token CSRF invalide. Impossible de supprimer l\'article.');
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET', 'POST'])]
    public function show(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new \App\Entity\Comment();
        $form = $this->createForm(\App\Form\CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->denyAccessUnlessGranted('ROLE_USER');
            
            $comment->setAuthor($this->getUser());
            $comment->setArticle($article);
            $comment->setCreatedAt(new \DateTimeImmutable());
            
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire ajouté avec succès !');

            return $this->redirectToRoute('app_article_show', ['id' => $article->getId()]);
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comment_form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_PROF')]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($article->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Vous ne pouvez modifier que vos propres articles.');
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
}
