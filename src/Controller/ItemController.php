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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use DateTime;

class ItemController extends Controller
{
    /**
     * @Route("/new_item", name="new_item")
     */
    public function itemAction(Request $request)
    {

        $item = new Item;
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, array('label' => 'Item name'))
            ->add('price', MoneyType::class, array('label' => 'Price'))
            ->add('description', TextareaType::class, array('label' => 'Description'))
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getTitle();
                }
            ))
            ->add('save', SubmitType::class, array('label' => 'Create Item'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form = $form->getData();
            $item->setDescription($form['description']);
            $item->setName($form['name']);
            $item->setPrice($form['price']);
            $item->setCategory($form['category']);
            $user = $this->getUser();
            $item->setUser($user);
            $item->setCreatedAt(new DateTime);

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
            $this->addFlash(
                'notice',
                'Your item was added!'
            );
            return $this->redirectToRoute('index');
        }

        return $this->render('main/new_item.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
