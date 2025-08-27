<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitLogResource\Pages;
use App\Filament\Resources\VisitLogResource\RelationManagers;
use App\Models\VisitLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitLogResource extends Resource
{
    protected static ?string $model = VisitLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationGroup = 'Management User';

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function canCreate(): bool
    {
        return false; // Matikan tombol create
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('ip_address')->label('IP'),
                Tables\Columns\TextColumn::make('user_agent')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Waktu')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([]) // Hapus semua tombol header (termasuk Create)
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->recordUrl(null) // Hapus link edit dari tabel
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ]);
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
            'index' => Pages\ListVisitLogs::route('/'),
            'create' => Pages\CreateVisitLog::route('/create'),
            'edit' => Pages\EditVisitLog::route('/{record}/edit'),
        ];
    }
}
