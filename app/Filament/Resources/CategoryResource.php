<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Management Product';
    }

    public static function getNavigationSort(): ?int
    {
        return 3; // nilai kecil akan muncul lebih atas
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_kategori')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        if (blank($get('slug'))) {
                            $set('slug', Str::slug($state));
                        }
                    }),

                Select::make('parent_id')
                    ->label('Parent Kategori')
                    ->options(function () {
                        return \App\Models\Category::pluck('nama_kategori', 'id')->toArray();
                    })
                    ->searchable()
                    ->nullable()
                    ->helperText('Pilih kategori induk, bisa dikosongkan jika ini kategori utama'),
                FileUpload::make('image')
                    ->label('Gambar Kategori')
                    ->directory('categories') // simpan di storage/app/public/categories
                    ->image()
                    ->imagePreviewHeight('150')
                    ->maxSize(1024) // maksimal 1MB
                    ->deleteUploadedFileUsing(function ($file, $record) {
                        // Hapus gambar lama saat edit
                        if ($record && $record->image && Storage::disk('public')->exists($record->image)) {
                            Storage::disk('public')->delete($record->image);
                        }
                    })
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public') 
                    ->height(50)     
                    ->width(50)     
                    ->circular(),    

                TextColumn::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),

                TextColumn::make('parent.nama_kategori')
                    ->label('Parent Kategori')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
