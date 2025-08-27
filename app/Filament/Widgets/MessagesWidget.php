<?php

namespace App\Filament\Widgets;

use App\Models\Message;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class MessagesWidget extends BaseWidget
{
    protected static ?string $heading = 'Pesan Masuk Terbaru';
    protected int|string|array $columnSpan = 'full'; // Supaya lebar penuh di dashboard
    protected static ?int $sort = 3; // urutan tampil di dashboard
    protected function getTableQuery(): Builder|Relation|null
    {
        return Message::query()->latest()->limit(5);
    }
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Nama')
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->searchable(),
            Tables\Columns\TextColumn::make('phone_number')
                ->label('No. HP')   
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')->label('Waktu')->dateTime(),
        ];

    }
    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('Lihat Semua')
                ->label('Lihat Semua Pesan')
                ->url(route('filament.admin.resources.messages.index')) // ganti sesuai nama panel & resource
                ->color('primary')
                ->icon('heroicon-m-arrow-top-right-on-square'),
        ];
    }
    protected function getTableActions(): array
    {
        return [
            Action::make('read')
                ->label('Baca Pesan')
                ->icon('heroicon-m-eye')
                ->modalHeading('Detail Pesan')
                ->modalSubmitAction(false) // Tidak ada tombol submit
                ->modalCancelActionLabel('Tutup')
                ->modalContent(function ($record) {
                    return view('filament.resources.widgets.message-detail', [
                        'message' => $record,
                    ]);
                }),
        ];
    }
}
