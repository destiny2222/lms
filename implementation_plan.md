# LMS Platform — Implementation Plan

## Overview

Build a full-featured Learning Management System (LMS) on top of the existing Laravel 13 skeleton. The platform has three user roles (Admin, Tutor, Student), supports video-based courses with quizzes, generates downloadable certification badges, and integrates a WhatsApp bot for automated follow-up reminders and bulk messaging.

---

## User Review & Decisions Confirmed

> [!NOTE]
> **Decisions confirmed by User:**
> - **WhatsApp Provider:** **Meta WhatsApp Cloud API directly** (No Twilio markups, 1,000 free monthly conversations, direct Meta Graph API calls via Laravel `Http`).
> - **Self-Registration:** Enabled for students (free enrollment).
> - **Social Sharing:** Direct sharing to LinkedIn, Twitter/X, and Facebook with Open Graph meta previews.
> - **Two-way Conversations:** Supported via Meta Webhook (students can reply, request next lesson, ask questions, or press interactive action buttons).
> - **Portal UI:** Building on the existing branded templates in `resources/views/frontend` (Jexi) and `resources/views/dash` (Edudash) for a state-of-the-art student and admin experience.
> - **Custom Certificate:** Custom branded template with QR code verification and downloadable badge/PDF.

---

## Open Questions

> [!NOTE]
> These don't block planning but will affect later implementation:
> - Will certificates need a **custom design** (logo, colors, brand)? Or a standard template is fine to start?
> - Should students be able to **self-register**, or does an Admin enroll them?
> - What social platforms should the **badge-share** flow support? (LinkedIn, Twitter/X, Facebook?)
> - Should the WhatsApp bot support **two-way conversations** (students can reply) or **one-way blasts only**?
> - Do you need **payment/checkout** for course enrollment?

---

## Proposed Architecture

```
┌─────────────────────────────────────────────────────┐
│                   Laravel 13 Backend                 │
│                                                      │
│  ┌──────────┐  ┌──────────┐  ┌───────────────────┐  │
│  │  Admin   │  │  Tutor   │  │     Student       │  │
│  │  Panel   │  │  Portal  │  │     Portal        │  │
│  └──────────┘  └──────────┘  └───────────────────┘  │
│                                                      │
│  ┌──────────────────────────────────────────────┐    │
│  │               Core Modules                  │    │
│  │  Courses · Lessons · Quizzes · Enrollments  │    │
│  │  Progress · Certificates · Notifications    │    │
│  └──────────────────────────────────────────────┘    │
│                                                      │
│  ┌──────────────────────────────────────────────┐    │
│  │            WhatsApp Bot Service              │    │
│  │  (Twilio/Meta) · Scheduled Jobs · Webhooks  │    │
│  └──────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────┘
```

---

## Proposed Changes

### Phase 1 — Database & Models

#### [NEW] Migrations (to be created with `php artisan make:migration`)

| Table | Key Columns |
|---|---|
| `users` *(extend existing)* | `role` (admin/tutor/student), `phone`, `whatsapp_opted_in` |
| `courses` | `id`, `tutor_id`, `title`, `description`, `thumbnail`, `status`, `published_at` |
| `lessons` | `id`, `course_id`, `title`, `description`, `video_url`, `video_provider`, `sort_order`, `duration_seconds` |
| `quizzes` | `id`, `lesson_id`, `title`, `pass_score` |
| `quiz_questions` | `id`, `quiz_id`, `question`, `options` (JSON), `correct_answer`, `sort_order` |
| `enrollments` | `id`, `student_id`, `course_id`, `enrolled_at`, `completed_at`, `deadline_at` |
| `lesson_progress` | `id`, `enrollment_id`, `lesson_id`, `watched_at`, `completed_at` |
| `quiz_attempts` | `id`, `enrollment_id`, `quiz_id`, `score`, `passed`, `attempted_at` |
| `certificates` | `id`, `enrollment_id`, `issued_at`, `badge_path`, `share_token` |
| `whatsapp_messages` | `id`, `user_id`, `type`, `body`, `sent_at`, `status` |

---

### Phase 2 — Models & Relationships

#### [MODIFY] [`User.php`](file:///Users/mac/Documents/lms/app/Models/User.php)
- Add `role` cast (enum: Admin, Tutor, Student)
- Add `phone`, `whatsapp_opted_in` attributes
- Add relationships: `enrollments()`, `tutoredCourses()`

#### [NEW] Models
- `Course`, `Lesson`, `Quiz`, `QuizQuestion`, `Enrollment`, `LessonProgress`, `QuizAttempt`, `Certificate`, `WhatsappMessage`

---

### Phase 3 — Authentication & Roles

- Laravel's built-in auth + **Spatie Laravel Permission** for role/permission management
- Three guards: `admin`, `tutor`, `student` (or single guard with role checks)
- Middleware: `EnsureRole::class` applied to route groups

---

### Phase 4 — Admin Panel

> Pending answer to admin panel question above.

**If Filament:** `composer require filament/filament` — Resources for Users, Courses, Lessons, Quizzes, Enrollments, Certificates.

**If custom:** API controllers + Blade/Inertia frontend.

---

### Phase 5 — Course & Lesson Management

#### Controllers (API + Web)
- `CourseController` — CRUD, publish/unpublish
- `LessonController` — CRUD, sort order, video upload/embed
- `QuizController` — CRUD questions, set pass score
- `EnrollmentController` — enroll student, view progress

#### Video Delivery
- Store only the video ID/URL (no raw file on server)
- Embed via provider's iframe/player SDK with download disabled
- Use signed/tokenized URLs if using Cloudflare Stream or Bunny.net

---

### Phase 6 — Student Portal

#### Controllers
- `StudentDashboardController` — enrolled courses, progress overview
- `LessonWatchController` — serve lesson (mark progress on completion)
- `QuizAttemptController` — submit quiz, check score, unlock next lesson
- `CertificateController` — issue certificate, generate badge image, share token

#### Progress & Unlock Logic
- Lessons unlock sequentially (complete lesson → watch next)
- Quiz must be passed (≥ pass_score) before next lesson unlocks
- Course marked complete when all lessons + quizzes passed → trigger certificate generation

---

### Phase 7 — Certification Badge

- Generate a styled PDF/image badge using **`barryvdh/laravel-dompdf`** or **`intervention/image`**
- Store in `storage/app/certificates/{student_id}/`
- Serve via signed URL (not publicly guessable)
- Share link generates a public, view-only page with Open Graph meta tags for:
  - LinkedIn, Twitter/X, Facebook

---

### Phase 8 — WhatsApp Bot Integration

#### [NEW] `app/Services/WhatsappService.php`
Wraps Twilio/Meta API calls:
- `sendMessage(string $phone, string $message): void`
- `sendBulk(Collection $users, string $message): void`

#### [NEW] `app/Jobs/`
| Job | Trigger |
|---|---|
| `SendCourseReminderJob` | Daily scheduled (Laravel Scheduler) |
| `SendLessonReminderJob` | When lesson deadline passes without progress |
| `SendCompletionCongratulationJob` | On course completion |
| `SendEnrollmentWelcomeJob` | On new enrollment |
| `SendBulkAnnouncementJob` | Admin-triggered manually |

#### [NEW] Webhook — `app/Http/Controllers/WhatsappWebhookController.php`
- Receives incoming messages (for two-way support if needed)
- Verifies signature from provider

#### Scheduler (in `routes/console.php`)
```php
Schedule::job(new SendCourseReminderJob)->dailyAt('09:00');
```

---

### Phase 9 — Notifications & Events

- Laravel Events + Listeners for: `CourseCompleted`, `LessonCompleted`, `QuizPassed`, `StudentEnrolled`
- Listeners dispatch WhatsApp jobs

---

## Tech Stack Summary

| Layer | Technology |
|---|---|
| Backend | Laravel 13 (PHP 8.5) |
| Admin Panel | Filament 3 *(pending confirmation)* |
| Auth & Roles | Laravel Auth + Spatie Laravel Permission |
| PDF/Badge | barryvdh/laravel-dompdf + intervention/image |
| Video | Cloudflare Stream / Bunny.net / Vimeo *(pending)* |
| WhatsApp | Twilio / Meta Cloud API *(pending)* |
| Queue | Laravel Queues (database driver → upgrade to Redis later) |
| Testing | Pest 5 |

---

## Verification Plan

### Automated Tests
```sh
php artisan test --compact
```
- Feature tests for enrollment flow
- Feature tests for quiz submission & pass/fail
- Feature tests for certificate issuance
- Feature tests for WhatsApp job dispatch (mocked)

### Manual Verification
- Admin can create a course with lessons and quizzes
- Student enrolls, watches video, takes quiz, gets certified
- Certificate badge downloads and share link works with OG meta tags
- WhatsApp reminder is sent when a student hasn't started a lesson by deadline
- Admin can trigger a bulk WhatsApp announcement

---

## Implementation Phases (Suggested Order)

1. ✅ Database migrations & models
2. ✅ Auth, roles & permissions
3. ✅ Course/lesson/quiz CRUD (Admin/Tutor)
4. ✅ Student enrollment & progress tracking
5. ✅ Video playback (provider integration)
6. ✅ Quiz engine
7. ✅ Certificate generation & sharing
8. ✅ WhatsApp bot service & scheduled jobs
9. ✅ Admin bulk messaging UI
10. ✅ Tests
