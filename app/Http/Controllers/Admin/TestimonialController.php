<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    /**
     * Display a listing of all testimonials.
     */
    public function index(Request $request): View
    {
        $query = Testimonial::query();

        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('designation', 'like', $term)
                    ->orWhere('content', 'like', $term);
            });
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->input('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $testimonials = $query->orderBy('sort_order', 'asc')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => Testimonial::count(),
            'active' => Testimonial::where('is_active', true)->count(),
            'inactive' => Testimonial::where('is_active', false)->count(),
        ];

        return view('admin.testimonials.index', compact('testimonials', 'stats'));
    }

    /**
     * Store a newly created testimonial in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'designation' => ['nullable', 'string', 'max:150'],
            'content' => ['required', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imageUrl = CloudinaryService::upload($request->file('image'), 'testimonials');
        }

        Testimonial::create([
            'name' => $validated['name'],
            'designation' => $validated['designation'] ?? null,
            'content' => $validated['content'],
            'image' => $imageUrl,
            'rating' => $validated['rating'] ?? 5,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return back()->with('success', 'Testimonial added successfully.');
    }

    /**
     * Update the specified testimonial in storage.
     */
    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'designation' => ['nullable', 'string', 'max:150'],
            'content' => ['required', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $imageUrl = $testimonial->image;
        if ($request->hasFile('image')) {
            $imageUrl = CloudinaryService::upload($request->file('image'), 'testimonials');
        }

        $testimonial->update([
            'name' => $validated['name'],
            'designation' => $validated['designation'] ?? null,
            'content' => $validated['content'],
            'image' => $imageUrl,
            'rating' => $validated['rating'] ?? 5,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return back()->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Toggle active visibility status of testimonial.
     */
    public function toggleStatus(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update([
            'is_active' => ! $testimonial->is_active,
        ]);

        $statusText = $testimonial->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Testimonial has been {$statusText}.");
    }

    /**
     * Remove the specified testimonial from storage.
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $name = $testimonial->name;
        $testimonial->delete();

        return back()->with('success', "Testimonial from \"{$name}\" was deleted successfully.");
    }
}
