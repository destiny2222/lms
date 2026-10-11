<?php

namespace Database\Seeders;

use App\Models\AboutSetting;
use Illuminate\Database\Seeder;

class AboutSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutSetting::updateOrCreate(
            ['id' => 1],
            [
                'badge_title' => 'About',
                'heading_prefix' => "Our Techniques Crucial To Learn If You're Going",
                'heading_highlight' => 'To Explore In Learning',
                'description_1' => 'We believe everyone has the capacity to grow in faith and spiritual maturity. RACAi Discipleship is a sacred training ground where believers discover and develop their Kingdom potential.',
                'description_2' => 'Through systematic biblical teachings, mentorship, and community fellowship, our disciples are equipped to lead, minister, and transform lives across nations.',
                'button_text' => 'LEARN MORE',
                'button_link' => '/courses',
                'stat_projects_count' => '200',
                'stat_projects_label' => 'Projects Finished',
                'stat_clients_count' => '199',
                'stat_clients_label' => 'Satisfied Clients',
                'stat_students_count' => '150',
                'stat_students_label' => 'Online Students',
                'stat_years_count' => '20',
                'stat_years_label' => 'Years of Experience',
                'help_title' => 'How Can We',
                'help_title_highlight' => 'Help',
                'help_title_suffix' => 'You',
                'feature_1_title' => 'Scriptural Foundation',
                'feature_1_desc' => 'In-depth systematic biblical doctrine and truth rooted in the Word of God.',
                'feature_2_title' => 'Spiritual Maturity',
                'feature_2_desc' => 'Intentional discipleship pathways designed for personal spiritual transformation.',
                'feature_3_title' => 'Kingdom Leadership',
                'feature_3_desc' => 'Practical equipping and character training for leaders and ministry ministers.',
                'feature_4_title' => 'Lifelong Discipleship',
                'feature_4_desc' => 'Continuous mentorship and supportive Christian fellowship across all stages.',
            ]
        );
    }
}
