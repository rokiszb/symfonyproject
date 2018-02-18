<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use DateTime;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // User seed
        $user = new User();
        $user->setUsername('basic_user');
        $user->setEmail('basic@user.lt');

        $password = $this->encoder->encodePassword($user, 'secret');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();

        // Categories seed
        $categories = ['Electronics', 'Furniture', 'Cars', 'Other'];

        foreach ($categories as $key => $categoryTitle) {
            $category = new Category();
            $category->setTitle($categoryTitle);
            $manager->persist($category);
        }

        // Items seed
        for ($i = 1; $i < 15; $i++) {
            $item = new Item();
            $item->setName('item '.$i);
            $item->setUser($user);
            $item->setDescription('Item description');
            $item->setCategoryId($category);
            $item->setPrice(mt_rand(10, 100));
            $dateTimeNow = new DateTime('now');
            $item->setCreatedAt($dateTimeNow);
            $manager->persist($item);
        }

    $manager->flush();
    }
}