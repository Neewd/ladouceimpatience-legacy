<?php

use App\Label;
use App\Product;
use App\Thematic;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        factory(Product::class, 18)->create();

        // Populate the pivot table
        App\Product::all()->each(function ($product) use ($faker) { 
            $product->thematics()->attach($faker->randomElement(Thematic::primaryThematic()->pluck('id')), ['primary' => true]); 
            $product->thematics()->attach(Thematic::where('slug', '=', 'tous')->get()); 
            $product->thematics()->attach(Thematic::where('slug', '=', 'les-nouveautes')->get()); 
            $product->labels()->attach(Label::all()); 

            // We create 4 images and put this one as primary 
            DB::table('products_images')->insert([
                'picture_url' => $faker->imageUrl(300, 300),
                'type' => 'primary',
                'product_id' => $product->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DB::table('products_images')->insert([
                'picture_url' => $faker->imageUrl(300, 300),
                'type' => 'secondary',
                'product_id' => $product->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DB::table('products_images')->insert([
                'picture_url' => $faker->imageUrl(300, 300),
                'type' => 'normal',
                'product_id' => $product->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DB::table('products_images')->insert([
                'picture_url' => $faker->imageUrl(300, 300),
                'type' => 'normal',
                'product_id' => $product->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });
    }
}
