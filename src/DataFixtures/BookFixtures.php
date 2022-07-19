<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Book;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $book1 = new Book;
        $book1->setTitle("L'aiguille Creuse");
        $book1->setDescription('One of the best');
        $book1->setPrice(200.52);
        $book1->setCategory($this->getReference('policier'));
        $book1->addAuthor($this->getReference('author1'));

        $manager->persist($book1);

        $book2 = new Book;
        $book2->setTitle("Le bouchon de crystal");
        $book2->setDescription('The poor boy');
        $book2->setPrice(120.52);
        $book2->setCategory($this->getReference('roman'));
        $book2->addAuthor($this->getReference('author1'));

        $manager->persist($book2);

        $book3 = new Book;
        $book3->setTitle("Gentleman cambrioleur");
        $book3->setDescription('The begining');
        $book3->setPrice(200.52);
        $book3->setCategory($this->getReference('policier'));
        $book3->addAuthor($this->getReference('author1'));

        $manager->persist($book3);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            AuthorFixtures::class
        ];
    }
}
