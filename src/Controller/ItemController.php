<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Item;
use App\Entity\User;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ItemController extends Controller
{
    /**
     * @Route("/new_item", name="new_item")
     */
    public function itemAction(Request $request)
    {

        $form = $this->createFormBuilder()
            ->add('name', TextType::class, array('label' => 'Name'))
            ->add('price', MoneyType::class, array('label' => 'Price'))
            ->add('description', TextType::class, array('label' => 'Description'))
            ->add('category', Choice::class, array('label' => 'Create Item'))
            ->add('save', SubmitType::class, array('label' => 'Create Item'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $item = new Item;
            $item->setDescription($form['description']);
            $item->setName($form['name']);
            $item->setPrice($form['price']);
            var_dump($item->getDescription());die();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            // $em->flush();
            return $this->redirectToRoute('task_success');
        }

        return $this->render('main/new_item.html.twig', array(
            'form' => $form->createView(),
        ));
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $em)
        // $em = $this->getDoctrine()->getManager();

        // $item = new Item();
        // $item->setName('Keyboard');
        // $item->setPrice(19.99);
        // $item->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        // $em->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        // $em->flush();

        // return new Response('Saved new product with id '.$product->getId());
    }
}
