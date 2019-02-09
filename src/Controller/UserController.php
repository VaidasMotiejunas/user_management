<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/user/add", name="user_add")
     */
    public function add()
    {
        return new Response('add new user method');
    }

    /**
     * Fetches a user by provided id, then renders a view
     * @Route("/user/{id}", name="user_show")
     */
    public function show($id)
    {
        $userRep = $this->getDoctrine()->getRepository(User::class);
        $user = $userRep->find($id);
        
        return $this->render('user.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete")
     */
    public function delete($id)
    {
        return new Response('this deletes a user with id: '.$id);
    }

    /**
     * @Route("/user/update/{id}", name="user_update")
     */
    public function update($id)
    {
        return new Response('this updates a user');
    }
}