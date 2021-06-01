<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
                'name'      => 'Agis',
                'email'=> 'agis2885@gmail.com',
                'password'    => Hash::make('password'),
                'is_admin'=>'1',
                'remember_token' => Hash::make('password')
        ]);
        $user = User::create([
            'name'      => 'Ella',
            'email'=> 'ella@gmail.com',
            'password'    => Hash::make('password'),
            'is_admin'=>'0',
            'remember_token' => Hash::make('password')
        ]);
        $user = User::create([
            'name'      => 'Reni',
            'email'=> 'reni@gmail.com',
            'password'    => Hash::make('password'),
            'is_admin'=>'0',
            'remember_token' => Hash::make('password')
        ]);
        
    }
}
