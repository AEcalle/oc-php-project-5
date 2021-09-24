<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class CommentController extends AbstractController
{
    public function comments(): Response
    {
        $this->checkAuth();

        $comments = $this->commentRepository->findAll();

        return $this->render(
            'back/comments.html.twig',
            [
                'comments' => $comments,
            ]
        );
    }

    public function publishComment(int $id, bool $publish): RedirectResponse
    {
        $this->checkAuth();

        $comment = $this->commentRepository->find($id);
        $comment->setPublished($publish);
        $this->commentRepository->update($comment);

        $this->session->getFlashBag()
            ->add('success', 'Commentaire mis à jour !');
        return $this->redirect('comments');
    }
}
