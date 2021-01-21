<?php

namespace App\Fixtures;

use App\Entity\RentalObject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RentalObjectFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 3; $i++) {
            $rentalObject = new RentalObject();
            $rentalObject
                ->setName('Object No ' . $i)
                ->setAddress('Address ' . $i)
                ->setCity('City ' . $i)
                ->setCountry('Country ' . $i)
                ->setDescription('Fixture rental object no ' . $i)
                ->setNumberOfRooms($i)
            ;
            $this->setReference('rental_object' . $i, $rentalObject);
            $manager->persist($rentalObject);
        }

        $manager->flush();
    }
}