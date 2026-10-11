<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LmsCourseSeeder extends Seeder
{
    public function run(): void
    {
        $tutor = User::where('email', 'tutor@lms.test')->first() ?? User::first();
        $student = User::where('email', 'student@lms.test')->first() ?? User::latest()->first();

        // 1. Create Authority Course
        $course = Course::firstOrCreate(
            ['slug' => 'authority-to-buy-masterclass'],
            [
                'tutor_id' => $tutor->id,
                'title' => 'The Authority to Buy: Masterclass for Modern Learners',
                'subtitle' => 'Master buyer psychology, decision frameworks, and strategic buying power.',
                'description' => 'A comprehensive, step-by-step masterclass empowering learners with the fundamental principles of buying authority, consumer decision architectures, and institutional procurement strategy. Complete all video lessons and pass the final exam to earn your verified badge and official certificate.',
                'thumbnail' => 'assets/images/courses/course-image-1.jpg',
                'badge_image' => '/assets/images/badge-authority.png',
                'level' => 'intermediate',
                'duration_hours' => 6,
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        // 2. Create Lessons
        $lessonsData = [
            [
                'title' => 'Lesson 1: Foundations of Buyer Authority & Psychology',
                'description' => 'Explore what drives purchasing authority, understanding stakeholders, and navigating commercial decision gates.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Clean embed demonstration
                'video_provider' => 'youtube',
                'video_duration_minutes' => 15,
                'sort_order' => 1,
                'is_free_preview' => true,
            ],
            [
                'title' => 'Lesson 2: Decision Architectures & Evaluation Frameworks',
                'description' => 'In-depth analysis of how procurement committees weigh risk, ROI, and compliance.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'video_provider' => 'youtube',
                'video_duration_minutes' => 20,
                'sort_order' => 2,
                'is_free_preview' => false,
            ],
            [
                'title' => 'Lesson 3: Negotiation, Deal Closure, & Authority Execution',
                'description' => 'Practical strategies to finalize terms, align executive sponsors, and execute agreements.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'video_provider' => 'youtube',
                'video_duration_minutes' => 25,
                'sort_order' => 3,
                'is_free_preview' => false,
            ],
        ];

        $lessons = [];
        foreach ($lessonsData as $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course->id, 'sort_order' => $data['sort_order']],
                array_merge($data, ['slug' => Str::slug($data['title'])])
            );
            $lessons[] = $lesson;
        }

        // 3. Create Quiz for Lesson 1 (Test along the way)
        $lesson1Quiz = Quiz::updateOrCreate(
            ['course_id' => $course->id, 'lesson_id' => $lessons[0]->id],
            [
                'title' => 'Lesson 1 Knowledge Check: Buyer Psychology',
                'description' => 'Quick 3-question check on foundational authority concepts.',
                'pass_percentage' => 65,
                'time_limit_minutes' => 10,
            ]
        );

        QuizQuestion::updateOrCreate(
            ['quiz_id' => $lesson1Quiz->id, 'sort_order' => 1],
            [
                'question' => 'What is the primary indicator of buying authority in an organization?',
                'options' => [
                    'The size of the department',
                    'Direct budget signatory power and mandate',
                    'Years of tenure at the company',
                    'Social media followers',
                ],
                'correct_answer_index' => 1,
                'explanation' => 'Buying authority fundamentally stems from direct budget control and mandate.',
            ]
        );

        QuizQuestion::updateOrCreate(
            ['quiz_id' => $lesson1Quiz->id, 'sort_order' => 2],
            [
                'question' => 'Which stakeholder typically approves compliance and vendor risk?',
                'options' => [
                    'Operations team',
                    'Legal & Procurement committee',
                    'Interns',
                    'Sales team',
                ],
                'correct_answer_index' => 1,
                'explanation' => 'Legal and procurement committees review risk, governance, and contractual compliance.',
            ]
        );

        // 4. Create Final Course Exam (Certification Exam)
        $finalExam = Quiz::updateOrCreate(
            ['course_id' => $course->id, 'lesson_id' => null],
            [
                'title' => 'Authority to Buy: Final Certification Examination',
                'description' => 'Pass this comprehensive exam with 70% or higher to unlock your official Certificate of Completion and verifiable digital badge.',
                'pass_percentage' => 70,
                'time_limit_minutes' => 20,
            ]
        );

        $examQuestions = [
            [
                'question' => 'What is the key difference between an influencer and a decision-maker with buying authority?',
                'options' => [
                    'Influencers recommend options; decision-makers have final signing approval.',
                    'There is no difference.',
                    'Influencers manage the budget directly.',
                    'Decision-makers only attend meetings.',
                ],
                'correct_answer_index' => 0,
                'explanation' => 'Influencers guide opinions, but only authorities can obligate funds.',
                'sort_order' => 1,
            ],
            [
                'question' => 'When presenting ROI to an executive committee, what metric is most compelling?',
                'options' => [
                    'Color of the presentation deck',
                    'Quantified payback period and net risk reduction',
                    'Number of bullet points on the slide',
                    'Length of the demo',
                ],
                'correct_answer_index' => 1,
                'explanation' => 'Payback timeframe and risk mitigation directly answer executive concerns.',
                'sort_order' => 2,
            ],
            [
                'question' => 'What should be confirmed before entering contractual negotiations?',
                'options' => [
                    'The coffee order',
                    'Budget allocation, approval timeline, and signatory identity',
                    'The weather forecast',
                    'Competitor office locations',
                ],
                'correct_answer_index' => 1,
                'explanation' => 'Confirming budget, timeline, and signatories prevents stalled negotiations.',
                'sort_order' => 3,
            ],
        ];

        foreach ($examQuestions as $eq) {
            QuizQuestion::updateOrCreate(
                ['quiz_id' => $finalExam->id, 'sort_order' => $eq['sort_order']],
                $eq
            );
        }

        // 5. Seed sample student enrollment & certificate for demo/verification
        if ($student) {
            $enrollment = Enrollment::firstOrCreate(
                ['user_id' => $student->id, 'course_id' => $course->id],
                [
                    'enrolled_at' => now()->subDays(3),
                    'started_at' => now()->subDays(2),
                    'last_activity_at' => now()->subHours(4),
                    'deadline_at' => now()->addDays(14),
                    'status' => 'completed',
                    'completed_at' => now()->subHours(1),
                ]
            );

            // Mark lesson progress
            foreach ($lessons as $lesson) {
                LessonProgress::firstOrCreate(
                    ['enrollment_id' => $enrollment->id, 'lesson_id' => $lesson->id],
                    [
                        'is_completed' => true,
                        'watched_seconds' => $lesson->video_duration_minutes * 60,
                        'completed_at' => now()->subHours(2),
                    ]
                );
            }

            // Record passing exam attempt
            QuizAttempt::firstOrCreate(
                ['enrollment_id' => $enrollment->id, 'quiz_id' => $finalExam->id],
                [
                    'score_percentage' => 100,
                    'is_passed' => true,
                    'attempted_at' => now()->subHours(1),
                ]
            );

            // Issue official certificate
            Certificate::firstOrCreate(
                ['enrollment_id' => $enrollment->id],
                [
                    'certificate_number' => 'CERT-2026-ATB-9921',
                    'share_token' => 'atb-demo-'.Str::random(16),
                    'issued_at' => now()->subHours(1),
                ]
            );
        }

        // 5. Seed RACAi Platform Courses
        $racaiCourses = [
            [
                'slug' => 'foundations-of-faith-and-kingdom-living',
                'title' => 'Foundations of Faith & Kingdom Living',
                'subtitle' => 'Build an unshakeable biblical foundation in God\'s Word and everyday Christian walk.',
                'description' => 'A masterclass designed for believers seeking deeper roots in the Gospel. Understand the core doctrines of salvation, grace, faith, and the principles that govern victory in the Kingdom of God.',
                'thumbnail' => 'assets/images/courses/course-image-2.jpg',
                'badge_image' => '/assets/images/badge-authority.png',
                'level' => 'beginner',
                'duration_hours' => 8,
                'lessons' => [
                    ['title' => 'Understanding God\'s Eternal Purpose', 'duration' => 20, 'desc' => 'Discover the overarching plan of God through scripture.'],
                    ['title' => 'The Authority and Integrity of Scripture', 'duration' => 25, 'desc' => 'How to read, study, and live by God\'s Word consistently.'],
                    ['title' => 'Walking in Faith and Newness of Life', 'duration' => 20, 'desc' => 'Practical daily steps to walk in victory.'],
                ],
            ],
            [
                'slug' => 'spiritual-disciplines-and-daily-discipleship',
                'title' => 'Spiritual Disciplines & Daily Discipleship',
                'subtitle' => 'Cultivate deeper prayer life, scriptural study habits, and consistent spiritual maturity.',
                'description' => 'Discipleship goes beyond Sunday service. This practical course provides tools to establish a thriving devotional life, habitual scripture intake, fasting, and biblical accountability.',
                'thumbnail' => 'assets/images/courses/course-image-3.jpg',
                'badge_image' => '/assets/images/badge-authority.png',
                'level' => 'intermediate',
                'duration_hours' => 10,
                'lessons' => [
                    ['title' => 'The Heart of Prayer and Secret Place Intimacy', 'duration' => 25, 'desc' => 'Deepening your communion with the Holy Spirit.'],
                    ['title' => 'Systematic Bible Study and Meditation', 'duration' => 30, 'desc' => 'Transformational engagement with the living Word.'],
                    ['title' => 'Fasting, Consecration, and Spiritual Power', 'duration' => 20, 'desc' => 'Biblical principles of fasting and spiritual strength.'],
                ],
            ],
            [
                'slug' => 'kingdom-leadership-and-destiny-refining',
                'title' => 'Kingdom Leadership & Destiny Refining',
                'subtitle' => 'Discover your divine assignment, develop influence, and lead with godly excellence.',
                'description' => 'Equipping the next generation of Christian leaders. Learn how godly character, servant leadership, and clear vision empower you to influence society, the marketplace, and the local church.',
                'thumbnail' => 'assets/images/courses/course-image-4.jpg',
                'badge_image' => '/assets/images/badge-authority.png',
                'level' => 'advanced',
                'duration_hours' => 12,
                'lessons' => [
                    ['title' => 'Character: The Bedrock of Christian Leadership', 'duration' => 25, 'desc' => 'Developing the integrity that sustains divine elevation.'],
                    ['title' => 'Discovering and Refining Your Divine Calling', 'duration' => 30, 'desc' => 'Navigating seasons of preparation and destiny refinement.'],
                    ['title' => 'Leading Teams with Wisdom, Vision, and Grace', 'duration' => 25, 'desc' => 'Mobilizing others to fulfill God-given mandates.'],
                ],
            ],
            [
                'slug' => 'ministry-excellence-and-service-equipping',
                'title' => 'Ministry Excellence & Service Equipping',
                'subtitle' => 'Practical ministry tools and skills for ministers, church workers, and department leaders.',
                'description' => 'Refine your capacity to serve effectively within the church body. From pastoral care to volunteer leadership, acquire practical competencies that honor God and build up the assembly.',
                'thumbnail' => 'assets/images/courses/course-image-1.jpg',
                'badge_image' => '/assets/images/badge-authority.png',
                'level' => 'intermediate',
                'duration_hours' => 6,
                'lessons' => [
                    ['title' => 'The Heart of a Kingdom Servant', 'duration' => 20, 'desc' => 'Serving with humility, honor, and joy in God\'s house.'],
                    ['title' => 'Excellence in Departmental Coordination', 'duration' => 25, 'desc' => 'Practical workflows for church administration and events.'],
                    ['title' => 'Pastoral Care and Ministering to People', 'duration' => 20, 'desc' => 'Compassion, confidentiality, and spiritual readiness.'],
                ],
            ],
        ];

        foreach ($racaiCourses as $cData) {
            $lessonsList = $cData['lessons'];
            unset($cData['lessons']);

            $rCourse = Course::firstOrCreate(
                ['slug' => $cData['slug']],
                array_merge($cData, [
                    'tutor_id' => $tutor->id,
                    'status' => 'published',
                    'published_at' => now(),
                ])
            );

            foreach ($lessonsList as $idx => $lData) {
                Lesson::firstOrCreate(
                    ['course_id' => $rCourse->id, 'sort_order' => $idx + 1],
                    [
                        'title' => $lData['title'],
                        'slug' => Str::slug($lData['title']),
                        'description' => $lData['desc'],
                        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'video_provider' => 'youtube',
                        'video_duration_minutes' => $lData['duration'],
                        'is_free_preview' => $idx === 0,
                    ]
                );
            }
        }
    }
}
