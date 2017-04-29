<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'username'       => str_random(10),
        'email'          => $faker->unique()->safeEmail,
        'activated'      => true,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Activation::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () { return factory(App\User::class)->create(['activated' => false])->id; },
        'token'   => str_random(64),
    ];
});

$factory->define(App\Dataset::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->words(3, true),
        'overview'    => $faker->sentence,
        'description' => $faker->paragraphs(3, true),
        'user_id'     => function () { return factory(App\User::class)->create()->id; },
        'featured'    => false,
        'published'   => true,
    ];
});

$factory->define(App\Code::class, function (Faker\Generator $faker) {
    return [
        'user_id'     => function () { return factory(App\User::class)->create()->id; },
        'dataset_id'  => function () { return factory(App\Dataset::class)->create()->id; },
        'name'        => $faker->words(3, true),
        'description' => $faker->paragraphs(3, true),
        'code'        => $faker->paragraphs(3, true),
        'published'   => true,
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->words(2, true),
        'description' => $faker->words(10, true),
    ];
});

$factory->define(App\Thread::class, function (Faker\Generator $faker) {
    return [
        'user_id'     => function () { return factory(App\User::class)->create()->id; },
        'category_id' => function () { return factory(App\Category::class)->create()->id; },
        'name'        => $faker->words(3, true),
        'body'        => $faker->paragraphs(3, true),
        'answered'    => true,
    ];
});

$factory->define(App\Reply::class, function (Faker\Generator $faker) {
    return [
        'user_id'     => function () { return factory(App\User::class)->create()->id; },
        'thread_id'   => function () { return factory(App\Thread::class)->create()->id; },
        'body'        => $faker->paragraphs(3, true),
        'best_answer' => false,
    ];
});
