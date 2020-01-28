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
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita cupiditate placeat, reprehenderit harum eos qui non ex excepturi perferendis dolorem adipisci, exercitationem veritatis fuga inventore molestiae animi repellendus. Rerum, error.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('thematic')->insert([
            'name' => 'Pour madame',
            'order' => 2,
            'slug' => 'pour-madame',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita cupiditate placeat, reprehenderit harum eos qui non ex excepturi perferendis dolorem adipisci, exercitationem veritatis fuga inventore molestiae animi repellendus. Rerum, error.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('thematic')->insert([
            'name' => 'Pour eux',
            'order' => 3,
            'slug' => 'pour-eux',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita cupiditate placeat, reprehenderit harum eos qui non ex excepturi perferendis dolorem adipisci, exercitationem veritatis fuga inventore molestiae animi repellendus. Rerum, error.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('thematic')->insert([
            'name' => 'Les nouveautés',
            'order' => 4,
            'slug' => 'les-nouveautes',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita cupiditate placeat, reprehenderit harum eos qui non ex excepturi perferendis dolorem adipisci, exercitationem veritatis fuga inventore molestiae animi repellendus. Rerum, error.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('thematic')->insert([
            'name' => 'Tous',
            'order' => 5,
            'slug' => 'tous',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita cupiditate placeat, reprehenderit harum eos qui non ex excepturi perferendis dolorem adipisci, exercitationem veritatis fuga inventore molestiae animi repellendus. Rerum, error.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
