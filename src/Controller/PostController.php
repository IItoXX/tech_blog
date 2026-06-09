<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController {
    #[Route('/post/{id}', name: 'app_post_show')]
    public function show(Post $article, Request $request, EntityManagerInterface $entityManager): Response {
        $commentaire = new Comment();
        $formulaire = $this->createForm(CommentType::class, $commentaire);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $commentaire->setPost($article);
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_post_show', ['id' => $article->getId()]);
        }
        return $this->render('post/show.html.twig', ['article' => $article, 'formulaire' => $formulaire]);
    }
}