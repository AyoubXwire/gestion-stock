<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for ($i=1; $i <= 6; $i++)
        {
            $category = new Category();
            $category
                ->setName($faker->word)
                ->setImage($faker->imageUrl())
            ;

            $manager->persist($category);

            for ($j=1; $j <= mt_rand(4, 9); $j++)
            {
                $product = new Product();
                $product
                    ->setName($faker->word)
                    ->setDescription($faker->sentence())
                    ->setImage($faker->imageUrl())
                    ->setCategory($category)
                ;

                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
