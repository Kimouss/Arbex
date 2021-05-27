<?php

namespace App\DataFixtures\Provider;


use App\Entity\User\Identity;
use Faker\Factory;

class GenericProvider
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function gender()
    {
        return Identity::GENDER_LIST[array_rand(Identity::GENDER_LIST)];
    }

    public function randNumberToString($min = 0, $max = 99999): string
    {
        $number = random_int($min, $max);

        if (strlen($number) === 1) {
            $number = "0".$number;
        }

        return (string) $number;
    }

    public function phoneNumber(): string
    {
        $number = '0';
        for ($i = 0; $i < 9; ++$i) {
            $number .= random_int(0, 9);
        }

        return $number;
    }
}
