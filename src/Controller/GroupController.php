<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\GroupType;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Group;
use App\Entity\User;

class GroupController extends AbstractController
{
    /**
     * Creates a form for a new user
     * If (form == (submited && valid)) saves entity (with relationship) to DB
     * @Route("/group/add", name="group_add")
     */
    public function add(Request $request)
    {
        $group = new Group();
        
        $form = $this->createForm(GroupType::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $group = $form->getData();
            
            $userArray = $group->getUsers();
            $userRep = $this->getDoctrine()->getRepository(User::class);

            foreach ($userArray as $user) 
            {
                $realUser = $userRep->find($user->getId());

                $realUser->addGroup($group);

                $entityManager->persist($realUser);
            }
            $entityManager->persist($group);            
            $entityManager->flush();

            $this->addFlash(
                'notice',
                "Group: ".$group->getName()." created successfully"
            );

            return $this->redirectToRoute('index');
        }

        return $this->render('new_group.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Renders a view and provides group object
     * @Route("/group/{id}", name="group_show")
     */
    public function show($id)
    {
        return $this->render('group.html.twig', [
            'group' => $this->findGroupById($id)
        ]);
    }

    /**
     * Deletes a group by id
     * @Route("/group/delete/{id}", name="group_delete")
     */
    public function delete($id)
    {
        $group = $this->findGroupById($id);

        if (!$group->getUsers()->first())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($group);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                "Group: ".$group->getName()." deleted successfully"
            );
        }
        else
        {
            $this->addFlash(
                'notice',
                'In order to delete group it has to be empty!'
            );
        }

        return $this->redirectToRoute('index');
    }

    /**
     * Removes a user form a group
     * @Route("/group/{groupId}/removeuser/{userId}", name="group_remove_user")
     */
    public function removeUser($groupId, $userId)
    {
        $group = $this->findGroupById($groupId);
        $user = $this->findUserById($userId);

        $group->removeUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($group);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Removed user: '.$user->getName().' from group: '.$group->getName().' successfuly!'
        );

        return $this->redirectToRoute('group_update', [
            'id' => $group->getId()
        ]);
    }

    /**
     * Updated group instnce
     * @Route("/group/update/{id}", name="group_update")
     */
    public function update($id, Request $request)
    {
        $group = $this->findGroupById($id);

        $form = $this->createForm(GroupType::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $group = $form->getData();
            $entityManager->persist($group);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Group: '.$group->getName().' updated successfully!'
            );

            return $this->redirectToRoute('index');
        }

        return $this->render('new_group.html.twig',[
            'form' => $form->createView(),
            'group' => $group
        ]);
    }

    /**
     * Fetches a group by id
     */
    private function findGroupById($id)
    {
        return $this->getDoctrine()->getRepository(Group::class)->find($id);
    }

    /**
     * Fetches a user by id
     */
    private function findUserById($id)
    {
        return $this->getDoctrine()->getRepository(User::class)->find($id);
    }
}