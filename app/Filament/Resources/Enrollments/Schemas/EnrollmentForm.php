<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                DateTimePicker::make('enrolled_at')
                    ->required(),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('last_activity_at'),
                DateTimePicker::make('completed_at'),
                DateTimePicker::make('deadline_at'),
                Select::make('status')
                    ->options(['enrolled' => 'Enrolled', 'in_progress' => 'In progress', 'completed' => 'Completed'])
                    ->default('enrolled')
                    ->required(),
                DateTimePicker::make('last_reminded_at'),
                TextInput::make('reminder_count')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
