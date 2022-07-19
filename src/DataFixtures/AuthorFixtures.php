<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AuthorFixtures extends Fixture implements DependentFixtureInterface
{
    const DATA = [

        // Author 1
        [
            'firstname' => "Maurice",
            'lastname' => "Leblanc",
            'gender' => "M",
            'reference' => 'author1'
        ],

        // Author 2
        [
            'firstname' => "Jane",
            'lastname' => "DOE",
            'gender' => "F",
            'reference' => 'author2'
        ],

        // Author 3
        [
            'firstname' => "Bob",
            'lastname' => "DOE",
            'gender' => "N",
            'reference' => 'author3'
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $item)
        {
            $author = $item['reference'];

            $$author = new Author;

            $$author->setFirstname($item['firstname']);
            $$author->setLastname($item['lastname']);
            $$author->setGender($item['gender']);
            
            $manager->persist($$author);
            $manager->flush();

            $this->addReference($author, $$author);
        }
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}




/**
 * @todo Des fixtures pour créer 2 utilisateurs
 *         1. role user (first name => User, last name => User, email => user@book.com, password => user)
 *         2. role admin (first name => Admin, last name => Admin, email => admin@book.com, password => admin)
 * 
 * @todo Des fixtures pour créer des Books
 * 1. Book 1 (title => Book 1, author => Author 1, category => Category 1)
 * 2. Book 2 (title => Book 2, author => Author 2, category => Category 2)
 * 3. Book 3 (title => Book 3, author => Author 3, category => Category 2)
 * 4. Book 4 (title => Book 4, author => Author 1, category => Category 1)
 */
