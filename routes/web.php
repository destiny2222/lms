<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\LessonPlayerController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\WhatsappWebhookController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontendController::class,'index'])->name('homepage');
Route::get('/about', [FrontendController::class, 'about'])->name('aboutpage');


/*
|--------------------------------------------------------------------------
| Public Routes & Course Showcase
|--------------------------------------------------------------------------
*/
// Route::get('/', [StudentDashboardController::class, 'catalog'])->name('home');
// Route::get('/courses', [StudentDashboardController::class, 'catalog'])->name('courses.index');
// Route::get('/courses/{slug}', [StudentDashboardController::class, 'courseDetail'])->name('courses.show');

/*
|--------------------------------------------------------------------------
| Public Certificate Verification & Social Share Badges
|--------------------------------------------------------------------------
*/
Route::get('/verify/{token}', [CertificateController::class, 'verify'])->name('certificates.verify');
Route::get('/certificates/{certificate}/pdf', [CertificateController::class, 'downloadPdf'])->name('certificates.pdf');
Route::get('/certificates/{certificate}/badge', [CertificateController::class, 'badge'])->name('certificates.badge');

/*
|--------------------------------------------------------------------------
| Meta WhatsApp Cloud API Webhook (Two-Way Conversations)
|--------------------------------------------------------------------------
*/
Route::match(['get', 'post'], '/api/whatsapp/webhook', function (\Illuminate\Http\Request $request, WhatsappWebhookController $controller) {
    if ($request->isMethod('get')) {
        return $controller->verify($request);
    }
    return $controller->handle($request);
})->name('whatsapp.webhook');

Route::match(['get', 'post'], '/webhook/whatsapp', function (\Illuminate\Http\Request $request, WhatsappWebhookController $controller) {
    if ($request->isMethod('get')) {
        return $controller->verify($request);
    }
    return $controller->handle($request);
});

/*
|--------------------------------------------------------------------------
| Authentication (Login, Student Self-Registration, Logout)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Student Portal
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::post('/enroll/{course}', [StudentDashboardController::class, 'enroll'])->name('enroll');

    // Online-only video playback (download disabled)
    Route::get('/learn/{courseSlug}/{lessonSlug}', [LessonPlayerController::class, 'show'])->name('lesson.show');
    Route::post('/learn/{courseSlug}/{lessonSlug}/complete', [LessonPlayerController::class, 'complete'])->name('lesson.complete');

    // Tests and Certification Exams
    Route::get('/quiz/{courseSlug}/{quizId}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{courseSlug}/{quizId}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
});

/*
|--------------------------------------------------------------------------
| Admin & Tutor Portal
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin|tutor'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Course & Lesson Management
    Route::get('/courses', [AdminDashboardController::class, 'courses'])->name('courses.index');
    Route::get('/courses/create', [AdminDashboardController::class, 'createCourse'])->name('courses.create');
    Route::post('/courses', [AdminDashboardController::class, 'storeCourse'])->name('courses.store');
    Route::get('/courses/{course}/lessons', [AdminDashboardController::class, 'lessons'])->name('courses.lessons');
    Route::post('/courses/{course}/lessons', [AdminDashboardController::class, 'storeLesson'])->name('courses.lessons.store');

    // WhatsApp Bot Control Center & Bulk Broadcasts
    Route::get('/whatsapp', [AdminDashboardController::class, 'whatsapp'])->name('whatsapp.index');
    Route::post('/whatsapp/bulk', [AdminDashboardController::class, 'sendBulkWhatsapp'])->name('whatsapp.bulk');
    Route::post('/whatsapp/trigger-reminders', [AdminDashboardController::class, 'triggerReminders'])->name('whatsapp.reminders');
});
