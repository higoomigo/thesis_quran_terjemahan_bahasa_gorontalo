<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class ValidatorSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Prof. Suleman Bouti',
                'email' => 's_bouti@ung.ac.id',
                'role' => 'linguistik',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
            // [
            //     'name' => 'Ustadz Ahmad Nusi',
            //     'email' => 'ahmad.teologi2@gorontalo.com',
            //     'role' => 'teologi',
            //     'password' => Hash::make('password'),
            //     'email_verified_at' => Carbon::now(),
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'name' => 'Prof. Mansur Botutihe',
            //     'email' => 'mansur.linguis1@gorontalo.com',
            //     'role' => 'linguistik',
            //     'password' => Hash::make('password'),
            //     'email_verified_at' => Carbon::now(),
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'name' => 'Dr. Aminah Gobel',
            //     'email' => 'aminah.linguis2@gorontalo.com',
            //     'role' => 'linguistik',
            //     'password' => Hash::make('password'),
            //     'email_verified_at' => Carbon::now(),
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ]
        ];

        // Gunakan insert untuk memasukkan data sekaligus (Bulk Insert)
        User::insert($users);
    }
}