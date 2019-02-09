<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController
{
    /**
     * @Route("/user/add", name="user_add")
     */
    public function add()
    {
        return new Response('add new user method');
    }

    /**
     * @Route("/user/{id}", name="user_show")
     */
    public function show($id)
    {
        return new Response('user:'.$id.' name, groups it belongs to and a form to change data');
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