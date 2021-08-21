<?php

use Illuminate\Database\Seeder;
use App\Models\Products;
use App\User;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

    	for ($i=0; $i < 150; $i++) { 
    		$products = Products::create([
		       'user_id' => factory(App\User::class),
		       'product_name' => 'Product Name '.$i,
		       'short_description' => 'Product short description '.$i,
		       'product_description' => 'Product short description '.$i,
		       'skill_level' => 'easy',
		       'category_id' => 1,
		       'sku' => 'SKU-0000'.$i,
		       'attribute_set' => 'attribute set',
		       'product_type' => 'product type',
		       'is_custom' => 1,
		       'design_type' => 'design type',
		       'status' => 1,
		       'price' => 10
		    ]);
    	}
    }
}
