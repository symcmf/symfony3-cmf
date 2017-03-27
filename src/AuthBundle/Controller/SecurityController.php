<?php

namespace AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render(
            'auth/login.html.twig',
            [
                'last_username' => $helper->getLastUsername(),
                'error'         => $helper->getLastAuthenticationError(),
            ]
        );
    }

    /**
     * @param $token
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function confirmationAction($token)
    {
        if ($user = $this->get('auth.service.confirmation')->activateUser($token)) {
            $this->get('app.service.user')->setAuth($user);
        }

        return $this->redirect('/');
    }
}
