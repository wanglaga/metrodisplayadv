<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PriceListResource\Pages;
use App\Models\PriceList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PriceListResource extends Resource
{
    protected static ?string $model = PriceList::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';
    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }
    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pricelist')
                    ->required(),

                Forms\Components\FileUpload::make('file_pdf')
                    ->label('Upload PDF')
                    ->disk('public')
                    ->directory('pricelists')
                    ->visibility('public')
                    ->maxSize(10240)
                    ->acceptedFileTypes(['application/pdf'])
                    ->helperText(fn($state, $record) => $record && $record->file_pdf ? "File saat ini: " . $record->file_pdf : null),


                Forms\Components\Select::make('is_featured')
                    ->label('Featured')
                    ->options([
                        1 => 'Featured',
                        0 => 'Not Featured',
                    ])
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_pricelist'),
                Tables\Columns\TextColumn::make('file_pdf')->label('PDF File'),
                Tables\Columns\BadgeColumn::make('is_featured')
                    ->label('Featured')
                    ->getStateUsing(fn($record) => $record->is_featured ? 'Featured' : 'Not Featured')
                    ->colors([
                        'success' => fn($state) => $state === 'Featured', // hijau
                        'warning' => fn($state) => $state === 'Not Featured', // abu-abu
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->defaultSort('is_featured', 'desc') // <-- featured selalu di atas
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPriceLists::route('/'),
            'create' => Pages\CreatePriceList::route('/create'),
            'edit' => Pages\EditPriceList::route('/{record}/edit'),
        ];
    }
}
