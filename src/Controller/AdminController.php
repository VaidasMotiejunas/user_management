<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Group;
use App\Entity\User;

/**
 * Main page controller 
 */
class AdminController extends AbstractController
{
    /**
     * Fetches user and group collections and renders index page
     * @Route("/", name="index")
     */
    public function index(Request $request) 
    {
        $userRep = $this->getDoctrine()->getRepository(User::class);
        $groupRep = $this->getDoctrine()->getRepository(Group::class);

        $users = $userRep->findAll();
        $groups = $groupRep->findAll();

        $user = new User();

        $userForm = $this->createForm(UserType::class, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            // TODO Kaip issaugoti user relationshipa i duombaze?   
            // $userData = $userForm->getData();
            // $user->addGroup($userData->getGroups());
            // $groups = $groupRep->findBy([
            //     'id'
            // ]);
            // $user->setName($userData->getName());
            // $entityManager->persist($user);
            // $entityManager->flush();
        }

        return $this->render('index.html.twig', [
            'users' => $users,
            'groups' => $groups,
            'userForm' => $userForm->createView()
        ]);
    }
}