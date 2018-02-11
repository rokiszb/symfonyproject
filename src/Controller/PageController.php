<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PageController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $number = mt_rand(0, 100);

        return $this->render('main/index.html.twig', array(
            'number' => $number,
        ));
    }

    /**
     * @Route("/register")
     */
    public function registerAction()
    {

        return $this->render('security/register.html.twig', array(
            'number' => '2',
        ));
    }
}