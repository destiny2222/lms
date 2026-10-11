<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::firstOrCreate(
            ['name' => 'Charry Porter'],
            [
                'designation' => 'Student at Porter Library',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullmco laboris nisi ut aliquip ex ea sit aspernatur aut odit aut qua.',
                'image' => 'assets/images/clients/client-1.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        Testimonial::firstOrCreate(
            ['name' => 'Ricky Johnson'],
            [
                'designation' => 'Instructor at Porter Library',
                'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem.',
                'image' => 'assets/images/clients/client-2.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2,
            ]
        );
    }
}
