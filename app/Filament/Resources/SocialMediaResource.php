<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialMediaResource\Pages;
use App\Filament\Resources\SocialMediaResource\RelationManagers;
use App\Models\SocialMedia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SocialMediaResource extends Resource
{
    protected static ?string $model = SocialMedia::class;

    protected static ?string $navigationIcon = 'heroicon-o-rss';

    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }

    public static function getNavigationSort(): ?int
    {
        return 8;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_sosmed')
                    ->label('Nama Sosial Media')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('icon')
                    ->label('Icon (class)')
                    ->placeholder('misal: fab fa-whatsapp')
                    ->maxLength(255),

                Forms\Components\TextInput::make('link')
                    ->label('Link')
                    ->required()
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->nullable()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('phone_number')
                    ->label('Nomor WhatsApp')
                    ->tel()
                    ->nullable()
                    ->columnSpanFull(),

            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_sosmed')
                    ->label('Nama')
                    ->searchable(),

                TextColumn::make('icon')
                    ->label('Icon')
                    ->formatStateUsing(fn($state) => "<i class=\"$state\"></i>")
                    ->html(),

                TextColumn::make('link')
                    ->label('Link')
                    ->limit(30),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('phone_number')
                    ->label('Nomor WA')
                    ->searchable(),

            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('id', 'asc');
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
            'index' => Pages\ListSocialMedia::route('/'),
            'create' => Pages\CreateSocialMedia::route('/create'),
            'edit' => Pages\EditSocialMedia::route('/{record}/edit'),
        ];
    }
}
