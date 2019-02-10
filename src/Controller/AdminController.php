<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function index() 
    {
        $userRep = $this->getDoctrine()->getRepository(User::class);
        $groupRep = $this->getDoctrine()->getRepository(Group::class);

        $users = $userRep->findAll();
        $groups = $groupRep->findAll();

        return $this->render('index.html.twig', [
            'users' => $users,
            'groups' => $groups
        ]);
    }
}