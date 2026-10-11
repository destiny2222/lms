<?php

namespace App\Http\Controllers;

use App\Models\AboutSetting;
use App\Models\ContactSetting;
use App\Models\Course;
use App\Models\Testimonial;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function index(): View
    {
        $courses = Course::with(['tutor', 'lessons', 'enrollments'])
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.index', compact('courses'));
    }

    public function about(): View
    {
        $aboutSetting = AboutSetting::getSettings();
        $testimonials = Testimonial::active()
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->get();

        return view('frontend.about-us', compact('aboutSetting', 'testimonials'));
    }

    public function faqs(): View
    {
        return view('frontend.faqs');
    }

    public function contact(): View
    {
        $contactSetting = ContactSetting::getSettings();

        return view('frontend.contact', compact('contactSetting'));
    }

    public function privacy(): View
    {
        return view('frontend.privacy-policy');
    }

    public function terms(): View
    {
        return view('frontend.terms-service');
    }
}
