<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Repositories\UserRepository;
use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class PublicController extends AbstractController
{
    public function index()
    {
        return new Response(file_get_contents('../src/View/Templates/index.html'));

    }

    public function signup(EntityManager $entityManager, Request $request): Response
    {
        $email = $request->get('email');
        $password = $request->get('password');

        if(empty($email) || empty($password))
        {
            throw new Exception("Can't create a user with an empty email or password");
        }

        $user = new User($email, $password);

        $entityManager->persist($user);
        $entityManager->flush();

        return new RedirectResponse('/');
    }

    public function login(Request $request, UserRepository $userRepository, Session $session): Response
    {
        $email = $request->get('email');
        $password = $request->get('password');

        if(empty($email) || empty($password))
        {
            throw new Exception("Email and password are required for login");
        }

        /** @var User $user */
        $user = $userRepository->findOneBy(['email' => $email]);

        if(!password_verify($password, $user->getPassword()))
        {
            return new Response("Login failed! Incorrect password!");
        }

        $session->set('user', $user);

        return new RedirectResponse('/profile');
    }
}