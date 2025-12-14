<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Instrument;
use App\Models\Question;
use App\Services\ScreeningService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DummyScreeningSeeder extends Seeder
{
    public function run(ScreeningService $screeningService): void
    {
        $faker = Faker::create('id_ID');

        // 1. SIAPKAN DATA USER (Bikin 3 User Dummy Baru)
        // Kita buat array email agar gampang dilacak
        $emails = ['user1@test.com', 'user2@test.com', 'user3@test.com', 'user4@test.com'];
        $targetUsers = [];

        foreach ($emails as $email) {
            // Cek dulu, kalau belum ada buat baru
            $u = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $faker->name,
                    'password' => Hash::make('password'),
                    'role' => 'masyarakat',
                    'superiority_role' => $faker->randomElement(['Ayah', 'Ibu']),
                    'email_verified_at' => now(),
                ]
            );
            $targetUsers[] = $u;
        }

        // 2. SIAPKAN MASTER DATA (Instrumen & Soal)
        $insFather = Instrument::where('code', 'FPQ')->first();
        $insMother = Instrument::where('code', 'MCIQ')->first();
        $insOther  = Instrument::where('code', 'FMWB')->first();

        if (!$insFather || !$insMother || !$insOther) {
            $this->command->error('Master data instrumen belum ada. Jalankan DatabaseSeeder utama dulu!');
            return;
        }

        $fpqIds  = Question::where('id_instrument', $insFather->id)->pluck('id')->toArray();
        $mciqIds = Question::where('id_instrument', $insMother->id)->pluck('id')->toArray();
        $fmwbIds = Question::where('id_instrument', $insOther->id)->pluck('id')->toArray();
        $locations = ['Rumah Sidoarjo', 'Kampus', 'Cafe', 'Kost', 'Rumah Nenek'];

        $this->command->info('--- Memulai Generator Data Skrining untuk ' . count($targetUsers) . ' User ---');

        // 3. LOOPING USER
        foreach ($targetUsers as $user) {
            
            $this->command->info(">> Memproses User: {$user->name} ({$user->email})");
            
            // Login-kan user agar Service bisa membaca Auth::user()
            Auth::login($user);

            // LOOPING SKRINING (Misal tiap user punya 3 data)
            for ($i = 1; $i <= 50; $i++) {
                
                // Generate Jawaban
                $fatherAnswers = [];
                foreach ($fpqIds as $id) $fatherAnswers[$id] = rand(0, 4);

                $motherAnswers = [];
                foreach ($mciqIds as $id) $motherAnswers[$id] = rand(0, 4);

                $otherAnswers = [];
                foreach ($fmwbIds as $id) $otherAnswers[$id] = rand(1, 10);

                $biodata = [
                    'lokasi_name' => $faker->randomElement($locations),
                    'tanggal'     => now()->subDays(rand(1, 60))->format('Y-m-d'),
                ];

                try {
                    $screening = $screeningService->calculateAndSave(
                        $biodata, $fatherAnswers, $motherAnswers, $otherAnswers
                    );

                    // Random Status
                    $status = $faker->randomElement(['saved', 'preview']);
                    
                    $screening->update([
                        'status' => $status,
                        'created_at' => now()->subDays(rand(1, 60))
                    ]);

                } catch (\Exception $e) {
                    // Skip error biar loop lanjut
                }
            }
        }
        
        $this->command->info('--- Selesai Generate Data ---');
    }
}