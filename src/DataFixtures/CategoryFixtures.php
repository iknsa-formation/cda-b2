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
        ],

        // Category 2
        [
            'name' => "Policier",
            'description' => "Lorem ipsum, dolor sit amet...",
            'color' => "#0099FF",
            'illustration' => null,
        ],

        // Category 3
        [
            'name' => "Nouvelle",
            'description' => null,
            'color' => "#CC00DD",
            'illustration' => null,
        ],

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $item)
        {
            $category = new Category;

            $category->setName( $item['name'] );
            $category->setDescription( $item['description'] );
            $category->setColor( $item['color'] );
            $category->setIllustration( $item['illustration'] );

            $manager->persist($category);
        }

        $manager->flush();
    }
}
