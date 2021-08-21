<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Products;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Products::class, function (Faker $faker) {
    return [
       'user_id' => factory(App\User::class),
       'product_name' => $faker->product_name,
       'short_description' => $faker->short_description,
       'product_description' => $faker->product_description,
       'skill_level' => 'easy',
       'category_id' => 1,
       'sku' => $faker->sku,
       'attribute_set' => $faker->attribute_set,
       'product_type' => $faker->product_type,
       'is_custom' => 1,
       'design_type' => $faker->design_type,
       'product_go_live_date' => now(),
       'status' => 1,
       'price' => 10
    ];
});
