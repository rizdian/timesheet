<?php

use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'nip' => $faker->title,
        'division_id' => function () {
            return factory(App\Division::class)->create()->id;
        },
        'nama' => $faker->name,
        'tmpt_lahir' => $faker->city,
        'tgl_lahir' => $faker->date(),
        'alamat' => $faker->address
    ];
});

$factory->define(App\Division::class, function (Faker $faker) {
    return [
        'nama' => $faker->name,
        'flag' => '0',
    ];
});
