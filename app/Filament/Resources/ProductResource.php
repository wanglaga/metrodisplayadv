<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\{ImageColumn, TextColumn, BadgeColumn};
use Filament\Tables\Table;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\{Wizard, Wizard\Step, Grid, TextInput, Select, RichEditor, Repeater, FileUpload, Toggle};
use Filament\Facades\Filament;
use Filament\Forms\Get;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    public static function getNavigationGroup(): ?string
    {
        return 'Management Product';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Filament::auth()->id();
        return $data;
    }

    public static function mutateFormDataBeforeUpdate(array $data): array
    {
        $data['user_id'] = Filament::auth()->id();
        return $data;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Informasi Produk')
                        ->schema([
                            Grid::make(3)->schema([
                                TextInput::make('nama_produk')->label('Nama Produk')->required(),
                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->options(fn() => \App\Models\Category::whereNull('parent_id')->pluck('nama_kategori', 'id')->toArray()),
                                Select::make('is_featured')
                                    ->label('Featured Product')
                                    ->options([1 => 'Featured', 0 => 'Not Featured'])
                                    ->default(0)
                                    ->required(),
                            ]),
                            Grid::make(2)->schema([
                                TextInput::make('stock')->label('Stock Product')->numeric()->required(),
                                Select::make('operating_system')
                                    ->label('Operating System')
                                    ->options(['Android' => 'Android', 'Windows' => 'Windows', 'Tidak Ada' => 'Tidak Ada'])
                                    ->required(),
                            ]),
                        ]),

                    Step::make('Varian & Spesifikasi')
                        ->schema([
                            Repeater::make('spesifikasi')
                                ->label('Daftar Varian')
                                ->cloneable()
                                ->orderable()
                                ->collapsible()
                                ->addActionLabel('+ Tambah Ukuran/Type')
                                ->schema([
                                    TextInput::make('type')->label('Ukuran')->required(),
                                    TextInput::make('harga')->label('Harga')->numeric()->required(),
                                    Repeater::make('spesifikasi')
                                        ->label('Spesifikasi Detail')
                                        ->orderable()
                                        ->collapsible()
                                        ->addActionLabel('+ Tambah Spesifikasi')
                                        ->schema([
                                            Grid::make(2)->schema([
                                                TextInput::make('label')->label('Nama')->required(),
                                                TextInput::make('value')->label('Nilai')->required(),
                                                Toggle::make('featured')
                                                    ->label('Featured')
                                                    ->inline(false)
                                                    ->default(false),
                                            ]),
                                        ]),
                                ]),
                        ]),

                    Step::make('Deskripsi Produk')
                        ->schema([
                            RichEditor::make('mini_deskripsi')->label('Mini Deskripsi')->columnSpanFull(),
                            RichEditor::make('deskripsi')->label('Deskripsi')->columnSpanFull(),
                        ]),

                    Step::make('YouTube')
                        ->schema([
                            TextInput::make('youtube_link')
                                ->label('Paste link YouTube di bawah')
                                ->placeholder('https://www.youtube.com/watch?v=xxxx')
                                ->url()
                                ->nullable()
                                ->columnSpanFull(),
                        ]),

                    Step::make('Gambar Produk')
                        ->schema([
                            Grid::make(2)->schema([
                                FileUpload::make('main_image')
                                    ->label('Main Image')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('product-images')
                                    ->required(),
                                FileUpload::make('thumbnails')
                                    ->label('Thumbnail Images')
                                    ->multiple()
                                    ->image()
                                    ->imageEditor()
                                    ->directory('product-thumbnails'),
                            ]),
                        ]),
                ])
                    // hanya bisa lompat step kalau sedang EDIT
                    ->skippable(fn() => request()->routeIs('filament.resources.products.edit'))
            ])
            ->columns(1)
            ->statePath('data');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('main_image')->label('Gambar')->square()->width(60)->height(60),
                TextColumn::make('nama_produk')->searchable()->sortable(),
                TextColumn::make('category.nama_kategori')->label('Kategori')->sortable(),
                BadgeColumn::make('is_featured')
                    ->label('Featured')
                    ->formatStateUsing(fn(bool $state) => $state ? 'Featured' : 'Not Featured')
                    ->colors(['success' => fn($state) => $state === true, 'danger' => fn($state) => $state === false]),
                TextColumn::make('harga')->money('IDR', true)->sortable(),
            ])
            ->actions([
                TableAction::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->action(fn(Product $record, $livewire) => $livewire->mountActionData(['recordId' => $record->id]))
                    ->modalHeading('Detail Produk')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->slideOver()
                    ->modalContent(fn($record) => view('filament.resources.product-resource.view', ['record' => $record]))
                    ->viewData(fn(Product $record) => ['record' => $record]),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
