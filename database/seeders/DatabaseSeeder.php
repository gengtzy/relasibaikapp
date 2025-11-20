<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Instrument;
use App\Models\Question;
use App\Models\Recommendation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Test
        User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('password'), // password login
            'role' => 'masyarakat',
            'superiority_role' => 'Ayah', // Contoh buat ngetes bonus poin
        ]);

        // 2. Buat Instruments
        $insFather = Instrument::create(['code' => 'FPQ', 'name' => 'Father Presence Questionnaire']);
        $insMother = Instrument::create(['code' => 'MCIQ', 'name' => 'Maternal Closeness Questionnaire']);
        $insOther  = Instrument::create(['code' => 'FMWB', 'name' => 'Family Well-Being Scale']);

        // 3. Buat 27 Rule Recommendations (Knowledge Base)
        // Format Code: AYAH-IBU-LAIN (T=Tinggi, S=Sedang, R=Rendah)
        $rules = [
            ['TTT', 'Keluarga Sangat Harmonis', 'Selamat! Hubungan dengan Ayah, Ibu, dan keluarga lain sangat baik.'],
            ['TTS', 'Keluarga Harmonis Stabil', 'Hubungan orang tua sangat baik, namun interaksi keluarga lain sedang.'],
            ['TTR', 'Masalah Lingkungan Berat', 'Hubungan orang tua baik, tapi lingkungan keluarga lain buruk.'],
            // ... Tambahkan kombinasi lain sesuai skripsi (Total 27) ...
            ['SSS', 'Keluarga Rata-Rata', 'Hubungan dalam keluarga berjalan standar, perlu ditingkatkan kehangatannya.'],
            ['RRR', 'Disharmonis Total', 'Kondisi krisis. Disarankan segera mencari bantuan profesional/psikolog.'],
            // Default Fallback jika kombinasi belum lengkap
            ['BUTUH_KONSELING', 'Perlu Evaluasi Lanjut', 'Silakan hubungi admin.'] 
        ];

        foreach ($rules as $rule) {
            Recommendation::create([
                'code' => $rule[0],
                'title' => $rule[1],
                'description' => $rule[2]
            ]);
        }

        // 4. Buat Pertanyaan (Questions)
        
        // --- SOAL AYAH (FPQ) - 14 Soal (Skala 0-4) ---
        $fpqQuestions = [
            'Saya merasa ayah saya selalu ada untuk saya.',
            'Ayah saya sering mengajak saya berdiskusi.',
            // ... Masukkan 14 soal FPQ di sini ...
            'Saya merasa canggung dengan ayah saya.', // Contoh soal negatif
        ];

        foreach ($fpqQuestions as $index => $text) {
            Question::create([
                'id_instrument' => $insFather->id,
                'question_text' => $text,
                'scoring_type' => ($index == 13) ? 'Unfavorable' : 'Favorable', // Contoh soal terakhir unfavorable
            ]);
        }

        // --- SOAL IBU (MCIQ) - 24 Soal (Skala 1-9) ---
        $mciqQuestions = [
            'Seberapa sering Anda merasa dimengerti oleh Ibu?',
            'Seberapa sering Ibu mengabaikan perasaan Anda?',
             // ... Masukkan 24 soal MCIQ di sini ...
        ];

        foreach ($mciqQuestions as $index => $text) {
            Question::create([
                'id_instrument' => $insMother->id,
                'question_text' => $text,
                'scoring_type' => ($index == 1) ? 'Unfavorable' : 'Favorable',
            ]);
        }

        // --- SOAL LAINNYA (FMWB) - 8 Soal (Skala 1-9) ---
        $fmwbQuestions = [
            'Bagaimana energi Anda saat bersama keluarga besar?', // Kata kunci: energi
            'Apakah Anda merasa sedih di rumah?', // Kata kunci: sedih
             // ... Masukkan 8 soal FMWB di sini ...
        ];

        foreach ($fmwbQuestions as $text) {
            Question::create([
                'id_instrument' => $insOther->id,
                'question_text' => $text,
                'scoring_type' => 'Favorable',
            ]);
        }
    }
}