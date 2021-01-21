<?php

namespace App\Fixtures;

use App\Entity\Contract;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ContractFixtures extends Fixture implements DependentFixtureInterface
{
    protected $dates = [
        '2020-10-5' => '2020-10-16',
        '2020-10-20' => '2020-10-29',
        '2020-12-02' => '2020-12-14',
        '2021-01-10' => '2021-01-29',
        '2021-02-10' => '2021-02-13',
        '2021-02-14' => '2021-02-24',
        '2021-03-01' => '2021-03-05',
        '2021-03-06' => '2021-03-14',
        '2021-05-01' => '2021-05-15',
    ];

    public function getDependencies()
    {
        return [
            PersonFixtures::class,
            RentalObjectFixtures::class,
        ];
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->dates as $from => $to) {
            $rent = round((strtotime($to) - strtotime($from)) / (60 * 60 * 24)) * 50;
            $agent = $this->getReference('person' . rand(0, 1));
            $residents = [];
            for ($i = 0; $i < rand(1, 3); $i++) {
                $id = $this->getNonRepeatRandomNumber(2, 19, $residents);
                $residents[] = $this->getReference('person' . $id);
            }
            $contract = new Contract();
            $contract
                ->setStartDate(new \DateTime($from))
                ->setEndDate(new \DateTime($to))
                ->setRent($rent)
                ->setNoticePeriod(rand(1, 5))
                ->addContractParty($agent)
                ->setRentalObject($this->getReference('rental_object' . rand(0, 2)))
            ;

            $firstResident = true;
            foreach ($residents as $resident) {
                // set the first resident as contrac party
                if ($firstResident) {
                    $contract->addContractParty($resident);
                }
                $firstResident = false;

                $contract->addResident($resident);
            }

            $manager->persist($contract);
        }

        $manager->flush();
    }

    protected function getNonRepeatRandomNumber($min, $max, $residents)
    {
        $id = rand($min, $max);
        if (array_key_exists($id, $residents)) {
            return $this->getNonRepeatRandomNumber($min, $max, $residents);
        }

        return $id;
    }
}