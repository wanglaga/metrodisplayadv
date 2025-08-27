<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShippingResource\Pages;
use App\Filament\Resources\ShippingResource\RelationManagers;
use App\Models\Shipping;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShippingResource extends Resource
{
    protected static ?string $model = Shipping::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }
    public static function getNavigationSort(): ?int
    {
        return 9;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_shipping')
                    ->label('Nama Shipping')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('is_featured')
                    ->label('Featured')
                    ->options([
                        1 => 'Featured',
                        0 => 'Not Featured',
                    ])
                    ->default(0)
                    ->required(),

                Forms\Components\FileUpload::make('img')
                    ->label('Logo / Gambar')
                    ->image()
                    ->directory('shippings')
                    ->visibility('public'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('img')
                    ->label('Logo')
                    ->square()
                    ->width(100),
                Tables\Columns\TextColumn::make('nama_shipping')->label('Nama Shipping')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('is_featured')
                    ->label('Featured')
                    ->getStateUsing(fn($record) => $record->is_featured ? 'Featured' : 'Not Featured')
                    ->colors([
                        'success' => fn($state) => $state === 'Featured', // hijau
                        'secondary' => fn($state) => $state === 'Not Featured', // abu-abu
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')->label('Diubah')->dateTime('d M Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListShippings::route('/'),
            'create' => Pages\CreateShipping::route('/create'),
            'edit' => Pages\EditShipping::route('/{record}/edit'),
        ];
    }
}
