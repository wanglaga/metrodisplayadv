<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('importUsers')
                ->label('Import Users')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('info')
                ->visible(fn() => auth()->user()->can('create_user')) // 👈 tambahkan ini
                ->form([
                    FileUpload::make('file')
                        ->label('File Excel')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                        ])
                        ->disk('public')
                        ->directory('imports')
                        ->storeFiles()
                        ->required(),
                ])
                ->action(function (array $data) {
                    // isi importmu tetap sama
                })
                ->action(function (array $data) {
                    try {
                        $import = new UsersImport();

                        // Ambil absolute path file dari disk public
                        $disk = Storage::disk('public');
                        $path = $disk->path($data['file']);

                        if (!$disk->exists($data['file'])) {
                            Notification::make()
                                ->title('File tidak ditemukan di storage/public/imports')
                                ->danger()
                                ->send();
                            return;
                        }

                        Excel::import($import, $path);

                        if (method_exists($import, 'failures') && $import->failures()->isNotEmpty()) {
                            foreach ($import->failures() as $failure) {
                                \Log::warning('Row gagal', [
                                    'row' => $failure->row(),
                                    'attribute' => $failure->attribute(),
                                    'errors' => $failure->errors(),
                                    'values' => $failure->values(),
                                ]);
                            }

                            Notification::make()
                                ->title('Beberapa baris gagal divalidasi, cek laravel.log')
                                ->danger()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Import berhasil!')
                                ->success()
                                ->send();
                        }
                    } catch (\Throwable $e) {
                        \Log::error('Excel import error', [
                            'message' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                        ]);

                        Notification::make()
                            ->title('Import gagal')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
