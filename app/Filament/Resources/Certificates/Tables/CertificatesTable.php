<?php

namespace App\Filament\Resources\Certificates\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CertificatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('certificate_number')
                    ->label('Cert #')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),
                TextColumn::make('enrollment.user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('enrollment.course.title')
                    ->label('Course')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('issued_at')
                    ->label('Issued')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('verify')
                    ->label('View Badge')
                    ->icon('heroicon-o-shield-check')
                    ->color('warning')
                    ->url(fn ($record) => route('certificates.verify', $record->share_token))
                    ->openUrlInNewTab(),
                Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('gray')
                    ->url(fn ($record) => route('certificates.pdf', $record->id))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
