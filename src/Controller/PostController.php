<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Repository\CommentRepository;
use AEcalle\Oc\Php\Project5\Repository\PostRepository;
use AEcalle\Oc\Php\Project5\Service\TokenCSRFManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class PostController extends AbstractController
{
    public function createPost(PostRepository $postRepository): Response
    {
        $this->checkAuth();

        $isFormHandled = $this->handleform(
            'Post',
            null,
            [
                'createdAt' => new \DateTime(),
                'updatedAt' => new \DateTime(),
                'userId' => $this->session->get('userId'),
            ],
            [$postRepository,'add'],
            'Post ajouté !'
        );
        if ($isFormHandled) {
            return $this->redirect('createPost');
        }

        return $this->render('back/createPost.html.twig');
    }

    public function posts(PostRepository $postRepository): Response
    {
        $this->checkAuth();

        if ($this->user->getRole() !== 'admin') {
            return $this->render(
                'back/posts.html.twig',
                [
                    'posts' => $postRepository
                        ->findBy(['user_id' => $this->user->getId()], [], 0, 50),
                ]
            );
        }

        return $this->render(
            'back/posts.html.twig',
            [
                'posts' => $postRepository
                    ->findAll(),
            ]
        );
    }

    public function updatePost(string $id, PostRepository $postRepository): Response
    {
        $this->checkAuth();

        $post = $postRepository->find((int) $id);

        $isFormHandled = $this->handleform(
            'Post',
            $post,
            ['updatedAt' => new \DateTime()],
            [$postRepository, 'update'],
            'Post modifié !'
        );
        if ($isFormHandled) {
            return $this->redirect(
                'updatePost',
                [
                    'id' => $id,
                ]
            );
        }

        return $this->render(
            'back/updatePost.html.twig',
            [
                'post' => $post,
            ]
        );
    }

    public function deletePost(string $id, string $token, PostRepository $postRepository, CommentRepository $commentRepository): RedirectResponse
    {
        $this->checkAuth();

        $tokenCSRFManager = new TokenCSRFManager();
        $this->request->request->set('Post_token', $token);

        if ($tokenCSRFManager->verifToken('Post', $this->request)) {
            $comments = $commentRepository->findBy(
                ['post_id' => (int) $id],
                [],
                0,
                1000
            );
            foreach ($comments as $comment) {
                $commentRepository->delete($comment->getId());
            }
            $postRepository->delete((int) $id);
            $this->session->getFlashBag()->add('success', 'Post supprimé !');
        }

        return $this->redirect('posts');
    }
}
