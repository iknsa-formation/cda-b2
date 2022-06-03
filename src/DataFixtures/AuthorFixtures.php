<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    const DATA = [

        // Author 1
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'gender' => "M",
        ],

        // Author 2
        [
            'firstname' => "Jane",
            'lastname' => "DOE",
            'gender' => "F",
        ],

        // Author 3
        [
            'firstname' => "Bob",
            'lastname' => "DOE",
            'gender' => "N",
        ],

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $item)
        {
            $author = new Author;

            $author->setFirstname($item['firstname']);
            $author->setLastname($item['lastname']);
            $author->setGender($item['gender']);
            
            $manager->persist($author);
        }

        $manager->flush();
    }
}
