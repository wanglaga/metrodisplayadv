<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\QRCodeService;

class UserQrCodeController extends Controller
{
    protected QRCodeService $qr;

    public function __construct(QRCodeService $qr)
    {
        $this->qr = $qr;
    }

    public function show(User $user)
    {
        $url = url("/{$user->slug}");

        $qrcode = $this->qr->svg($url, 250);

        return response($qrcode)->header('Content-Type', 'image/svg+xml');
    }

    public function download(User $user)
    {
        $url = url("/{$user->slug}");

        $qrcode = $this->qr->svg($url, 300);

        $filename = str_replace(' ', '-', strtolower($user->name)) . '_qr.svg';

        return response($qrcode, 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

}
