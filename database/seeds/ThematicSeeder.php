<?php

use Illuminate\Database\Seeder;

class ThematicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('thematic')->insert([
            'name' => 'Pour monsieur',
            'order' => 1,
            'slug' => 'pour-monsieur',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('thematic')->insert([
            'name' => 'Pour madame',
            'order' => 2,
            'slug' => 'pour-madame',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('thematic')->insert([
            'name' => 'Pour eux',
            'order' => 3,
            'slug' => 'pour-eux',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('thematic')->insert([
            'name' => 'Les nouveautés',
            'order' => 4,
            'slug' => 'les-nouveautes',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('thematic')->insert([
            'name' => 'Tous',
            'order' => 5,
            'slug' => 'tous',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
