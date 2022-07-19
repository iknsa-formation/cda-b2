<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User;
        $user->setFirstname('User');
        $user->setLastname('User');
        $user->setEmail('user@book.com');
        $user->addRole('ROLE_USER');
        $user->setBirthday(new \DateTime('16-03-1986'));

        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                'user'
            )
        );
        $manager->persist($user);

        $admin = new User;
        $admin->setFirstname('Admin');
        $admin->setLastname('Admin');
        $admin->setEmail('admin@book.com');
        $admin->addRole('ROLE_ADMIN');
        $admin->setBirthday(new \DateTime('25-08-1986'));
        
        $admin->setPassword(
            $this->hasher->hashPassword(
                $admin,
                'admin'
            )
        );
        $manager->persist($admin);

        $manager->flush();
    }
}
