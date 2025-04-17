<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Setting;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            1 => [
                'role' => 'admin',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'country_code' => Setting::get('country_code'),
                'mobile' => '9876543210',
                'email' => 'admin@yopmail.com',
                'password' => bcrypt('123456'),
                'location' => 'CHY',
                'address' => '123, Test Address'
            ],
            2 => [
                'role' => 'user',
                'first_name' => 'Billing',
                'last_name' => 'User',
                'country_code' => Setting::get('country_code'),
                'mobile' => '9876543211',
                'email' => 'user@yopmail.com',
                'password' => bcrypt('123456'),
                'location' => 'CHY',
                'address' => '123, Test Address'
            ]
        ];
        
        foreach ($datas as $id => $data) {
            
            $row = User::firstOrNew([
                'id' => $id,
            ]);
            $row->fill($data);
            $row->save();
        }
    }
}
