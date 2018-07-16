<?php

namespace App\Controllers;

use App\Entities\User;
use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicController extends AbstractController
{
    public function index()
    {
        return new Response(file_get_contents('../src/Templates/signup.html'));

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

        return new RedirectResponse('/login');
    }
}