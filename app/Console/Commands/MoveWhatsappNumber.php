<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MoveWhatsappNumber extends Command
{
    protected $signature = 'move:whatsapp {--user_id=}';
    protected $description = 'Pindahkan whatsapp_number dari users ke user_details';

    public function handle()
    {
        $userId = $this->option('user_id');

        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();

            if (!$user) {
                $this->error("User dengan ID {$userId} tidak ditemukan.");
                return;
            }

            $this->moveWhatsapp($user);
            $this->info("Whatsapp number user ID {$userId} berhasil dipindahkan.");
        } else {
            $users = DB::table('users')->whereNotNull('whatsapp_number')->get();

            $bar = $this->output->createProgressBar(count($users));
            $bar->start();

            foreach ($users as $user) {
                $this->moveWhatsapp($user);
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info("Semua whatsapp_number berhasil dipindahkan.");
        }
    }

    private function moveWhatsapp($user)
    {
        DB::table('user_details')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'whatsapp_number' => $user->whatsapp_number,
                'updated_at' => now()
            ]
        );
    }
}
