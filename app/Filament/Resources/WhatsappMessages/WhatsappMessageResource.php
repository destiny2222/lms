<?php

namespace App\Filament\Resources\WhatsappMessages;

use App\Filament\Resources\WhatsappMessages\Pages\CreateWhatsappMessage;
use App\Filament\Resources\WhatsappMessages\Pages\EditWhatsappMessage;
use App\Filament\Resources\WhatsappMessages\Pages\ListWhatsappMessages;
use App\Filament\Resources\WhatsappMessages\Schemas\WhatsappMessageForm;
use App\Filament\Resources\WhatsappMessages\Tables\WhatsappMessagesTable;
use App\Models\WhatsappMessage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class WhatsappMessageResource extends Resource
{
    protected static ?string $model = WhatsappMessage::class;

    protected static string|UnitEnum|null $navigationGroup = 'Communications';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function getNavigationBadge(): ?string
    {
        return (string) WhatsappMessage::count();
    }

    public static function form(Schema $schema): Schema
    {
        return WhatsappMessageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WhatsappMessagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWhatsappMessages::route('/'),
            'create' => CreateWhatsappMessage::route('/create'),
            'edit' => EditWhatsappMessage::route('/{record}/edit'),
        ];
    }
}
