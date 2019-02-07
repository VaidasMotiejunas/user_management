<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GroupController
{
    /**
     * @Route("/group/add")
     */
    public function add()
    {
        return new Response('add new group method');
    }

    /**
     * @Route("/group/{id}")
     */
    public function show($id)
    {
        return new Response('group:'.$id.' shows all users in a particular group');
    }

    /**
     * @Route("/group/delete/{id}")
     */
    public function delete($id)
    {
        //TODO if clouse to check if there are no users
        return new Response('this deletes a group with id: '.$id);
    }

    /**
     * @Route("/group/update/{id}")
     */
    public function update($id)
    {
        return new Response('this updates a group (prob just a name.)');
    }
}