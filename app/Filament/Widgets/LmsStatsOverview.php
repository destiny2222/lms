<?php

namespace App\Filament\Widgets;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use App\Models\WhatsappMessage;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LmsStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalStudents = User::role('student')->count();
        $totalCourses = Course::where('status', 'published')->count();
        $totalCertificates = Certificate::count();
        $totalWhatsapp = WhatsappMessage::count();

        return [
            Stat::make('Registered Students', $totalStudents)
                ->description('Self-registered learners')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->chart([3, 5, 8, 12, 15, $totalStudents ?: 1]),

            Stat::make('Published Courses', $totalCourses)
                ->description('Authority Masterclasses')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('warning'),

            Stat::make('Certificates Issued', $totalCertificates)
                ->description('Verified digital badges')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success')
                ->chart([1, 2, 4, 6, $totalCertificates ?: 1]),

            Stat::make('WhatsApp Bot Activity', $totalWhatsapp)
                ->description('Automated follow-ups & replies')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('success'),
        ];
    }
}
