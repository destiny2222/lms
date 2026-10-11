<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;
use App\Models\ContactSetting;
use App\Models\Testimonial;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageSettingController extends Controller
{
    /**
     * Display the Website Pages & Plugins management hub.
     */
    public function index(): View
    {
        $contactSetting = ContactSetting::getSettings();
        $aboutSetting = AboutSetting::getSettings();
        $testimonialCount = Testimonial::count();

        $plugins = [
            [
                'id' => 'contact',
                'name' => 'Contact Us Page',
                'type' => 'Page Content Plugin',
                'description' => 'Manage ministry telephone numbers, official support email, physical office address, operating hours, and banner.',
                'route' => route('admin.pages.contact'),
                'public_url' => route('contact'),
                'icon' => 'ri-customer-service-2-line',
                'color' => '#2563eb',
                'updated_at' => $contactSetting->updated_at,
                'status' => 'Active',
            ],
            [
                'id' => 'about',
                'name' => 'About Us Page',
                'type' => 'Page Content Plugin',
                'description' => 'Manage ministry vision hero title, descriptions, achievements counter stats, and feature study image.',
                'route' => route('admin.pages.about'),
                'public_url' => route('about'),
                'icon' => 'ri-information-line',
                'color' => '#0891b2',
                'updated_at' => $aboutSetting->updated_at,
                'status' => 'Active',
            ],
            [
                'id' => 'testimonials',
                'name' => 'Student Testimonials',
                'type' => 'Dynamic Content Plugin',
                'description' => 'Showcase disciple testimonies, ratings, designations, and student pictures across the discipleship portal.',
                'route' => route('admin.testimonials.index'),
                'public_url' => route('about'),
                'icon' => 'ri-chat-quote-line',
                'color' => '#8b5cf6',
                'count' => "{$testimonialCount} Reviews",
                'status' => 'Active',
            ],
        ];

        return view('admin.pages.index', compact('contactSetting', 'aboutSetting', 'plugins'));
    }

    /**
     * Show dedicated editor for Contact Us page.
     */
    public function contact(): View
    {
        $contactSetting = ContactSetting::getSettings();

        return view('admin.pages.contact', compact('contactSetting'));
    }

    /**
     * Update Contact Us page settings.
     */
    public function updateContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'section_title' => ['required', 'string', 'max:150'],
            'section_title_highlight' => ['nullable', 'string', 'max:150'],
            'form_title' => ['required', 'string', 'max:150'],
            'form_subtitle' => ['nullable', 'string', 'max:255'],
            'phone_primary' => ['required', 'string', 'max:50'],
            'phone_secondary' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:150'],
            'address' => ['required', 'string', 'max:500'],
            'weekday_hours' => ['nullable', 'string', 'max:100'],
            'weekend_hours' => ['nullable', 'string', 'max:100'],
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'contact_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
        ]);

        $contactSetting = ContactSetting::getSettings();

        $imageUrl = $contactSetting->contact_image;
        if ($request->hasFile('contact_image')) {
            $imageUrl = CloudinaryService::upload($request->file('contact_image'), 'contact');
        }

        $contactSetting->update([
            'section_title' => $validated['section_title'],
            'section_title_highlight' => $validated['section_title_highlight'] ?? null,
            'form_title' => $validated['form_title'],
            'form_subtitle' => $validated['form_subtitle'] ?? null,
            'phone_primary' => $validated['phone_primary'],
            'phone_secondary' => $validated['phone_secondary'] ?? null,
            'email' => $validated['email'],
            'address' => $validated['address'],
            'weekday_hours' => $validated['weekday_hours'] ?? null,
            'weekend_hours' => $validated['weekend_hours'] ?? null,
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'contact_image' => $imageUrl,
        ]);

        return back()->with('success', 'Contact page content updated successfully.');
    }

    /**
     * Show dedicated editor for About Us page.
     */
    public function about(): View
    {
        $aboutSetting = AboutSetting::getSettings();

        return view('admin.pages.about', compact('aboutSetting'));
    }

    /**
     * Update About Us page settings.
     */
    public function updateAbout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'badge_title' => ['nullable', 'string', 'max:50'],
            'heading_prefix' => ['required', 'string', 'max:150'],
            'heading_highlight' => ['nullable', 'string', 'max:150'],
            'description_1' => ['required', 'string', 'max:2000'],
            'description_2' => ['nullable', 'string', 'max:2000'],
            'button_text' => ['nullable', 'string', 'max:50'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'about_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            'stat_projects_count' => ['nullable', 'string', 'max:50'],
            'stat_projects_label' => ['nullable', 'string', 'max:100'],
            'stat_clients_count' => ['nullable', 'string', 'max:50'],
            'stat_clients_label' => ['nullable', 'string', 'max:100'],
            'stat_students_count' => ['nullable', 'string', 'max:50'],
            'stat_students_label' => ['nullable', 'string', 'max:100'],
            'stat_years_count' => ['nullable', 'string', 'max:50'],
            'stat_years_label' => ['nullable', 'string', 'max:100'],
            'help_title' => ['nullable', 'string', 'max:100'],
            'help_title_highlight' => ['nullable', 'string', 'max:100'],
            'help_title_suffix' => ['nullable', 'string', 'max:100'],
            'feature_1_title' => ['nullable', 'string', 'max:100'],
            'feature_1_desc' => ['nullable', 'string', 'max:500'],
            'feature_2_title' => ['nullable', 'string', 'max:100'],
            'feature_2_desc' => ['nullable', 'string', 'max:500'],
            'feature_3_title' => ['nullable', 'string', 'max:100'],
            'feature_3_desc' => ['nullable', 'string', 'max:500'],
            'feature_4_title' => ['nullable', 'string', 'max:100'],
            'feature_4_desc' => ['nullable', 'string', 'max:500'],
        ]);

        $aboutSetting = AboutSetting::getSettings();

        $imageUrl = $aboutSetting->about_image;
        if ($request->hasFile('about_image')) {
            $imageUrl = CloudinaryService::upload($request->file('about_image'), 'about');
        }

        $aboutSetting->update([
            'badge_title' => $validated['badge_title'] ?? 'About',
            'heading_prefix' => $validated['heading_prefix'],
            'heading_highlight' => $validated['heading_highlight'] ?? null,
            'description_1' => $validated['description_1'],
            'description_2' => $validated['description_2'] ?? null,
            'button_text' => $validated['button_text'] ?? 'LEARN MORE',
            'button_link' => $validated['button_link'] ?? '/courses',
            'about_image' => $imageUrl,
            'stat_projects_count' => $validated['stat_projects_count'] ?? '200',
            'stat_projects_label' => $validated['stat_projects_label'] ?? 'Projects Finished',
            'stat_clients_count' => $validated['stat_clients_count'] ?? '199',
            'stat_clients_label' => $validated['stat_clients_label'] ?? 'Satisfied Clients',
            'stat_students_count' => $validated['stat_students_count'] ?? '150',
            'stat_students_label' => $validated['stat_students_label'] ?? 'Online Students',
            'stat_years_count' => $validated['stat_years_count'] ?? '20',
            'stat_years_label' => $validated['stat_years_label'] ?? 'Years of Experience',
            'help_title' => $validated['help_title'] ?? 'How Can We',
            'help_title_highlight' => $validated['help_title_highlight'] ?? 'Help',
            'help_title_suffix' => $validated['help_title_suffix'] ?? 'You',
            'feature_1_title' => $validated['feature_1_title'] ?? 'Scriptural Foundation',
            'feature_1_desc' => $validated['feature_1_desc'] ?? null,
            'feature_2_title' => $validated['feature_2_title'] ?? 'Spiritual Maturity',
            'feature_2_desc' => $validated['feature_2_desc'] ?? null,
            'feature_3_title' => $validated['feature_3_title'] ?? 'Kingdom Leadership',
            'feature_3_desc' => $validated['feature_3_desc'] ?? null,
            'feature_4_title' => $validated['feature_4_title'] ?? 'Lifelong Discipleship',
            'feature_4_desc' => $validated['feature_4_desc'] ?? null,
        ]);

        return back()->with('success', 'About Us page content updated successfully.');
    }
}
