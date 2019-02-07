<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController
{
    /**
     * @Route("/user/add")
     */
    public function add()
    {
        return new Response('add new user method');
    }

    /**
     * @Route("/user/{id}")
     */
    public function show($id)
    {
        return new Response('user:'.$id.' name, groups it belongs to and a form to change data');
    }

    /**
     * @Route("/user/delete/{id}")
     */
    public function delete($id)
    {
        return new Response('this deletes a user with id: '.$id);
    }

    /**
     * @Route("/user/update/{id}")
     */
    public function update($id)
    {
        return new Response('this updates a user');
    }
}