<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'pl_start_no' => 100,
            'country_code' => 91,
            'country' => 'India',
            'currency' => 'Rs',
            'currency_code' => 'IND',
            'currency_symbol' => '₹',
            'site_name' => 'VIVANT',
            'report_email' => 'naveen@yopmail.com',
            'email_driver' => 'smtp',
            'email_host' => 'smtp.gmail.com',
            'email_port' => '465',
            'email_encryption' => 'ssl',
            'email_username' => 'info@dreamstechnologies.com',
            'email_password' => 'Orange@99',
        ];

        Setting::set($datas);
        Setting::save();
    }
}
