<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Filament\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function getNavigationLabel(): string
    {
        return 'Pesan Masuk';
    }

    public static function canCreate(): bool
    {
        return false; // Matikan tombol create
    }
    public static function getNavigationBadge(): ?string
    {
        return (string) Message::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->disabled()->label('Nama'),
                Forms\Components\TextInput::make('email')->email()->disabled(),
                Forms\Components\Textarea::make('content')->disabled()->label('Pesan'),
                Forms\Components\DateTimePicker::make('created_at')->disabled()->label('Diterima'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('phone_number')->label('Phone Number'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Diterima'),
            ])
            ->filters([
                Filter::make('search_query')
                    ->form([
                        Forms\Components\TextInput::make('search_query')
                            ->live()
                            ->label('Cari Pesan / Nama / Email'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['search_query'] ?? null,
                            fn($query, $search) => $query->where(function ($query) use ($search) {
                                $query->where('name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%")
                                    ->orWhere('content', 'like', "%{$search}%");
                            })
                        );
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([]) // Hapus semua tombol header (termasuk Create)
            ->actions([
                Tables\Actions\Action::make('baca')
                    ->label('Baca Pesan')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalHeading('Detail Pesan')
                    ->modalContent(function ($record) {
                        return view('filament.resources.widgets.message-detail', [
                            'message' => $record,
                        ]);
                    })
                    ->modalSubmitAction(false) // ❌ Hilangkan tombol submit
                    ->modalCancelActionLabel('Tutup')
                    ->modalWidth('2xl'),

                Tables\Actions\DeleteAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->recordUrl(null);

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
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
