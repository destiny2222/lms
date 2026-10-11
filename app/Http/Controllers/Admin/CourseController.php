<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Services\CloudinaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function courses(): View
    {
        $courses = Course::with(['lessons', 'enrollments'])
            ->latest()
            ->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function createCourse(): View
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function storeCourse(CourseRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $thumbnailUrl = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailUrl = CloudinaryService::upload($request->file('thumbnail'), 'courses/thumbnails');
        }

        $course = Course::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::random(4),
            'subtitle' => $validated['subtitle'] ?? null,
            'description' => $validated['description'],
            'level' => $validated['level'],
            'duration_hours' => $validated['duration_hours'],
            'status' => $validated['status'],
            'thumbnail' => $thumbnailUrl,
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.courses.lessons', $course->id)
            ->with('success', "Course '{$course->title}' created! Now add lessons.");
    }

    public function editCourse(Course $course): View
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function destroyCourse(Course $course): RedirectResponse
    {
        $title = $course->title;
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', "Course '{$title}' was deleted successfully.");
    }

    public function updateCourse(CourseRequest $request, Course $course): RedirectResponse
    {
        $validated = $request->validated();

        // Upload new thumbnail if provided
        $thumbnailUrl = $course->thumbnail;
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($course->thumbnail) {
                CloudinaryService::delete($course->thumbnail);
            }
            $thumbnailUrl = CloudinaryService::upload($request->file('thumbnail'), 'courses/thumbnails');
        }

        // Update course
        $course->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'description' => $validated['description'],
            'level' => $validated['level'],
            'duration_hours' => $validated['duration_hours'],
            'status' => $validated['status'],
            'thumbnail' => $thumbnailUrl,
            'published_at' => $validated['status'] === 'published' ? ($course->published_at ?? now()) : null,
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', "Course '{$course->title}' updated successfully!");
    }

    /**
     * Display the lesson manager for a given course.
     */
    public function lessons(Course $course): View
    {
        $course->load(['lessons.quiz', 'quizzes']);
        $cloudinaryConfig = CloudinaryService::getWidgetConfig("courses/{$course->slug}/videos");

        return view('admin.courses.lessons', compact('course', 'cloudinaryConfig'));
    }

    /**
     * Store a newly created lesson for a course.
     */
    public function storeLesson(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/webm,video/ogg,video/x-matroska', 'max:512000'],
            'video_url' => ['nullable', 'string'],
            'video_duration_minutes' => ['nullable', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'is_free_preview' => ['boolean'],
        ]);

        if (! $request->hasFile('video_file') && empty($validated['video_url'])) {
            return back()->withErrors(['video_file' => 'Please either upload a video file or provide a video stream URL.'])->withInput();
        }

        if ($request->hasFile('video_file')) {
            $videoData = CloudinaryService::uploadVideo($request->file('video_file'), "courses/{$course->slug}/videos");
            $videoUrl = $videoData['secure_url'];
            $videoProvider = $videoData['driver'] === 'cloudinary' ? 'cloudinary' : 'stream';
            $durationMinutes = $validated['video_duration_minutes'] ?? $videoData['duration_minutes'];
        } else {
            $videoUrl = $validated['video_url'];
            $videoProvider = str_contains($videoUrl, 'cloudinary.com') ? 'cloudinary' : (str_contains($videoUrl, 'vimeo') ? 'vimeo' : (str_contains($videoUrl, 'youtube') || str_contains($videoUrl, 'youtu.be') ? 'youtube' : 'stream'));
            $durationMinutes = (int) ($validated['video_duration_minutes'] ?? 10);
        }

        $nextOrder = (int) $course->lessons()->max('sort_order') + 1;

        $course->lessons()->create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::random(4),
            'video_url' => $videoUrl,
            'video_provider' => $videoProvider,
            'video_duration_minutes' => $durationMinutes,
            'description' => $validated['description'] ?? null,
            'is_free_preview' => $request->boolean('is_free_preview'),
            'sort_order' => $nextOrder,
        ]);

        return back()->with('success', 'Video lesson added to course successfully!');
    }

    /**
     * Generate dynamic HMAC-SHA1 signature for Cloudinary Upload Widget.
     */
    public function signCloudinaryUpload(Request $request): JsonResponse
    {
        $paramsToSign = $request->input('params_to_sign', []);
        $signature = CloudinaryService::signParameters($paramsToSign);

        return response()->json([
            'signature' => $signature,
        ]);
    }
}
