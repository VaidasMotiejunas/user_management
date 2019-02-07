<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index() 
    {
        // return new Response('The index page');

        // hardcoded users and groups for demo
        $groups = [
            'taxi',
            'bus',
        ];
        $users = [
            'Mantis',
            'Bandis',
            'Kandis'
        ];
        return $this->render('index.html.twig', [
            'users' => $users,
            'groups' => $groups
        ]);
    }

}