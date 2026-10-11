<?php

namespace App\Filament\Resources\WhatsappMessages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WhatsappMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime('M d, H:i')
                    ->sortable(),
                TextColumn::make('direction')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'outbound' => 'info',
                        'inbound' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('phone_number')
                    ->label('Phone')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->default('External'),
                TextColumn::make('trigger_type')
                    ->label('Trigger')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'reminder_unstarted', 'reminder_incomplete' => 'warning',
                        'congratulation' => 'success',
                        'bulk_announcement' => 'primary',
                        'bot_reply' => 'gray',
                        default => 'secondary',
                    }),
                TextColumn::make('message_body')
                    ->label('Message')
                    ->limit(55)
                    ->tooltip(fn ($record) => $record->message_body)
                    ->wrap(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'sent', 'delivered', 'read' => 'success',
                        'failed' => 'danger',
                        default => 'warning',
                    }),
            ])
            ->filters([
                SelectFilter::make('direction')
                    ->options([
                        'outbound' => 'Outbound',
                        'inbound' => 'Inbound',
                    ]),
                SelectFilter::make('trigger_type')
                    ->options([
                        'reminder_unstarted' => 'Reminder: Unstarted',
                        'reminder_incomplete' => 'Reminder: Incomplete',
                        'congratulation' => 'Congratulation',
                        'bulk_announcement' => 'Bulk Announcement',
                        'bot_reply' => 'Bot Reply',
                        'user_message' => 'User Message',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
