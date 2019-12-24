<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => 'Clément',
            'lastname' => 'Bacouelle',
            'email' => 'clement.bacouelle@gmail.com',
            'password' => Hash::make('clementine'),
            'is_admin' => true,
            'phone' => '+33647322915',
            'gender' => 'male',
            'birth_Date' => DateTime::createFromFormat("d/m/Y", '20/12/1991'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
        User::where('email', '=', 'clement.bacouelle@gmail.com')->first()->assignRole('admin');
        DB::table('users')->insert([
            'firstname' => 'Marine',
            'lastname' => 'Poncet',
            'email' => 'marine.poncet6@gmail.com',
            'password' => Hash::make('chaton'),
            'is_admin' => true,
            'phone' => '+33647322915',
            'gender' => 'female',
            'birth_Date' => DateTime::createFromFormat("d/m/Y", '10/06/1994'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
