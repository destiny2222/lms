<?php

namespace App\Filament\Resources\Enrollments\Tables;

use App\Services\WhatsappService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EnrollmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('user.phone')
                    ->label('WhatsApp Phone')
                    ->searchable()
                    ->default('No phone'),
                TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->limit(25),
                TextColumn::make('progress_percentage')
                    ->label('Progress')
                    ->suffix('%')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 100 => 'success',
                        $state > 0 => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'in_progress' => 'warning',
                        default => 'info',
                    }),
                TextColumn::make('reminder_count')
                    ->label('Bot Reminders')
                    ->badge()
                    ->color('secondary'),
                TextColumn::make('deadline_at')
                    ->label('Deadline')
                    ->date('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'enrolled' => 'Enrolled',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                    ]),
            ])
            ->recordActions([
                Action::make('send_whatsapp')
                    ->label('Nudge WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Send WhatsApp Nudge')
                    ->modalDescription('Send an instant follow-up message to this student regarding their course progress.')
                    ->action(function ($record, WhatsappService $whatsapp) {
                        if (empty($record->user->phone)) {
                            Notification::make()->title('Student has no phone number')->danger()->send();

                            return;
                        }
                        if ($record->status === 'completed') {
                            $whatsapp->sendCompletionCongratulation($record);
                        } elseif ($record->hasStarted()) {
                            $whatsapp->sendIncompleteReminder($record);
                        } else {
                            $whatsapp->sendUnstartedReminder($record);
                        }
                        Notification::make()->title('WhatsApp reminder sent!')->success()->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
