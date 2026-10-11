<?php

use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DataRewardController as AdminDataRewardController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\PageSettingController as AdminPageSettingController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DataRewardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LessonPlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\WhatsappWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');

Route::get('/faqs', [FrontendController::class, 'faqs'])->name('faqs');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('/terms-of-service', [FrontendController::class, 'terms'])->name('terms');

/*
|--------------------------------------------------------------------------
| Public Routes & Course Showcase
|--------------------------------------------------------------------------
*/
Route::get('/courses', [StudentDashboardController::class, 'catalog'])->name('courses.index');
Route::get('/courses/{slug}', [StudentDashboardController::class, 'courseDetail'])->name('courses.show');

/*
|--------------------------------------------------------------------------
| Public Certificate Verification & Social Share Badges
|--------------------------------------------------------------------------
*/
Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index')->middleware('auth');
Route::get('/verify/{token}', [CertificateController::class, 'verify'])->name('certificates.verify');
Route::get('/certificates/{certificate}/pdf', [CertificateController::class, 'downloadPdf'])->name('certificates.pdf');
Route::get('/certificates/{certificate}/badge', [CertificateController::class, 'badge'])->name('certificates.badge');

/*
|--------------------------------------------------------------------------
| Meta WhatsApp Cloud API Webhook (Two-Way Conversations)
|--------------------------------------------------------------------------
*/
Route::match(['get', 'post'], '/api/whatsapp/webhook', function (Request $request, WhatsappWebhookController $controller) {
    if ($request->isMethod('get')) {
        return $controller->verify($request);
    }

    return $controller->handle($request);
})->name('whatsapp.webhook');

Route::match(['get', 'post'], '/webhook/whatsapp', function (Request $request, WhatsappWebhookController $controller) {
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
    Route::get('/courses', [StudentDashboardController::class, 'myCourses'])->name('courses');
    Route::get('/my-courses', [StudentDashboardController::class, 'myCourses'])->name('my-courses');
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates');
    Route::post('/enroll/{course}', [StudentDashboardController::class, 'enroll'])->name('enroll');

    // Online-only video playback (download disabled)
    Route::get('/learn/{courseSlug}/{lessonSlug}', [LessonPlayerController::class, 'show'])->name('lesson.show');
    Route::post('/learn/{courseSlug}/{lessonSlug}/complete', [LessonPlayerController::class, 'complete'])->name('lesson.complete');

    // Tests and Certification Exams
    Route::get('/quiz/{courseSlug}/{quizId}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{courseSlug}/{quizId}/submit', [QuizController::class, 'submit'])->name('quiz.submit');

    // 10-Badge Milestone Data Rewards
    Route::post('/rewards/{reward}/claim', [DataRewardController::class, 'claim'])->name('rewards.claim');

    // Profile & Account Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Profile alias
Route::get('/profile', [ProfileController::class, 'edit'])->middleware('auth')->name('profile');

/*
|--------------------------------------------------------------------------
| Admin Portal (Custom Blade & 2FA Auth)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Auth Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);

        Route::get('/verify-otp', [AdminLoginController::class, 'showOtpForm'])->name('otp.show');
        Route::post('/verify-otp', [AdminLoginController::class, 'verifyOtp'])->name('otp.verify');
        Route::post('/resend-otp', [AdminLoginController::class, 'resendOtp'])->name('otp.resend');
    });

    // Authenticated Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [AdminHomeController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminHomeController::class, 'index']);
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        // Course & Curriculum Management
        Route::get('/courses', [AdminCourseController::class, 'courses'])->name('courses.index');
        Route::get('/courses/create', [AdminCourseController::class, 'createCourse'])->name('courses.create');
        Route::post('/courses', [AdminCourseController::class, 'storeCourse'])->name('courses.store');
        Route::get('/courses/{course}/edit', [AdminCourseController::class, 'editCourse'])->name('courses.edit');
        Route::put('/courses/{course}', [AdminCourseController::class, 'updateCourse'])->name('courses.update');
        Route::delete('/courses/{course}', [AdminCourseController::class, 'destroyCourse'])->name('courses.destroy');
        Route::get('/courses/{course}/lessons', [AdminCourseController::class, 'lessons'])->name('courses.lessons');
        Route::post('/courses/{course}/lessons', [AdminCourseController::class, 'storeLesson'])->name('courses.lessons.store');
        Route::post('/cloudinary/sign', [AdminCourseController::class, 'signCloudinaryUpload'])->name('cloudinary.sign');

        // Quizzes & Assessments Management
        Route::get('/quizzes', [AdminQuizController::class, 'index'])->name('quizzes.index');
        Route::get('/quizzes/create', [AdminQuizController::class, 'create'])->name('quizzes.create');
        Route::post('/quizzes', [AdminQuizController::class, 'store'])->name('quizzes.store');
        Route::get('/quizzes/{quiz}/builder', [AdminQuizController::class, 'builder'])->name('quizzes.builder');
        Route::get('/quizzes/{quiz}/edit', [AdminQuizController::class, 'builder'])->name('quizzes.edit');
        Route::put('/quizzes/{quiz}', [AdminQuizController::class, 'update'])->name('quizzes.update');
        Route::delete('/quizzes/{quiz}', [AdminQuizController::class, 'destroy'])->name('quizzes.destroy');

        // Quiz Questions & Answers CRUD
        Route::post('/quizzes/{quiz}/questions', [AdminQuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
        Route::put('/quizzes/{quiz}/questions/{question}', [AdminQuizController::class, 'updateQuestion'])->name('quizzes.questions.update');
        Route::delete('/quizzes/{quiz}/questions/{question}', [AdminQuizController::class, 'destroyQuestion'])->name('quizzes.questions.destroy');

        // Quiz Student Attempts
        Route::get('/quizzes/{quiz}/attempts', [AdminQuizController::class, 'attempts'])->name('quizzes.attempts');

        // Disciples & Students Management
        Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
        Route::get('/students/{user}', [AdminStudentController::class, 'show'])->name('students.show');

        // Issued Certificates Management
        Route::get('/certificates', [AdminCertificateController::class, 'index'])->name('certificates.index');
        Route::delete('/certificates/{certificate}', [AdminCertificateController::class, 'destroy'])->name('certificates.destroy');

        // Milestone Data Rewards Management
        Route::get('/rewards', [AdminDataRewardController::class, 'index'])->name('rewards.index');
        Route::post('/rewards/{reward}/fulfill', [AdminDataRewardController::class, 'fulfill'])->name('rewards.fulfill');

        // Testimonials Management
        Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
        Route::post('/testimonials', [AdminTestimonialController::class, 'store'])->name('testimonials.store');
        Route::put('/testimonials/{testimonial}', [AdminTestimonialController::class, 'update'])->name('testimonials.update');
        Route::patch('/testimonials/{testimonial}/toggle', [AdminTestimonialController::class, 'toggleStatus'])->name('testimonials.toggle');
        Route::delete('/testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');

        // Website Pages & Content Plugins CMS
        Route::prefix('pages')->name('pages.')->group(function () {
            Route::get('/', [AdminPageSettingController::class, 'index'])->name('index');
            Route::get('/contact', [AdminPageSettingController::class, 'contact'])->name('contact');
            Route::put('/contact', [AdminPageSettingController::class, 'updateContact'])->name('contact.update');
            Route::get('/about', [AdminPageSettingController::class, 'about'])->name('about');
            Route::put('/about', [AdminPageSettingController::class, 'updateAbout'])->name('about.update');
        });

        // WhatsApp Bot & Automation
        Route::get('/whatsapp', [AdminDashboardController::class, 'whatsapp'])->name('whatsapp.index');
        Route::post('/whatsapp/broadcast', [AdminDashboardController::class, 'sendBulkWhatsapp'])->name('whatsapp.broadcast');
        Route::post('/whatsapp/bulk', [AdminDashboardController::class, 'sendBulkWhatsapp'])->name('whatsapp.bulk');
        Route::post('/whatsapp/reminders', [AdminDashboardController::class, 'triggerReminders'])->name('whatsapp.reminders');
    });
});
