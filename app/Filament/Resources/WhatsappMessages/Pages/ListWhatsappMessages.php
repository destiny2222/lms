<?php

namespace App\Filament\Resources\WhatsappMessages\Pages;

use App\Filament\Resources\WhatsappMessages\WhatsappMessageResource;
use App\Models\Course;
use App\Models\User;
use App\Services\WhatsappService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Artisan;

class ListWhatsappMessages extends ListRecords
{
    protected static string $resource = WhatsappMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('send_broadcast')
                ->label('Send Bulk WhatsApp Broadcast')
                ->icon('heroicon-o-megaphone')
                ->color('success')
                ->modalHeading('Broadcast WhatsApp Message to Students')
                ->form([
                    TextInput::make('title')
                        ->label('Announcement Title')
                        ->placeholder('e.g. Study Reminder / Live Q&A'),
                    Select::make('recipient_group')
                        ->label('Target Audience')
                        ->options([
                            'all_students' => 'All Registered Students (with WhatsApp phone)',
                            'course_students' => 'Students Enrolled in a Specific Course',
                            'custom_number' => 'Direct Test Number (Single Recipient)',
                        ])
                        ->default('all_students')
                        ->reactive()
                        ->required(),
                    Select::make('course_id')
                        ->label('Select Course')
                        ->options(Course::pluck('title', 'id'))
                        ->visible(fn ($get) => $get('recipient_group') === 'course_students'),
                    TextInput::make('custom_phone')
                        ->label('Recipient Phone Number')
                        ->placeholder('+12345678901 or 08012345678')
                        ->visible(fn ($get) => $get('recipient_group') === 'custom_number'),
                    Textarea::make('message')
                        ->label('Message Content')
                        ->rows(4)
                        ->required()
                        ->placeholder('Write your message. Students will receive this directly in their WhatsApp DM...'),
                ])
                ->action(function (array $data, WhatsappService $whatsapp) {
                    $message = $data['message'];
                    $title = $data['title'] ?? null;

                    if ($data['recipient_group'] === 'custom_number') {
                        if (empty($data['custom_phone'])) {
                            Notification::make()->title('Phone number required')->danger()->send();

                            return;
                        }
                        $whatsapp->sendTextMessage($data['custom_phone'], '📢 *'.($title ?? 'Announcement')."*\n\n".$message, null, 'bulk_announcement');
                        Notification::make()->title('Test WhatsApp message sent')->success()->send();

                        return;
                    }

                    if ($data['recipient_group'] === 'course_students' && ! empty($data['course_id'])) {
                        $users = User::whereHas('enrollments', function ($q) use ($data) {
                            $q->where('course_id', $data['course_id']);
                        })->whereNotNull('phone')->get();
                    } else {
                        $users = User::role('student')->whereNotNull('phone')->get();
                    }

                    if ($users->isEmpty()) {
                        Notification::make()->title('No students with registered phone numbers found.')->warning()->send();

                        return;
                    }

                    $count = $whatsapp->sendBulkAnnouncement($users, $message, $title);
                    Notification::make()
                        ->title("Broadcast dispatched to {$count} student(s) via WhatsApp!")
                        ->success()
                        ->send();
                }),

            Action::make('trigger_reminders')
                ->label('Run Daily Follow-Ups')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Execute Automated WhatsApp Follow-Up Cycle')
                ->modalDescription('This will search for students who have not started their course within 24h or have stalled on lessons, and send them WhatsApp reminders.')
                ->action(function () {
                    Artisan::call('lms:send-whatsapp-reminders');
                    $output = Artisan::output();

                    Notification::make()
                        ->title('WhatsApp Daily Routine Executed')
                        ->body(trim($output))
                        ->success()
                        ->send();
                }),

            CreateAction::make(),
        ];
    }
}
