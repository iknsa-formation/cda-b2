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

        $user2 = new User;
        $user2->setFirstname('User2');
        $user2->setLastname('User2');
        $user2->setEmail('user2@book.com');
        $user2->addRole('ROLE_USER');
        $user2->setBirthday(new \DateTime('16-03-1986'));
        $user2->setIsDeleted(true);
        $user2->setIsActive(true);

        $user2->setPassword(
            $this->hasher->hashPassword(
                $user2,
                'user2'
            )
        );
        $manager->persist($user2);

        $user3 = new User;
        $user3->setFirstname('User3');
        $user3->setLastname('User3');
        $user3->setEmail('user3@book.com');
        $user3->addRole('ROLE_USER');
        $user3->setBirthday(new \DateTime('16-03-1986'));
        $user3->setIsDeleted(true);
        $user3->setIsActive(false);

        $user3->setPassword(
            $this->hasher->hashPassword(
                $user3,
                'user3'
            )
        );
        $manager->persist($user3);

        $user4 = new User;
        $user4->setFirstname('User4');
        $user4->setLastname('User4');
        $user4->setEmail('user4@book.com');
        $user4->addRole('ROLE_USER');
        $user4->setBirthday(new \DateTime('16-03-1986'));
        $user4->setIsDeleted(true);
        $user4->setIsActive(false);

        $user4->setPassword(
            $this->hasher->hashPassword(
                $user4,
                'user4'
            )
        );
        $manager->persist($user4);

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
