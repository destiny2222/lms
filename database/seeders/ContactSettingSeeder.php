<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use Illuminate\Database\Seeder;

class ContactSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactSetting::updateOrCreate(
            ['id' => 1],
            [
                'section_title' => 'For More Information Get In',
                'section_title_highlight' => 'Touch With RACAi Discipleship',
                'form_title' => 'Leave A Message',
                'form_subtitle' => 'Your email address will not be published. Required fields are marked *',
                'phone_primary' => '800 388 80 90',
                'phone_secondary' => '1800 1102',
                'email' => 'support@racaitraining.org',
                'address' => 'Rock of Ages Christian Assembly (RACAi), Benin City, Nigeria',
                'weekday_hours' => '09:00 am - 5:00 pm',
                'weekend_hours' => '10:30 am - 1:00 pm',
                'whatsapp_number' => '+2348079730678',
            ]
        );
    }
}
