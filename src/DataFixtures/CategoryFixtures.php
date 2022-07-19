<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const DATA = [

        // Cateogry 1
        [
            'name' => "Roman",
            'description' => null,
            'color' => "#FF9900",
            'illustration' => null,
            'reference' => 'roman'
        ],

        // Category 2
        [
            'name' => "Policier",
            'description' => "Lorem ipsum, dolor sit amet...",
            'color' => "#0099FF",
            'illustration' => null,
            'reference' => 'policier'
        ],

        // Category 3
        [
            'name' => "Nouvelle",
            'description' => null,
            'color' => "#CC00DD",
            'illustration' => null,
            'reference' => 'nouvelle'
        ],

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $item)
        {
            $ref = $item['reference'];

            $$ref = new Category;

            $$ref->setName( $item['name'] );
            $$ref->setDescription( $item['description'] );
            $$ref->setColor( $item['color'] );
            $$ref->setIllustration( $item['illustration'] );

            $manager->persist($$ref);
            
            $manager->flush();

            $this->addReference($item['reference'], $$ref);
        }
    }
}
