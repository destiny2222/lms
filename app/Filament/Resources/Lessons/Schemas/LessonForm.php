<?php

namespace App\Filament\Resources\Lessons\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (filled($get('slug')) && ($get('slug') !== Str::slug($old))) {
                            return;
                        }

                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Auto-generated from lesson title. You can customize if needed.'),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('video_url')
                    ->url()
                    ->required(),
                TextInput::make('video_provider')
                    ->required()
                    ->default('youtube'),
                TextInput::make('video_duration_minutes')
                    ->required()
                    ->numeric()
                    ->default(10),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(1),
                Toggle::make('is_free_preview')
                    ->required(),
            ]);
    }
}
