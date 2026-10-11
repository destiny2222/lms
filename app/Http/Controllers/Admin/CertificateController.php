<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CertificateController extends Controller
{
    /**
     * Display a listing of all issued certificates.
     */
    public function index(Request $request): View
    {
        $courses = Course::orderBy('title')->get();

        $query = Certificate::with([
            'enrollment.user',
            'enrollment.course',
        ]);

        // Search by cert number, student name, student email, course title
        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($term) {
                $q->where('certificate_number', 'like', $term)
                    ->orWhere('share_token', 'like', $term)
                    ->orWhereHas('enrollment.user', function ($uq) use ($term) {
                        $uq->where('name', 'like', $term)
                            ->orWhere('email', 'like', $term);
                    })
                    ->orWhereHas('enrollment.course', function ($cq) use ($term) {
                        $cq->where('title', 'like', $term);
                    });
            });
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $courseId = $request->integer('course_id');
            $query->whereHas('enrollment', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            });
        }

        $certificates = $query->latest('issued_at')->paginate(15)->withQueryString();

        $stats = [
            'total_issued' => Certificate::count(),
            'unique_students' => User::whereHas('enrollments.certificate')->count(),
            'this_month' => Certificate::whereMonth('issued_at', now()->month)->whereYear('issued_at', now()->year)->count(),
        ];

        return view('admin.certificates.index', compact('certificates', 'courses', 'stats'));
    }

    /**
     * Revoke / delete an issued certificate.
     */
    public function destroy(Certificate $certificate): RedirectResponse
    {
        $number = $certificate->certificate_number;
        $certificate->delete();

        return back()->with('success', "Certificate {$number} has been revoked and removed.");
    }
}
