<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Entity\Item;

class PageController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository(Item::class);
        $items = $repository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('main/homepage.html.twig', array(
            'items' => $items,
        ));
    }
    /**
     * @Route("/profile", name="profile")
     */
    public function profileAction()
    {
        $user = $this->getUser();
        $items = $user->getItems();

        return $this->render('main/homepage.html.twig', array(
            'items' => $items,
        ));
    }
}