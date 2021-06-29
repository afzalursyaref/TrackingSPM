<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Afzalur Syaref, S.Kom',
                'email' => 'afzalursyaref4@gmail.com',
                'username' => 'afzalur',
                'password' => Hash::make('afzal22'),
                'role' => 'admin'
            ],
            [
                'name' => 'fo',
                'email' => 'fo@gmail.com',
                'username' => 'fo',
                'password' => Hash::make('12345'),
                'role' => 'front-office'
            ],
            [
                'name' => 'kasi1',
                'email' => 'kasi1@gmail.com',
                'username' => 'kasi1',
                'password' => Hash::make('12345'),
                'role' => 'verifikator'
            ],
            [
                'name' => 'kasi2',
                'email' => 'kasi2@gmail.com',
                'username' => 'kasi2',
                'password' => Hash::make('12345'),
                'role' => 'verifikator'
            ],
            [
                'name' => 'pengelola1',
                'email' => 'pengelola1@gmail.com',
                'username' => 'pengelola1',
                'password' => Hash::make('12345'),
                'role' => 'pengelola'
            ],
            [
                'name' => 'pengelola2',
                'email' => 'pengelola2@gmail.com',
                'username' => 'pengelola2',
                'password' => Hash::make('12345'),
                'role' => 'pengelola'
            ],
            [
                'name' => 'bud',
                'email' => 'bud@gmail.com',
                'username' => 'bud',
                'password' => Hash::make('12345'),
                'role' => 'bud'
            ],
            [
                'name' => 'kbud',
                'email' => 'kbud@gmail.com',
                'username' => 'kbud',
                'password' => Hash::make('12345'),
                'role' => 'kuasa-bud'
            ],

        ];

        User::insert($users);
    }
}
