<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;



class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'My Profile';

    public static function getNavigationGroup(): ?string
    {
        return 'Management User';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    protected static string $view = 'filament.pages.profile';

    public ?array $data = [];
    public $user; // <-- penting, supaya bisa dipakai di save()

    public function mount(): void
    {
        $this->user = Auth::user(); // <-- isi user login

        if (!$this->user) {
            abort(403, 'You must be logged in.');
        }

        $this->form->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'whatsapp_number' => $this->user->whatsapp_number,
            'tokopedia' => $this->user->detail->tokopedia ?? null,
            'instagram' => $this->user->detail->instagram ?? null,
            'tiktok' => $this->user->detail->tiktok ?? null,
            'facebook' => $this->user->detail->facebook ?? null,
        ]);
    }

    public function form(Form $form): Form
    {
        $user = auth()->user();
        $qr = app(\App\Services\QRCodeService::class)->svg(url('/' . $user->slug), 120);

        return $form
            ->schema([
                Forms\Components\Tabs::make('ProfileTabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('My Profile')
                            ->schema([
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        // Kolom QR
                                        Forms\Components\ViewField::make('qr_code')
                                            ->columnSpan(1)
                                            ->view('components.qr-code-profile', [
                                                'qr' => $qr,
                                                'user' => $user,
                                            ]),

                                        // Kolom data user
                                        Forms\Components\Group::make([
                                            Forms\Components\TextInput::make('name')
                                                ->required()
                                                ->maxLength(255),

                                            Forms\Components\TextInput::make('email')
                                                ->email()
                                                ->required()
                                                ->maxLength(255),

                                            Forms\Components\TextInput::make('whatsapp_number')
                                                ->label('WhatsApp Number')
                                                ->tel()
                                                ->prefix('+62')
                                                ->placeholder('81234567890'),
                                        ])->columnSpan(2),
                                    ]),

                                Forms\Components\Section::make('Detail Sosial Media')
                                    ->schema([
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
                            ]),

                        Forms\Components\Tabs\Tab::make('Change Password')
                            ->schema([
                                Forms\Components\TextInput::make('current_password')
                                    ->password()
                                    ->label('Current Password'),

                                Forms\Components\TextInput::make('new_password')
                                    ->password()
                                    ->label('New Password'),

                                Forms\Components\TextInput::make('new_password_confirmation')
                                    ->password()
                                    ->label('Confirm New Password')
                                    ->same('new_password'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // ========== My Profile Update ==========
        $this->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'whatsapp_number' => $data['whatsapp_number'],
            'slug' => Str::slug($data['name']), // ✅ sudah dikenali
        ]);

        $this->user->detail()->updateOrCreate(
            ['user_id' => $this->user->id],
            [
                'tokopedia' => $data['tokopedia'] ?? null,
                'instagram' => $data['instagram'] ?? null,
                'tiktok' => $data['tiktok'] ?? null,
                'facebook' => $data['facebook'] ?? null,
            ]
        );

        // ========== Change Password ==========
        if (!empty($data['current_password']) && !empty($data['new_password'])) {
            if (!Hash::check($data['current_password'], $this->user->password)) {
                Notification::make()
                    ->danger()
                    ->title('Current password is incorrect.')
                    ->send();

                return;
            }

            $this->user->update([
                'password' => bcrypt($data['new_password']),
            ]);

            // 🔑 Kosongkan field password setelah berhasil
            $this->form->fill([
                'current_password' => null,
                'new_password' => null,
                'new_password_confirmation' => null,
                // tetap isi ulang field profil biar tidak kosong
                'name' => $this->user->name,
                'email' => $this->user->email,
                'whatsapp_number' => $this->user->whatsapp_number,
                'tokopedia' => $this->user->detail->tokopedia ?? null,
                'instagram' => $this->user->detail->instagram ?? null,
                'tiktok' => $this->user->detail->tiktok ?? null,
                'facebook' => $this->user->detail->facebook ?? null,
            ]);
        }

        Notification::make()
            ->success()
            ->title('Profile updated successfully!')
            ->send();
    }

}
