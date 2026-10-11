<?php

namespace App\Filament\Resources\Quizzes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuizForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                Select::make('lesson_id')
                    ->relationship('lesson', 'title')
                    ->default(null),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('pass_percentage')
                    ->required()
                    ->numeric()
                    ->default(70),
                TextInput::make('time_limit_minutes')
                    ->numeric()
                    ->default(15),
            ]);
    }
}
