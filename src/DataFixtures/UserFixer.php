<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixer extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();

        // $manager->persist($product);
        $user = new User();
        $user->setUsername('user');
        $user->setEmail('info@user.com');
        $user->setName('Admin');
        $user->setPassword(
            $this->encoder->encodePassword($user,'password')
        );

        $manager->persist($user);
        $manager->flush();
    }
}
