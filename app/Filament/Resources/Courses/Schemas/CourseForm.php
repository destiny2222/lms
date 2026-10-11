<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Models\Course;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tutor_id')
                    ->label('Instructor / Tutor')
                    ->relationship(
                        name: 'tutor',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->whereHas('roles', fn ($q) => $q->whereIn('name', ['tutor', 'admin']))
                    )
                    ->default(fn () => auth()->id())
                    ->searchable()
                    ->preload(),
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
                    ->unique(Course::class, 'slug', ignoreRecord: true)
                    ->helperText('Auto-generated from title. You can customize if needed.'),
                TextInput::make('subtitle')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('thumbnail')
                    ->default(null),
                FileUpload::make('badge_image')
                    ->image(),
                Select::make('level')
                    ->options(['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'])
                    ->default('beginner')
                    ->required(),
                TextInput::make('duration_hours')
                    ->required()
                    ->numeric()
                    ->default(1),
                Select::make('status')
                    ->options(['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'])
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
