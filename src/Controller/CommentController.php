<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class CommentController extends AbstractController
{
    public function comments(CommentRepository $commentRepository): Response
    {
        $this->checkAuth('admin');

        $comments = $commentRepository->findAll();

        return $this->render(
            'back/comments.html.twig',
            [
                'comments' => $comments,
            ]
        );
    }

    public function publishComment(string $id, string $publish, CommentRepository $commentRepository): RedirectResponse
    {
        $this->checkAuth('admin');

        $comment = $commentRepository->find((int) $id);
        $comment->setPublished((bool) $publish);
        $commentRepository->update($comment);

        $this->session->getFlashBag()
            ->add('success', 'Commentaire mis à jour !');
        return $this->redirect('comments');
    }
}
