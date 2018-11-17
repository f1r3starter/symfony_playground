<?php
/**
 * Created by PhpStorm.
 * User: andreyfilenko
 * Date: 2018-11-06
 * Time: 22:00
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class BlogController
 * @package App\Controller
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    private $twig;
    private $session;
    private $router;

    public function __construct(\Twig_Environment $twig,
                                SessionInterface $session,
                                RouterInterface $router)
    {
        $this->twig = $twig;
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * @Route("/", name="blog_index")
     */
    public function index()
    {
        $response = $this->twig->render('blog/index.html.twig', [
            'posts' => $this->session->get('posts')
        ]);

        return new Response($response);
    }

    /**
     * @Route("/add", name="blog_add")
     */
    public function add()
    {
        $posts = $this->session->get('posts');
        $posts[uniqid()] = [
            'title' => 'Random ' . rand(1,500),
            'text' => 'Text ' . rand(1,100),
            'date' => new \DateTime()
        ];
        $this->session->set('posts', $posts);

        return new RedirectResponse($this->router->generate('blog_index'));
    }

    /**
     * @Route("/show{id}", name="blog_show")
     */
    public function show($id)
    {
        $posts = $this->session->get('posts');

        if (!$posts || !isset($posts[$id])) {
            throw new NotFoundHttpException('Post not found');
        }

        $response = $this->twig->render('blog/post.html.twig', [
            'id' => $id,
            'post' => $posts[$id]
        ]);

        return new Response($response);
    }
}