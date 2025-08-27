<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure, WithCalculatedFormulas
{
    use SkipsFailures;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty($row['email']) || empty($row['name'])) {
                continue;
            }

            // Buat user baru atau ambil existing
            $user = User::firstOrCreate(
                ['email' => $row['email']],
                [
                    'name' => $row['name'],
                    'password' => Hash::make($row['password'] ?? 'password123'),
                ]
            );

            // Buat detail kalau ada
            if (!empty($row['whatsapp_number']) || !empty($row['tokopedia'])) {
                $user->detail()->updateOrCreate(
                    [],
                    [
                        'whatsapp_number' => $row['whatsapp_number'] ?? null,
                        'tokopedia' => $row['tokopedia'] ?? null,
                    ]
                );
            }

            // ✅ Assign Role
            if (!empty($row['roles'])) {
                // Misalnya roles di Excel: "admin,user"
                $roles = array_map('trim', explode(',', $row['roles']));
                $user->syncRoles($roles);
            }
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable',
            'whatsapp_number' => 'nullable',
            'tokopedia' => 'nullable|string|max:255',
        ];
    }
}
