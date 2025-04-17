<?php

namespace App\Helpers;

class MailHelper
{
    public static function setMailConfig()
    {
        //Set the data in an array variable from settings table
        $mailConfig = [
            'transport' => !blank(setting('email_driver')) ? setting('email_driver') : config('mail.default'),
            'host' => !blank(setting('email_host')) ? setting('email_host') : env('MAIL_HOST', 'smtp.gmail.com'),
            'port' => !blank(setting('email_port')) ? setting('email_port') : env('MAIL_PORT', '465'),
            'encryption' => !blank(setting('email_encryption')) ? setting('email_encryption') : env('MAIL_ENCRYPTION', 'ssl'),
            'username' => !blank(setting('email_username')) ? setting('email_username') : env('MAIL_USERNAME'),
            'password' => !blank(setting('email_password')) ? setting('email_password') : env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null
        ];

        $fromConfig = [
            'address' => !blank(setting('email_username')) ? setting('email_username') : env('MAIL_USERNAME'),
            'name' => !blank(setting('site_name')) ? setting('site_name') : env('MAIL_FROM_NAME')
        ];

        config(['mail.from' => $fromConfig]);

        //To set configuration values at runtime, pass an array to the config helper
        
        // if($settings->email_driver == 'sendgrid') {
        //     config(['mail.default' => 'sendgrid']);
        //     config(['mail.driver' => 'sendgrid']);
        //     config(['services.sendgrid.api_key' => !blank(setting('email_username')) ? setting('email_username') : env('MAIL_USERNAME')]);
        // } else {
            config(['mail.default' => 'smtp']);
            config(['mail.mailers.smtp' => $mailConfig]);
        // }
    }
}
