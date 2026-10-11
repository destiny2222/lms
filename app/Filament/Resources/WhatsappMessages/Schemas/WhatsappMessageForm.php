<?php

namespace App\Filament\Resources\WhatsappMessages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WhatsappMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(null),
                Select::make('direction')
                    ->options(['outbound' => 'Outbound', 'inbound' => 'Inbound'])
                    ->default('outbound')
                    ->required(),
                TextInput::make('phone_number')
                    ->tel()
                    ->required(),
                TextInput::make('message_type')
                    ->required()
                    ->default('text'),
                Textarea::make('message_body')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('meta_message_id')
                    ->default(null),
                TextInput::make('trigger_type')
                    ->required()
                    ->default('reminder'),
                TextInput::make('status')
                    ->required()
                    ->default('sent'),
                Textarea::make('error_message')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
