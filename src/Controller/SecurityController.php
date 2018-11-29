<?php
/**
 * Created by PhpStorm.
 * User: andreyfilenko
 * Date: 2018-11-25
 * Time: 17:20
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        return new Response(
            $this->twig->render(
                'security/login.html.twig',
                [
                    'last_username' => $authenticationUtils->getLastUsername(),
                    'error' => $authenticationUtils->getLastAuthenticationError()
                ]
            )
        );
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function logout()
    {

    }
}