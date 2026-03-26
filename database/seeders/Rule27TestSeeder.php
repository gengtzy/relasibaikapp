<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Screening;
use App\Models\ScreeningResult;
use App\Models\Recommendation;
use Illuminate\Support\Facades\Hash;

class Rule27TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat User Khusus untuk Testing
        // Email terverifikasi, role masyarakat, tanpa superiority_role
        $user = User::firstOrCreate(
            ['email' => 'tester27rule@relasibaik.com'],
            [
                'name' => 'Ageng Puji Pangestu',
                'password' => Hash::make('password'), // Password login: password
                'email_verified_at' => now(),
                'role' => 'masyarakat',
                'superiority_role' => null,
            ]
        );

        // 2. Persiapkan Dummy Skor Pasti yang memenuhi syarat kategori
        $scores = [
            'FPQ'  => ['Tinggi' => 50, 'Sedang' => 28, 'Rendah' => 10], // Ambang: 18.6 & 37.3
            'MCIQ' => ['Tinggi' => 90, 'Sedang' => 56, 'Rendah' => 20], // Ambang: 37.3 & 74.6
            'FMWB' => ['Tinggi' => 60, 'Sedang' => 36, 'Rendah' => 15], // Ambang: 24 & 48
        ];

        $categories = ['Tinggi', 'Sedang', 'Rendah'];
        $ruleNumber = 1;

        // 3. Looping Otomatis membentuk R-01 sampai R-27
        // Urutannya persis seperti tabel di gambar kamu
        foreach ($categories as $catFather) {
            foreach ($categories as $catMother) {
                foreach ($categories as $catOther) {
                    
                    // Bentuk Kode Rekomendasi (Contoh: TTS, RRS, dsb)
                    $ruleCode = substr($catFather, 0, 1) . substr($catMother, 0, 1) . substr($catOther, 0, 1);
                    
                    // Cari ID Rekomendasi di database berdasarkan kode
                    $recommendation = Recommendation::where('code', $ruleCode)->first();

                    // Buat Data Screening Utama
                    $screening = Screening::create([
                        'user_id' => $user->id,
                        'lokasi'  => "Test Seeder Rule R-" . str_pad($ruleNumber, 2, '0', STR_PAD_LEFT),
                        'tanggal_pengisian' => now(),
                        'id_recommendation' => $recommendation ? $recommendation->id : null,
                        'status' => 'saved'
                    ]);

                    // Buat Data Hasil (Screening Result)
                    ScreeningResult::create([
                        'id_screening'  => $screening->id,
                        
                        'fpq_score'     => $scores['FPQ'][$catFather],
                        'fpq_category'  => $catFather,
                        
                        'mciq_score'    => $scores['MCIQ'][$catMother],
                        'mciq_category' => $catMother,
                        
                        'fmwb_score'    => $scores['FMWB'][$catOther],
                        'fmwb_category' => $catOther,
                        
                        'total_score'   => $scores['FPQ'][$catFather] + $scores['MCIQ'][$catMother] + $scores['FMWB'][$catOther],
                    ]);

                    $ruleNumber++;
                }
            }
        }

        $this->command->info('Berhasil membuat 1 User dan 27 Data Skrining untuk testing rule!');
    }
}