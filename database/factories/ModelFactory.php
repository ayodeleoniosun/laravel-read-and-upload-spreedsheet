<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| fakerbase. Just tell the factory how a default model should look.
|
*/

/**
 * @var \Illuminate\fakerbase\Eloquent\Factory $factory
 */

use App\Http\Models\Contract;

$factory->define(
    Contract::class,
    function (Faker\Generator $faker) {
        return [
            'contract_id' => $faker->numberBetween($min = 100000000, $max = 999999999),
            'announcement' => $faker->numberBetween($min = 1000, $max = 9999)."/".$faker->numberBetween($min = 1000, $max = 9999)."/",
            'contract_type' => $faker->sentence($nbWords = 4, $variableNbWords = true),
            'procedure_type' => $faker->sentence($nbWords = 3, $variableNbWords = true),
            'contract_object' => $faker->sentence($nbWords = 3, $variableNbWords = true),
            'adjudicators' => $faker->sentence($nbWords = 3, $variableNbWords = true),
            'winning_company' => $faker->company,
            'publication_date' => $faker->numberBetween($min = 10000, $max = 99999),
            'agreement_date' => $faker->numberBetween($min = 10000, $max = 99999),
            'amount' => $faker->randomFloat($nbMaxDecimals = null, $min = 0, $max = null),
            'cpv' => $faker->sentence($nbWords = 4, $variableNbWords = true),
            'deadline' => $faker->numberBetween($min = 100, $max = 999),
            'location' => $faker->country,
            'reasoning' => $faker->sentence($nbWords = 3, $variableNbWords = true)
        ];
    }
);
