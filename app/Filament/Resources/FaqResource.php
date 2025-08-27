<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Filament\Resources\FaqResource\RelationManagers;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function getNavigationLabel(): string
    {
        return 'FAQ';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Settings'; // atau ubah sesuai struktur sidebar-mu
    }

    public static function getNavigationSort(): ?int
    {
        return 7;
    }

    public static function getModelLabel(): string
    {
        return 'Frequently Asked Question';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Frequently Asked Questions';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->schema([
                    Textarea::make('question')
                        ->label('Pertanyaan')
                        ->hint('Tulis pertanyaan dengan jelas dan singkat.')
                        ->required()
                        ->rows(3)
                        ->maxLength(500),

                    RichEditor::make('answer')
                        ->label('Jawaban')
                        ->required()
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'underline',
                            'bulletList',
                            'orderedList',
                            'link',
                            'undo',
                            'redo',
                        ]),

                    Select::make('featured')
                        ->label('Tampilkan di Halaman Utama?')
                        ->options([
                            'Featured' => 'Featured',
                            'Not_Featured' => 'Not Featured',
                        ])
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->label('Pertanyaan')
                    ->limit(50)
                    ->searchable(),

                BadgeColumn::make('featured')
                    ->label('Status')
                    ->colors([
                        'success' => 'Featured',
                        'danger' => 'Not_Featured',
                    ])
                    ->formatStateUsing(fn(string $state) => str_replace('_', ' ', $state)), // Optional: tampilkan "Not Featured"
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
