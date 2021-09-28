<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Controller;

use AEcalle\Oc\Php\Project5\Repository\CommentRepository;
use AEcalle\Oc\Php\Project5\Repository\PostRepository;
use AEcalle\Oc\Php\Project5\Repository\UserRepository;
use AEcalle\Oc\Php\Project5\Service\MailerService;
use Symfony\Component\HttpFoundation\Response;

final class BlogController extends AbstractController
{
    public function home(PostRepository $postRepository): Response
    {
        $posts = $postRepository
            ->findBy([], ['updated_at' => 'DESC' ], 0, 2);

        $mailerService = new MailerService($this->request);
        $isFormHandled = $this->handleform(
            'Contact',
            null,
            [],
            [$mailerService,'sendEmail'],
            'Votre message a bien été envoyé !'
        );

        if ($isFormHandled) {
            return $this->redirect('home');
        }

        return $this->render('front/home.html.twig', ['posts' => $posts]);
    }

    public function blog(string $page, PostRepository $postRepository): Response
    {
        $page = (int) ($page);
        $index = ($page - 1) * 10;

        $posts = $postRepository
            ->findBy([], ['updated_at' => 'DESC'], $index, 10);

        $nbPosts = $postRepository->count();
        $nbPages = intdiv($nbPosts, 10) + 1;

        return $this->render('front/blog.html.twig', [
            'posts' => $posts,
            'page' => $page,
            'nbPages' => $nbPages,
        ]);
    }

    public function post(string $id, string $slug, PostRepository $postRepository, CommentRepository $commentRepository): Response
    {
        $isFormHandled = $this->handleForm(
            'Comment',
            null,
            ['createdAt' => new \DateTime(),'postId' => (int) $id,
                'published' => false,
            ],
            [$commentRepository,'add'],
            'Commentaire bien enregisté !
            Il sera publié après validation par l\'administrateur.'
        );
        if ($isFormHandled) {
            return $this->redirect('post', ['id' => $id, 'slug' => $slug]);
        }
        $post = $postRepository->find((int) $id);
        $comments = $commentRepository
            ->findBy(
                ['post_id' => (int) $id, 'published' => 1],
                ['created_at' => 'DESC'],
                0,
                50
            );
        return $this->render('front/post.html.twig', [ 'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function login(UserRepository $userRepository): Response
    {
        $isFormHandled = $this->handleform('User');

        if ($isFormHandled) {
            $isUserInDb = $this->authorization
                ->checkUserInDb(
                    $this->session->get('form')->getEntity(),
                    $userRepository,
                    $this->session
                );
            if (! $isUserInDb) {
                return $this->redirect('login');
            }
            return $this->redirect('createPost');
        }

        return $this->render('front/login.html.twig');
    }

    public function logout(): Response
    {
        $this->session->invalidate();
        return $this->redirect('login');
    }

    public function createUser(UserRepository $userRepository): Response
    {
        $isFormHandled = $this->handleform(
            'User',
            null,
            ['createdAt' => new \DateTime(), 'role' => 'unauthorised'],
            [$userRepository,'add'],
            'Inscription enregistrée !'
        );
        if ($isFormHandled) {
            return $this->redirect('createUser');
        }

        return $this->render('front/createUser.html.twig');
    }

    public function page404() : Response
    {
        return $this->render('front/404.html.twig');
    }

    public function page403() : Response
    {
        return $this->render('front/403.html.twig');
    }
}
