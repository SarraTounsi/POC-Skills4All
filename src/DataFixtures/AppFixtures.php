<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Car;
use App\Entity\Category;
use Faker\Factory;
use Faker\Provider\Fakecar;
use Doctrine\Common\Collections\ArrayCollection;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setName($faker->word);

            $manager->persist($category);

            for ($j = 0; $j < 10; $j++) {
                $car = new Car();
                $car->setName($faker->word);
                $car->setNbSeats($faker->numberBetween(2, 8));
                $car->setNbDoors($faker->numberBetween(2, 5));
                $car->setCost($faker->randomFloat(2, 5000, 50000));
                $car->setCategory($category);

                $manager->persist($car);
            }
        }

        $manager->flush();
    }
}