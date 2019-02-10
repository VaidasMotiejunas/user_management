<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Entity\Group;

class UserController extends AbstractController
{
    /**
     * Creates a form for a new user
     * If (form == (submited && valid)) saves entity (with relationship) to DB
     * @Route("/user/add", name="user_add")
     */
    public function add(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            
            $user = $form->getData();
            
            $groupArray = $user->getGroups();
            $groupRep = $this->getDoctrine()->getRepository(Group::class);

            foreach ($groupArray as $group) 
            {
                $realGroup = $groupRep->find($group->getId());

                $realGroup->addUser($user);

                $entityManager->persist($realGroup);
            }
            $entityManager->persist($user);            
            $entityManager->flush();

            $this->addFlash(
                'notice',
                "User: ".$user->getName()." added successfully"
            );

            return $this->redirectToRoute('index');
        }

        return $this->render('new_user.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Renders a view and provides user object
     * @Route("/user/{id}", name="user_show")
     */
    public function show($id)
    {
        return $this->render('user.html.twig', [
            'user' => $this->findUserById($id)
        ]);
    }

    /**
     * Deletes a user by id
     * @Route("/user/delete/{id}", name="user_delete")
     */
    public function delete($id)
    {
        $user = $this->findUserById($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            "User: ".$user->getName()." deleted successfully"
        );

        return $this->redirectToRoute('index');
    }

    /**
     * Updates user instance
     * @Route("/user/update/{id}", name="user_update")
     */
    public function update($id, Request $request)
    {
        $user = $this->findUserById($id);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $form->getData();

            $groupRep = $this->getDoctrine()->getRepository(Group::class);
            $groupArray = $user->getGroups();

            foreach ($groupArray as $group) 
            {
                $realGroup = $groupRep->find($group->getId());
                $realGroup->addUser($user);
                $entityManager->persist($realGroup);

            }
            $entityManager->persist($user);            
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'User: '.$user->getName().' updated successfully'
            );

            return $this->redirectToRoute('index');
        }

        return $this->render('new_user.html.twig',[
            'form' => $form->createView(),
        ]);

    }

    /**
     * Fetches a user by id
     */
    private function findUserById($id)
    {
        return $this->getDoctrine()->getRepository(User::class)->find($id);
    }
}