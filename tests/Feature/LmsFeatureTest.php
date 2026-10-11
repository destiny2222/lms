<?php

use App\Models\AboutSetting;
use App\Models\Admin;
use App\Models\Certificate;
use App\Models\ContactSetting;
use App\Models\Course;
use App\Models\DataReward;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed roles and course
    Artisan::call('db:seed');
});

test('student can self-register with phone number', function () {
    $response = $this->post('/register', [
        'name' => 'Jane Student',
        'email' => 'janestudent@test.com',
        'phone' => '+15551234567',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('student.dashboard'));
    $this->assertDatabaseHas('users', [
        'email' => 'janestudent@test.com',
        'phone' => '+15551234567',
    ]);
});

test('homepage renders dynamic published courses with enroll actions', function () {
    $course = Course::where('slug', 'authority-to-buy-masterclass')->first();

    $response = $this->get(route('home'));
    $response->assertStatus(200);
    $response->assertSee('Our Latest');
    $response->assertSee('Courses');
    $response->assertSee($course->title);
    $response->assertSee(route('courses.show', $course->slug));
});

test('student can enroll in a course for free', function () {
    $student = User::where('email', 'student@lms.test')->first();
    $course = Course::where('slug', 'authority-to-buy-masterclass')->first();

    $response = $this->actingAs($student)->post(route('student.enroll', $course->id));

    $this->assertDatabaseHas('enrollments', [
        'user_id' => $student->id,
        'course_id' => $course->id,
    ]);
});

test('student can watch video online and mark lesson complete', function () {
    $student = User::where('email', 'student@lms.test')->first();
    $course = Course::where('slug', 'authority-to-buy-masterclass')->first();
    $lesson = $course->lessons()->first();

    // Student visits lesson page
    $response = $this->actingAs($student)->get(route('student.lesson.show', [$course->slug, $lesson->slug]));
    $response->assertStatus(200);
    $response->assertSeeText($lesson->title);

    // Student completes lesson
    $completeResponse = $this->actingAs($student)->post(route('student.lesson.complete', [$course->slug, $lesson->slug]));

    $this->assertDatabaseHas('lesson_progress', [
        'lesson_id' => $lesson->id,
        'is_completed' => true,
    ]);
});

test('passing the final exam generates verifiable certificate badge', function () {
    $student = User::where('email', 'student@lms.test')->first();
    $course = Course::where('slug', 'authority-to-buy-masterclass')->first();
    $finalExam = $course->finalExam();

    $answers = [];
    foreach ($finalExam->questions as $q) {
        $answers[$q->id] = $q->correct_answer_index;
    }

    $response = $this->actingAs($student)->post(route('student.quiz.submit', [$course->slug, $finalExam->id]), [
        'answers' => $answers,
    ]);

    $certificate = Certificate::whereHas('enrollment', function ($q) use ($student, $course) {
        $q->where('user_id', $student->id)->where('course_id', $course->id);
    })->first();

    expect($certificate)->not->toBeNull();
    $response->assertRedirect(route('certificates.verify', $certificate->share_token));

    // Public verification page works
    $verifyPage = $this->get(route('certificates.verify', $certificate->share_token));
    $verifyPage->assertStatus(200);
    $verifyPage->assertSeeText($student->name);
    $verifyPage->assertSeeText($certificate->certificate_number);
});

test('whatsapp automated follow-up reminder command executes successfully', function () {
    $exitCode = Artisan::call('lms:send-whatsapp-reminders');
    expect($exitCode)->toBe(0);
});

test('whatsapp webhook challenge verification works for Meta Cloud API', function () {
    $response = $this->get('/api/whatsapp/webhook?hub_mode=subscribe&hub_verify_token=lms_webhook_secret_token&hub_challenge=meta_challenge_12345');
    $response->assertStatus(200);
    expect($response->getContent())->toBe('meta_challenge_12345');
});

test('whatsapp webhook responds to student two-way PROGRESS message', function () {
    $student = User::where('email', 'student@lms.test')->first();

    $response = $this->postJson('/api/whatsapp/webhook', [
        'entry' => [
            [
                'changes' => [
                    [
                        'value' => [
                            'messages' => [
                                [
                                    'id' => 'wamid.HBgLMTIzNDU2Nzg5MDE=',
                                    'from' => '12345678903',
                                    'type' => 'text',
                                    'text' => [
                                        'body' => 'PROGRESS',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('whatsapp_messages', [
        'direction' => 'inbound',
        'message_body' => 'PROGRESS',
    ]);
});

test('login page renders with Edudash template and sign in form', function () {
    $response = $this->get(route('login'));
    $response->assertStatus(200);
    $response->assertSee('Welcome Back');
    $response->assertSee('Email Address');
    $response->assertSee('Sign In');
});

test('student dashboard renders with Edudash sidebar and metrics', function () {
    $student = User::where('email', 'student@lms.test')->first();

    $response = $this->actingAs($student)->get(route('student.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Welcome back');
    $response->assertSee('sidebar-menu');
    $response->assertSee('gradient-bg-end-1');
    $response->assertSee('course-activity-analytics');
    $response->assertSee('course-performance-table');
    $response->assertSeeText('Course Activity & Learning Velocity');
    $response->assertSeeText('Course Performance & Credential Analysis');
    $response->assertSeeText('Verified Certificates & Digital Badges');
});

test('student certificates page renders using Edudash certificate template', function () {
    $student = User::where('email', 'student@lms.test')->first();

    $response = $this->actingAs($student)->get(route('student.certificates'));
    $response->assertStatus(200);
    $response->assertSee('Certificate');
    $response->assertSee('dataTable');
    $response->assertSee('Certificate of Completion');
});

test('courses catalog page renders using Jexi courses template', function () {
    $response = $this->get(route('courses.index'));
    $response->assertStatus(200);
    $response->assertSee('course-section');
    $response->assertSee('course-card');
    $response->assertSee('The Authority to Buy: Masterclass for Modern Learners');
});

test('single course page renders using Jexi single-course template', function () {
    $course = Course::where('slug', 'authority-to-buy-masterclass')->first();

    $response = $this->get(route('courses.show', $course->slug));
    $response->assertStatus(200);
    $response->assertSee('course-details-section');
    $response->assertSee('summery-box');
    $response->assertSee('product-tab-list');
    $response->assertSeeText('Course Description');
    $response->assertSeeText('Course Outline & Lessons');
    $response->assertSeeText('Automated WhatsApp Accountability Bot');
});

test('admin can access custom admin dashboard with standard theme and navigation groups', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $response = $this->actingAs($admin, 'admin')->get('/admin');
    $response->assertStatus(200);
    $response->assertSee('RACAi');
    $response->assertSee('Dashboard');
    $response->assertSee('Courses & Curriculum');
    $response->assertSee('Total Learners');
});

test('regular student or unauthenticated guest cannot access admin dashboard', function () {
    $student = User::where('email', 'student@lms.test')->first();

    $response = $this->actingAs($student)->get('/admin');
    $response->assertRedirect(route('admin.login'));
});

test('course slug is automatically generated when created without manual slug', function () {
    $course = Course::create([
        'title' => 'Advanced Laravel Mastery Bootcamp',
        'level' => 'advanced',
        'duration_hours' => 12,
        'status' => 'published',
    ]);

    expect($course->slug)->toStartWith('advanced-laravel-mastery-bootcamp');
});

test('admin create course page renders successfully and redirects to list', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $response = $this->actingAs($admin, 'admin')->get('/admin/courses/create');
    $response->assertStatus(200);
    $response->assertSee('Create Course');
});

test('student can view dedicated my courses page with progress and filters', function () {
    $student = User::where('email', 'student@lms.test')->first();
    $course = Course::where('slug', 'authority-to-buy-masterclass')->first();

    $this->actingAs($student)->post(route('student.enroll', $course->id));

    $response = $this->actingAs($student)->get(route('student.courses'));
    $response->assertStatus(200);
    $response->assertSee('My Enrolled Courses');
    $response->assertSee('Enrolled Tracks');
    $response->assertSee($course->title);
    $response->assertSee('All Courses');
    $response->assertSee('In Progress');
    $response->assertSee('Completed');
    $response->assertSee('Browse Course Catalog');
});

test('privacy policy and terms of service pages render successfully', function () {
    $privacy = $this->get(route('privacy'));
    $privacy->assertStatus(200);
    $privacy->assertSee('Privacy Policy');

    $terms = $this->get(route('terms'));
    $terms->assertStatus(200);
    $terms->assertSee('Terms of Service');
});

test('custom error pages render standard standalone layout without main layouts', function () {
    $views = [
        'errors.404' => '404',
        'errors.403' => '403',
        'errors.419' => '419',
        'errors.500' => '500',
        'errors.503' => '503',
        'errors.401' => '401',
        'errors.429' => '429',
    ];

    foreach ($views as $view => $code) {
        $rendered = view($view)->render();
        expect($rendered)->toContain('error-page-section')
            ->and($rendered)->toContain('error-card')
            ->and($rendered)->toContain($code)
            ->and($rendered)->toContain('Authority LMS')
            // Assert that main layout elements are NOT present
            ->and($rendered)->not->toContain('footer-section')
            ->and($rendered)->not->toContain('banner-section')
            ->and($rendered)->not->toContain('search-box-widget');
    }

    // Verify 404 on invalid route
    $response = $this->get('/invalid-non-existent-endpoint');
    $response->assertStatus(404);
    $response->assertSee('404');
    $response->assertSee('Page Not Found');
    $response->assertDontSee('footer-section');
});

test('authenticated user can view edit profile page', function () {
    $student = User::where('email', 'student@lms.test')->first();

    $response = $this->actingAs($student)->get(route('student.profile'));
    $response->assertStatus(200);
    $response->assertSee('My Profile & Account Settings');
    $response->assertSee($student->name);
    $response->assertSee($student->email);
    $response->assertSee('WhatsApp Phone Number');
    $response->assertSeeText('Password & Security');
});

test('user can update profile information', function () {
    $student = User::where('email', 'student@lms.test')->first();

    $response = $this->actingAs($student)->put(route('student.profile.update'), [
        'name' => 'Alex Updated',
        'email' => 'alexupdated@lms.test',
        'phone' => '+19998887777',
        'whatsapp_opted_in' => '1',
        'bio' => 'Aspiring developer focused on Laravel and systems.',
    ]);

    $response->assertRedirect(route('student.profile'));
    $response->assertSessionHas('success');

    $student->refresh();
    expect($student->name)->toBe('Alex Updated')
        ->and($student->email)->toBe('alexupdated@lms.test')
        ->and($student->phone)->toBe('+19998887777')
        ->and($student->whatsapp_opted_in)->toBeTrue()
        ->and($student->bio)->toBe('Aspiring developer focused on Laravel and systems.');
});

test('user can update account password with valid current password', function () {
    $student = User::where('email', 'student@lms.test')->first();

    $response = $this->actingAs($student)->put(route('student.profile.password'), [
        'current_password' => 'password',
        'password' => 'NewSecurePassword123!',
        'password_confirmation' => 'NewSecurePassword123!',
    ]);

    $response->assertRedirect(route('student.profile'));
    $response->assertSessionHas('success');

    $student->refresh();
    expect(Hash::check('NewSecurePassword123!', $student->password))->toBeTrue();
});

test('user cannot update password with invalid current password', function () {
    $student = User::where('email', 'student@lms.test')->first();

    $response = $this->actingAs($student)->put(route('student.profile.password'), [
        'current_password' => 'wrong-current-password',
        'password' => 'NewSecurePassword123!',
        'password_confirmation' => 'NewSecurePassword123!',
    ]);

    $response->assertSessionHasErrors('current_password');
});

test('admin can create a course with CourseRequest and uploaded thumbnail via CloudinaryService', function () {
    Storage::fake('public');

    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $file = UploadedFile::fake()->image('course-cover.jpg', 600, 400);

    $response = $this->actingAs($admin, 'admin')->post(route('admin.courses.store'), [
        'title' => 'Kingdom Leadership Masterclass',
        'subtitle' => 'Guiding next-gen disciples',
        'description' => 'A complete masterclass on discipleship governance and spiritual leadership.',
        'level' => 'intermediate',
        'duration_hours' => 6,
        'status' => 'published',
        'thumbnail' => $file,
    ]);

    $course = Course::where('title', 'Kingdom Leadership Masterclass')->first();

    expect($course)->not->toBeNull()
        ->and($course->status)->toBe('published')
        ->and($course->thumbnail)->not->toBeNull();

    $response->assertRedirect(route('admin.courses.lessons', $course->id));
});

test('admin can add a lesson with uploaded video file via CloudinaryService', function () {
    Storage::fake('public');

    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $course = Course::firstOrCreate(
        ['slug' => 'video-test-masterclass'],
        [
            'title' => 'Video Test Masterclass',
            'description' => 'Test course for video uploads',
            'level' => 'beginner',
            'duration_hours' => 2,
            'status' => 'published',
        ]
    );

    $videoFile = UploadedFile::fake()->create('lecture-1.mp4', 5000, 'video/mp4');

    $response = $this->actingAs($admin, 'admin')->post(route('admin.courses.lessons.store', $course->id), [
        'title' => 'Introduction & Welcome Session',
        'video_file' => $videoFile,
        'video_duration_minutes' => 12,
        'description' => 'First video lesson with Cloudinary hosting.',
    ]);

    $response->assertSessionHas('success');

    $lesson = $course->lessons()->where('title', 'Introduction & Welcome Session')->first();

    expect($lesson)->not->toBeNull()
        ->and($lesson->video_url)->not->toBeNull()
        ->and($lesson->embed_player_html)->toContain('<video');
});

test('admin can request dynamic signature for Cloudinary upload widget', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $response = $this->actingAs($admin, 'admin')->postJson(route('admin.cloudinary.sign'), [
        'params_to_sign' => [
            'folder' => 'courses/testing-coursec-two/videos',
            'source' => 'uw',
            'timestamp' => 1791628025,
        ],
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure(['signature']);
});

test('enrolled student can view course detail page even when course has zero lessons', function () {
    $student = User::where('email', 'student@lms.test')->first();
    $course = Course::create([
        'title' => 'Empty Curriculum Course',
        'slug' => 'empty-curriculum-course',
        'description' => 'A course without lessons yet',
        'level' => 'beginner',
        'duration_hours' => 1,
        'status' => 'published',
    ]);

    $student->enrollments()->create([
        'course_id' => $course->id,
        'enrolled_at' => now(),
        'status' => 'enrolled',
    ]);

    $response = $this->actingAs($student)->get(route('courses.show', $course->slug));

    $response->assertStatus(200);
    $response->assertSee('STUDENT DASHBOARD');
    $response->assertSee('Lessons will be published soon.');
});

test('admin can view courses list table and delete a course', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $course = Course::create([
        'title' => 'Course To Delete',
        'slug' => 'course-to-delete',
        'description' => 'Test course description',
        'level' => 'intermediate',
        'duration_hours' => 2,
        'status' => 'draft',
    ]);

    // View table
    $response = $this->actingAs($admin, 'admin')->get(route('admin.courses.index'));
    $response->assertStatus(200);
    $response->assertSee('All Courses List');
    $response->assertSee('Course To Delete');
    $response->assertSee('Add Course');

    // Delete course
    $deleteResponse = $this->actingAs($admin, 'admin')->delete(route('admin.courses.destroy', $course->id));
    $deleteResponse->assertRedirect(route('admin.courses.index'));
    $deleteResponse->assertSessionHas('success');

    $this->assertDatabaseMissing('courses', ['id' => $course->id]);
});

test('admin can view edit course page and update course details', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $course = Course::create([
        'title' => 'Original Course Title',
        'slug' => 'original-course-title',
        'description' => 'Original course description',
        'level' => 'beginner',
        'duration_hours' => 3,
        'status' => 'draft',
    ]);

    // View edit page
    $response = $this->actingAs($admin, 'admin')->get(route('admin.courses.edit', $course->id));
    $response->assertStatus(200);
    $response->assertSee('Edit Course');
    $response->assertSee('Original Course Title');

    // Update course
    $updateResponse = $this->actingAs($admin, 'admin')->put(route('admin.courses.update', $course->id), [
        'title' => 'Updated Course Title',
        'subtitle' => 'New Catchphrase',
        'description' => 'Updated full curriculum description',
        'level' => 'advanced',
        'duration_hours' => 6,
        'status' => 'published',
    ]);

    $updateResponse->assertRedirect(route('admin.courses.index'));
    $updateResponse->assertSessionHas('success');

    $this->assertDatabaseHas('courses', [
        'id' => $course->id,
        'title' => 'Updated Course Title',
        'level' => 'advanced',
        'duration_hours' => 6,
        'status' => 'published',
    ]);
});

test('admin can view quizzes index page', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $response = $this->actingAs($admin, 'admin')->get(route('admin.quizzes.index'));
    $response->assertStatus(200);
    $response->assertSee('Quizzes &amp; Assessments', false);
    $response->assertSee('Create Quiz');
});

test('admin can create a quiz and access builder', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );
    $course = Course::first();

    $response = $this->actingAs($admin, 'admin')->post(route('admin.quizzes.store'), [
        'course_id' => $course->id,
        'title' => 'Comprehensive Doctrine Final Exam',
        'description' => 'Test testing all modules',
        'pass_percentage' => 75,
        'time_limit_minutes' => 20,
    ]);

    $quiz = Quiz::where('title', 'Comprehensive Doctrine Final Exam')->first();
    expect($quiz)->not->toBeNull();
    expect($quiz->pass_percentage)->toBe(75);
    expect($quiz->time_limit_minutes)->toBe(20);

    $response->assertRedirect(route('admin.quizzes.builder', $quiz->id));

    // Access builder page
    $builderResponse = $this->actingAs($admin, 'admin')->get(route('admin.quizzes.builder', $quiz->id));
    $builderResponse->assertStatus(200);
    $builderResponse->assertSee('Comprehensive Doctrine Final Exam');
    $builderResponse->assertSee('Question Builder');
});

test('admin can add, edit, and delete questions with options and answer keys', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );
    $course = Course::first();
    $quiz = Quiz::create([
        'course_id' => $course->id,
        'title' => 'Salvation & Grace Quiz',
        'pass_percentage' => 80,
    ]);

    // 1. Store Question
    $storeResponse = $this->actingAs($admin, 'admin')->post(route('admin.quizzes.questions.store', $quiz->id), [
        'question' => 'How is a believer justified according to scripture?',
        'options' => [
            'By good works and charity',
            'Through faith in Jesus Christ alone',
            'By observing Jewish ceremonial laws',
            'Through personal human wisdom',
        ],
        'correct_answer_index' => 1,
        'explanation' => 'Romans 3:28 teaches justification by faith apart from the works of the law.',
        'sort_order' => 1,
    ]);

    $storeResponse->assertRedirect();
    $storeResponse->assertSessionHas('success');

    $question = QuizQuestion::where('quiz_id', $quiz->id)->first();
    expect($question)->not->toBeNull();
    expect($question->correct_answer_index)->toBe(1);
    expect($question->options)->toHaveCount(4);
    expect($question->options[1])->toBe('Through faith in Jesus Christ alone');

    // 2. Update Question
    $updateResponse = $this->actingAs($admin, 'admin')->put(route('admin.quizzes.questions.update', [$quiz->id, $question->id]), [
        'question' => 'How is a sinner justified before a holy God?',
        'options' => [
            'Through self-effort',
            'Through faith in Christ by grace',
            'By keeping commandments perfectly',
        ],
        'correct_answer_index' => 1,
        'explanation' => 'Ephesians 2:8-9.',
        'sort_order' => 1,
    ]);

    $updateResponse->assertRedirect();
    $updateResponse->assertSessionHas('success');

    $question->refresh();
    expect($question->question)->toBe('How is a sinner justified before a holy God?');
    expect($question->options)->toHaveCount(3);
    expect($question->options[1])->toBe('Through faith in Christ by grace');

    // 3. Delete Question
    $deleteResponse = $this->actingAs($admin, 'admin')->delete(route('admin.quizzes.questions.destroy', [$quiz->id, $question->id]));
    $deleteResponse->assertRedirect();
    $deleteResponse->assertSessionHas('success');

    expect(QuizQuestion::where('id', $question->id)->exists())->toBeFalse();
});

test('admin can view student quiz attempts', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );
    $course = Course::first();
    $quiz = Quiz::create([
        'course_id' => $course->id,
        'title' => 'Sample Assessment',
        'pass_percentage' => 70,
    ]);

    $response = $this->actingAs($admin, 'admin')->get(route('admin.quizzes.attempts', $quiz->id));
    $response->assertStatus(200);
    $response->assertSee('Student Results');
    $response->assertSee('Sample Assessment');
});

test('unauthenticated guest cannot access admin quizzes', function () {
    $response = $this->get(route('admin.quizzes.index'));
    $response->assertRedirect(route('admin.login'));
});

test('admin can view disciples and students directory with search and course filters', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $student = User::firstOrCreate(
        ['email' => 'disciple@example.com'],
        ['name' => 'Barnabas Learner', 'password' => bcrypt('password'), 'phone' => '08099887766']
    );

    $course = Course::first();
    Enrollment::firstOrCreate([
        'user_id' => $student->id,
        'course_id' => $course->id,
    ], [
        'status' => 'enrolled',
        'enrolled_at' => now(),
    ]);

    // 1. Visit index page
    $response = $this->actingAs($admin, 'admin')->get(route('admin.students.index'));
    $response->assertStatus(200);
    $response->assertSee('Disciples &amp; Students', false);
    $response->assertSee('Barnabas Learner');
    $response->assertSee('disciple@example.com');
    $response->assertSee('08099887766');

    // 2. Search filter
    $searchResponse = $this->actingAs($admin, 'admin')->get(route('admin.students.index', ['search' => 'Barnabas']));
    $searchResponse->assertStatus(200);
    $searchResponse->assertSee('Barnabas Learner');

    // 3. Course filter
    $filterResponse = $this->actingAs($admin, 'admin')->get(route('admin.students.index', ['course_id' => $course->id]));
    $filterResponse->assertStatus(200);
    $filterResponse->assertSee('Barnabas Learner');
});

test('admin can view issued certificates directory and revoke certificate', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $student = User::firstOrCreate(
        ['email' => 'graduated@example.com'],
        ['name' => 'Lydia Graduate', 'password' => bcrypt('password'), 'phone' => '08011223344']
    );

    $course = Course::first();
    $enrollment = Enrollment::firstOrCreate([
        'user_id' => $student->id,
        'course_id' => $course->id,
    ], [
        'status' => 'completed',
        'enrolled_at' => now()->subDays(10),
        'completed_at' => now(),
    ]);

    $certificate = Certificate::firstOrCreate([
        'enrollment_id' => $enrollment->id,
    ], [
        'certificate_number' => 'CERT-2026-TEST9999',
        'share_token' => 'test-token-grad-9999',
        'issued_at' => now(),
    ]);

    // 1. View certificates index
    $response = $this->actingAs($admin, 'admin')->get(route('admin.certificates.index'));
    $response->assertStatus(200);
    $response->assertSee('Issued Certificates');
    $response->assertSee('CERT-2026-TEST9999');
    $response->assertSee('Lydia Graduate');
    $response->assertSee(route('certificates.verify', 'test-token-grad-9999'));

    // 2. Search by cert number
    $searchResponse = $this->actingAs($admin, 'admin')->get(route('admin.certificates.index', ['search' => 'TEST9999']));
    $searchResponse->assertStatus(200);
    $searchResponse->assertSee('CERT-2026-TEST9999');

    // 3. Revoke certificate
    $deleteResponse = $this->actingAs($admin, 'admin')->delete(route('admin.certificates.destroy', $certificate->id));
    $deleteResponse->assertRedirect();
    $deleteResponse->assertSessionHas('success');

    expect(Certificate::where('id', $certificate->id)->exists())->toBeFalse();
});

test('unauthenticated guest cannot access admin disciples or certificates', function () {
    $this->get(route('admin.students.index'))->assertRedirect(route('admin.login'));
    $this->get(route('admin.certificates.index'))->assertRedirect(route('admin.login'));
});

test('about page renders dynamic active testimonials from database', function () {
    Testimonial::create([
        'name' => 'Hannah Faith',
        'designation' => 'Disciple at RACAi Global',
        'content' => 'This discipleship academy transformed my walk with the Lord!',
        'is_active' => true,
        'rating' => 5,
        'sort_order' => 1,
    ]);

    Testimonial::create([
        'name' => 'Hidden Reviewer',
        'designation' => 'Secret Member',
        'content' => 'This hidden review should not appear on the website.',
        'is_active' => false,
        'rating' => 4,
    ]);

    $response = $this->get(route('about'));
    $response->assertStatus(200);
    $response->assertSee('Hannah Faith');
    $response->assertSee('This discipleship academy transformed my walk with the Lord!');
    $response->assertDontSee('This hidden review should not appear on the website.');
});

test('admin can manage testimonials with CRUD and toggle status', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    // 1. Visit index page
    $response = $this->actingAs($admin, 'admin')->get(route('admin.testimonials.index'));
    $response->assertStatus(200);
    $response->assertSee('Website Testimonials');
    $response->assertSee('Add Testimonial');

    // 2. Create Testimonial
    $storeResponse = $this->actingAs($admin, 'admin')->post(route('admin.testimonials.store'), [
        'name' => 'Pastor David',
        'designation' => 'Lead Pastor at Grace Chapel',
        'content' => 'The curriculum is deep and rich in biblical doctrine.',
        'rating' => 5,
        'sort_order' => 1,
        'is_active' => 1,
    ]);
    $storeResponse->assertRedirect();
    $storeResponse->assertSessionHas('success');

    $testimonial = Testimonial::where('name', 'Pastor David')->first();
    expect($testimonial)->not->toBeNull();
    expect($testimonial->content)->toBe('The curriculum is deep and rich in biblical doctrine.');
    expect($testimonial->is_active)->toBeTrue();

    // 3. Update Testimonial
    $updateResponse = $this->actingAs($admin, 'admin')->put(route('admin.testimonials.update', $testimonial->id), [
        'name' => 'Pastor David Senior',
        'designation' => 'Senior Overseer at Grace Chapel',
        'content' => 'Updated review: Outstanding discipleship teachings.',
        'rating' => 5,
        'sort_order' => 2,
        'is_active' => 1,
    ]);
    $updateResponse->assertRedirect();
    $updateResponse->assertSessionHas('success');

    $testimonial->refresh();
    expect($testimonial->name)->toBe('Pastor David Senior');
    expect($testimonial->content)->toBe('Updated review: Outstanding discipleship teachings.');

    // 4. Toggle Status
    $toggleResponse = $this->actingAs($admin, 'admin')->patch(route('admin.testimonials.toggle', $testimonial->id));
    $toggleResponse->assertRedirect();
    $testimonial->refresh();
    expect($testimonial->is_active)->toBeFalse();

    // 5. Delete Testimonial
    $deleteResponse = $this->actingAs($admin, 'admin')->delete(route('admin.testimonials.destroy', $testimonial->id));
    $deleteResponse->assertRedirect();
    $deleteResponse->assertSessionHas('success');

    expect(Testimonial::where('id', $testimonial->id)->exists())->toBeFalse();
});

test('unauthenticated guest cannot access admin testimonials', function () {
    $this->get(route('admin.testimonials.index'))->assertRedirect(route('admin.login'));
});

test('contact page renders dynamic contact info from database', function () {
    $contact = ContactSetting::getSettings();
    $contact->update([
        'section_title' => 'Connect With Our Pastoral Team',
        'section_title_highlight' => 'For Divine Guidance',
        'form_title' => 'Send A Prayer Request',
        'form_subtitle' => 'We stand with you in agreement and faith.',
        'phone_primary' => '0809 111 2233',
        'phone_secondary' => '0809 444 5566',
        'email' => 'discipleship@racai.org',
        'address' => 'Grace Cathedral, Mission Road, Benin City, Nigeria',
        'weekday_hours' => '08:30 am - 4:30 pm',
        'weekend_hours' => '09:00 am - 12:00 pm',
        'whatsapp_number' => '+2348091112233',
    ]);

    $response = $this->get(route('contact'));
    $response->assertStatus(200);
    $response->assertSee('Connect With Our Pastoral Team');
    $response->assertSee('For Divine Guidance');
    $response->assertSee('Send A Prayer Request');
    $response->assertSee('We stand with you in agreement and faith.');
    $response->assertSee('0809 111 2233');
    $response->assertSee('tel:08091112233');
    $response->assertSee('0809 444 5566');
    $response->assertSee('discipleship@racai.org');
    $response->assertSee('Grace Cathedral, Mission Road, Benin City, Nigeria');
    $response->assertSee('08:30 am - 4:30 pm');
    $response->assertSee('09:00 am - 12:00 pm');
    $response->assertSee('+2348091112233');
});

test('about page renders dynamic about content and achievement counters from database', function () {
    $about = AboutSetting::getSettings();
    $about->update([
        'badge_title' => 'Kingdom Ministry',
        'heading_prefix' => 'Equipping Believers With Divine Mandate',
        'heading_highlight' => 'To Transform Generations',
        'description_1' => 'Our academy is rooted in deep spiritual discipleship.',
        'stat_projects_count' => '450',
        'stat_projects_label' => 'Ministers Ordained',
        'stat_students_count' => '900',
        'stat_students_label' => 'Active Disciples',
        'help_title' => 'Empowering Your',
        'help_title_highlight' => 'Spiritual Calling',
        'help_title_suffix' => 'Today',
        'feature_1_title' => 'Apostolic Doctrine',
        'feature_1_desc' => 'Pure uncompromised scriptural teachings for every believer.',
    ]);

    $response = $this->get(route('about'));
    $response->assertStatus(200);
    $response->assertSee('Kingdom Ministry');
    $response->assertSee('Equipping Believers With Divine Mandate');
    $response->assertSee('To Transform Generations');
    $response->assertSee('Our academy is rooted in deep spiritual discipleship.');
    $response->assertSee('450');
    $response->assertSee('Ministers Ordained');
    $response->assertSee('900');
    $response->assertSee('Active Disciples');
    $response->assertSee('Empowering Your');
    $response->assertSee('Spiritual Calling');
    $response->assertSee('Apostolic Doctrine');
    $response->assertSee('Pure uncompromised scriptural teachings for every believer.');
});

test('admin can view pages plugins hub and dedicated editors', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    // 1. Pages & Plugins Hub
    $hubResponse = $this->actingAs($admin, 'admin')->get(route('admin.pages.index'));
    $hubResponse->assertStatus(200);
    $hubResponse->assertSee('Pages &amp; Plugins Management', false);
    $hubResponse->assertSee('Contact Us Page');
    $hubResponse->assertSee('About Us Page');
    $hubResponse->assertSee('Student Testimonials');

    // 2. Contact Page Dedicated Editor
    $contactResponse = $this->actingAs($admin, 'admin')->get(route('admin.pages.contact'));
    $contactResponse->assertStatus(200);
    $contactResponse->assertSee('Contact Us Page Settings');
    $contactResponse->assertSee('Page Headings &amp; Titles', false);
    $contactResponse->assertSee('Phone &amp; Electronic Communication', false);
    $contactResponse->assertSee('Primary Mobile Phone');

    // 3. About Page Dedicated Editor
    $aboutResponse = $this->actingAs($admin, 'admin')->get(route('admin.pages.about'));
    $aboutResponse->assertStatus(200);
    $aboutResponse->assertSee('About Us Page Settings');
    $aboutResponse->assertSee('Hero Headlines &amp; Tagline', false);
    $aboutResponse->assertSee('Record Achievement Counters');
    $aboutResponse->assertSee('Ministry Pillars &amp; Help Section', false);
});

test('admin can update contact page settings', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $response = $this->actingAs($admin, 'admin')->put(route('admin.pages.contact.update'), [
        'section_title' => 'Get In Touch With Leadership',
        'section_title_highlight' => 'Across The Globe',
        'form_title' => 'Send Us An Inquiry',
        'form_subtitle' => 'Our team will respond within 24 hours.',
        'phone_primary' => '0812 333 4444',
        'phone_secondary' => '0812 555 6666',
        'email' => 'contact-updated@racai.org',
        'address' => 'Updated Sanctuary Road, Benin City, Nigeria',
        'weekday_hours' => '10:00 am - 4:00 pm',
        'weekend_hours' => '11:00 am - 2:00 pm',
        'whatsapp_number' => '+2348123334444',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $contact = ContactSetting::getSettings();
    expect($contact->section_title)->toBe('Get In Touch With Leadership');
    expect($contact->section_title_highlight)->toBe('Across The Globe');
    expect($contact->form_title)->toBe('Send Us An Inquiry');
    expect($contact->phone_primary)->toBe('0812 333 4444');
    expect($contact->email)->toBe('contact-updated@racai.org');
    expect($contact->address)->toBe('Updated Sanctuary Road, Benin City, Nigeria');
});

test('admin can update about page settings', function () {
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $response = $this->actingAs($admin, 'admin')->put(route('admin.pages.about.update'), [
        'badge_title' => 'Our Calling',
        'heading_prefix' => 'Empowered by the Holy Spirit',
        'heading_highlight' => 'For Kingdom Dominion',
        'description_1' => 'First paragraph about the calling and leadership academy.',
        'description_2' => 'Second paragraph describing discipleship journey.',
        'button_text' => 'JOIN ACADEMY',
        'button_link' => '/register',
        'stat_projects_count' => '350',
        'stat_projects_label' => 'Churches Planted',
        'stat_clients_count' => '500',
        'stat_clients_label' => 'Partners Blessed',
        'stat_students_count' => '1200',
        'stat_students_label' => 'Students Enrolled',
        'stat_years_count' => '25',
        'stat_years_label' => 'Years Apostolic Work',
        'help_title' => 'How We Equip',
        'help_title_highlight' => 'The Saints',
        'help_title_suffix' => 'Effectively',
        'feature_1_title' => 'Biblical Exegesis',
        'feature_1_desc' => 'Diving deep into sacred scriptures with prophetic clarity.',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $about = AboutSetting::getSettings();
    expect($about->badge_title)->toBe('Our Calling');
    expect($about->heading_prefix)->toBe('Empowered by the Holy Spirit');
    expect($about->stat_projects_count)->toBe('350');
    expect($about->stat_projects_label)->toBe('Churches Planted');
    expect($about->help_title)->toBe('How We Equip');
    expect($about->feature_1_title)->toBe('Biblical Exegesis');
});

test('unauthenticated guest cannot access admin pages CMS', function () {
    $this->get(route('admin.pages.index'))->assertRedirect(route('admin.login'));
    $this->get(route('admin.pages.contact'))->assertRedirect(route('admin.login'));
    $this->get(route('admin.pages.about'))->assertRedirect(route('admin.login'));
});

test('student milestone reward unlocks when earning 10 badges and can be claimed and fulfilled', function () {
    $student = User::factory()->create([
        'phone' => '08012345678',
        'whatsapp_opted_in' => true,
    ]);

    // Create 10 courses with enrollments and certificates
    for ($i = 1; $i <= 10; $i++) {
        $course = Course::create([
            'title' => "Masterclass {$i}",
            'slug' => "masterclass-{$i}",
            'level' => 'beginner',
            'duration_hours' => 2,
            'status' => 'published',
        ]);
        $enrollment = Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'completed',
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);
        Certificate::create([
            'enrollment_id' => $enrollment->id,
            'issued_at' => now(),
        ]);
    }

    // 1. Visit Student Dashboard to trigger milestone detection
    $response = $this->actingAs($student)->get(route('student.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Complete 10 Courses &amp; Earn 10 Badges', false);
    $response->assertSee('Claim Your 1-Month Free Data');

    // Reward record should now exist in database with 'unlocked' status
    $reward = DataReward::where('user_id', $student->id)->where('milestone_count', 10)->first();
    expect($reward)->not->toBeNull();
    expect($reward->status)->toBe('unlocked');
    expect($reward->isUnlocked())->toBeTrue();

    // 2. Student Claims Reward with Phone & Network
    $claimResponse = $this->actingAs($student)->post(route('student.rewards.claim', $reward->id), [
        'network_provider' => 'MTN',
        'phone_number' => '08098765432',
    ]);
    $claimResponse->assertRedirect();
    $claimResponse->assertSessionHas('success');

    $reward->refresh();
    expect($reward->status)->toBe('claimed');
    expect($reward->network_provider)->toBe('MTN');
    expect($reward->phone_number)->toBe('08098765432');
    expect($reward->isClaimed())->toBeTrue();

    // 3. Admin views rewards list
    $admin = Admin::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        ['name' => 'Admin User', 'password' => bcrypt('password'), 'phone' => '08012345678', 'role' => 'super-admin']
    );

    $adminIndexResponse = $this->actingAs($admin, 'admin')->get(route('admin.rewards.index'));
    $adminIndexResponse->assertStatus(200);
    $adminIndexResponse->assertSee('Data Subscription Rewards');
    $adminIndexResponse->assertSee($student->name);
    $adminIndexResponse->assertSee('08098765432');
    $adminIndexResponse->assertSee('MTN');

    // 4. Admin fulfills claim
    $fulfillResponse = $this->actingAs($admin, 'admin')->post(route('admin.rewards.fulfill', $reward->id), [
        'admin_notes' => 'VTU Reference #DATA102938 processed',
    ]);
    $fulfillResponse->assertRedirect();
    $fulfillResponse->assertSessionHas('success');

    $reward->refresh();
    expect($reward->status)->toBe('fulfilled');
    expect($reward->admin_notes)->toBe('VTU Reference #DATA102938 processed');
    expect($reward->fulfilled_at)->not->toBeNull();
    expect($reward->isFulfilled())->toBeTrue();

    // 5. Student Dashboard shows fulfilled state
    $dashboardAfter = $this->actingAs($student)->get(route('student.dashboard'));
    $dashboardAfter->assertStatus(200);
    $dashboardAfter->assertSee('Free Data Credited:');
    $dashboardAfter->assertSee('VTU Reference #DATA102938 processed');
});

test('unauthorized student cannot claim another students data reward', function () {
    $studentA = User::factory()->create();
    $studentB = User::factory()->create();

    $reward = DataReward::create([
        'user_id' => $studentA->id,
        'milestone_count' => 10,
        'reward_title' => '1 Month Free Data Subscription',
        'status' => 'unlocked',
    ]);

    $response = $this->actingAs($studentB)->post(route('student.rewards.claim', $reward->id), [
        'network_provider' => 'MTN',
        'phone_number' => '08011112222',
    ]);

    $response->assertStatus(403);
});

test('completing 10th course via lesson completion unlocks 10-badge data reward immediately', function () {
    $student = User::factory()->create([
        'phone' => '08055556666',
        'whatsapp_opted_in' => true,
    ]);

    // Give student 9 existing certificates
    for ($i = 1; $i <= 9; $i++) {
        $c = Course::create([
            'title' => "Prior Course {$i}",
            'slug' => "prior-course-{$i}",
            'level' => 'beginner',
            'duration_hours' => 2,
            'status' => 'published',
        ]);
        $enr = Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $c->id,
            'status' => 'completed',
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);
        Certificate::create([
            'enrollment_id' => $enr->id,
            'issued_at' => now(),
        ]);
    }

    // At 9 certificates, no reward unlocked yet
    expect(DataReward::where('user_id', $student->id)->exists())->toBeFalse();

    // Now enroll in 10th course with 1 lesson (no quiz)
    $tenthCourse = Course::create([
        'title' => 'Tenth Graduation Course',
        'slug' => 'tenth-graduation-course',
        'level' => 'beginner',
        'duration_hours' => 1,
        'status' => 'published',
    ]);
    $lesson = Lesson::create([
        'course_id' => $tenthCourse->id,
        'title' => 'Final Lesson',
        'slug' => 'final-lesson',
        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'video_duration_minutes' => 10,
        'sort_order' => 1,
    ]);
    $enrollment10 = Enrollment::create([
        'user_id' => $student->id,
        'course_id' => $tenthCourse->id,
        'status' => 'enrolled',
        'enrolled_at' => now(),
    ]);

    // Complete the final lesson
    $res = $this->actingAs($student)->post(route('student.lesson.complete', [$tenthCourse->slug, $lesson->slug]));
    $res->assertRedirect();

    // Student now has 10 certificates and DataReward is automatically created!
    expect(Certificate::whereHas('enrollment', fn ($q) => $q->where('user_id', $student->id))->count())->toBe(10);

    $reward = DataReward::where('user_id', $student->id)->where('milestone_count', 10)->first();
    expect($reward)->not->toBeNull();
    expect($reward->status)->toBe('unlocked');
});
