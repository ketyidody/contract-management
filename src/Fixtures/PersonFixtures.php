<?php

namespace App\Fixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonFixtures extends Fixture
{
    protected $randomNames = [
        'Cierra Vega',
        'Alden Cantrell',
        'Kierra Gentry',
        'Pierre Cox',
        'Thomas Crane',
        'Miranda Shaffer',
        'Bradyn Kramer',
        'Alvaro Mcgee',
        'Bria Koch',
        'Dominique Jacobs',
        'Edward Todd',
        'Clay Nixon',
        'Arianna Yates',
        'Damien Sparks',
        'Carmen Woodard',
        'Samir Fitzpatrick',
        'Kingston Richards',
        'Johnathan Larson',
        'Jaslene Vincent',
        'Finnegan Bates',
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->randomNames as $key => $name) {
            $firstName = explode(' ', $name)[0];
            $lastName = explode(' ', $name)[1];
            $person = new Person();
            $person
                ->setFirstName($firstName)
                ->setLastName($lastName)
                ->setPersonalId($lastName . $key)
            ;
            if ($key < 2) {
                $person->setPType(Person::TYPES['Agent']);
            } else {
                $person->setPType(Person::TYPES['Contractor']);
            }

            $this->setReference('person' . $key, $person);

            $manager->persist($person);
        }

        $manager->flush();
    }
}