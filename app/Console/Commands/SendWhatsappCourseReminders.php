<?php

namespace App\Console\Commands;

use App\Models\Enrollment;
use App\Services\WhatsappService;
use Illuminate\Console\Command;

class SendWhatsappCourseReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lms:send-whatsapp-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automated WhatsApp reminders to students for unstarted courses and incomplete lessons';

    /**
     * Execute the console command.
     */
    public function handle(WhatsappService $whatsapp): int
    {
        $this->info('Starting automated WhatsApp course follow-up run...');

        $unstartedCount = 0;
        $incompleteCount = 0;

        // 1. Find unstarted enrollments (enrolled >= 1 day ago, never started, not reminded today)
        $unstarted = Enrollment::with(['user', 'course'])
            ->whereNull('started_at')
            ->where('status', '!=', 'completed')
            ->where('enrolled_at', '<=', now()->subHours(24))
            ->where(function ($q) {
                $q->whereNull('last_reminded_at')
                    ->orWhere('last_reminded_at', '<=', now()->subHours(24));
            })
            ->get();

        foreach ($unstarted as $enrollment) {
            $whatsapp->sendUnstartedReminder($enrollment);
            $unstartedCount++;
        }

        // 2. Find incomplete enrollments that have stalled (started, but no activity in 2+ days, not reminded in past 48h)
        $incomplete = Enrollment::with(['user', 'course'])
            ->whereNotNull('started_at')
            ->where('status', '!=', 'completed')
            ->where('last_activity_at', '<=', now()->subDays(2))
            ->where(function ($q) {
                $q->whereNull('last_reminded_at')
                    ->orWhere('last_reminded_at', '<=', now()->subDays(2));
            })
            ->get();

        foreach ($incomplete as $enrollment) {
            $whatsapp->sendIncompleteReminder($enrollment);
            $incompleteCount++;
        }

        $this->info("Completed WhatsApp run: {$unstartedCount} unstarted reminders, {$incompleteCount} incomplete reminders sent.");

        return Command::SUCCESS;
    }
}
