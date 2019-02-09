<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Group;

class GroupController extends AbstractController
{
    /**
     * @Route("/group/add", name="group_add")
     */
    public function add()
    {
        return new Response('add new group method');
    }

    /**
     * Fetches a group by provided id, then renders a view
     * @Route("/group/{id}", name="group_show")
     */
    public function show($id)
    {
        $groupRep = $this->getDoctrine()->getRepository(Group::class);
        $group = $groupRep->find($id);
        
        return $this->render('group.html.twig', [
            'group' => $group
        ]);
    }

    /**
     * @Route("/group/delete/{id}", name="group_delete")
     */
    public function delete($id)
    {
        //TODO if clouse to check if there are no users
        return new Response('this deletes a group with id: '.$id);
    }

    /**
     * @Route("/group/update/{id}", name="group_update")
     */
    public function update($id)
    {
        return new Response('this updates a group (prob just a name.)');
    }
}