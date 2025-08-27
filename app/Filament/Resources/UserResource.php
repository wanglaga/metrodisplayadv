<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ImportAction;
use App\Imports\UsersImport;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function getNavigationGroup(): ?string
    {
        return 'Management User';
    }

    public static function getNavigationSort(): ?int
    {
        return 1; // nilai kecil akan muncul lebih atas
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- Data User Utama ---
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                // Tambah select untuk role
                Forms\Components\Select::make('roles')
                    ->label('Role')
                    ->multiple() // kalau user bisa punya lebih dari satu role
                    ->relationship('roles', 'name') // langsung relasi spatie
                    ->preload()
                    ->searchable(),


                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn($context) => $context === 'create')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn($state) => !empty($state) ? bcrypt($state) : null)
                    ->dehydrated(fn($state) => filled($state)),

                // --- User Detail Section ---
                Forms\Components\Section::make('Detail Sosial Media')
                    ->schema([
                        Forms\Components\Group::make()
                            ->relationship('detail') // relasi one-to-one
                            ->schema([
                                Forms\Components\TextInput::make('whatsapp_number')
                                    ->label('WhatsApp Number')
                                    ->tel()
                                    ->prefix('+62')
                                    ->placeholder('81234567890'),

                                Forms\Components\TextInput::make('tokopedia')
                                    ->label('Link Tokopedia')
                                    ->url()
                                    ->placeholder('https://tokopedia.com/...'),

                                Forms\Components\TextInput::make('instagram')
                                    ->label('Link Instagram')
                                    ->url()
                                    ->placeholder('https://instagram.com/...'),

                                Forms\Components\TextInput::make('tiktok')
                                    ->label('Link TikTok')
                                    ->url()
                                    ->placeholder('https://tiktok.com/...'),

                                Forms\Components\TextInput::make('facebook')
                                    ->label('Link Facebook')
                                    ->url()
                                    ->placeholder('https://facebook.com/...'),
                            ])
                            ->columns(2),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('roles.name') // tampilkan role
                    ->badge()
                    ->colors([
                        'primary',
                        'success' => 'superadmin',
                        'warning' => 'admin',
                        'info' => 'user',
                    ]),
                Tables\Columns\TextColumn::make('detail.whatsapp_number')
                    ->label('WhatsApp')
                    ->formatStateUsing(fn($state) => $state ? '+62' . ltrim($state, '0') : '-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(UsersImport::class) // 🔥 ini penting
                    ->visible(fn() => auth()->user()->can('create_user')),
            ])
            ->filters([
                //
            ])


            ->actions([
                Tables\Actions\Action::make('detail')
                    ->label('Detail')
                    ->icon('heroicon-m-eye')
                    ->color('success')
                    ->modalHeading('Detail User')
                    ->modalSubheading(fn($record) => "Informasi lengkap untuk {$record->name}")
                    ->modalWidth('4xl')
                    ->modalContent(function ($record) {
                        // Pastikan relasi `detail` ikut dimuat
                        $record->loadMissing('detail');

                        return view('filament.resources.user-resource.view', [
                            'user' => $record,
                        ]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelAction(fn($action) => $action->label('Tutup')),

                Tables\Actions\EditAction::make()
                    ->color('primary'),

                Tables\Actions\DeleteAction::make()
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Hapus Terpilih')
                    ->color('danger'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
