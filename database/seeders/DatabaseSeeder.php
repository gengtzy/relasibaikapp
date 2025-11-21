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
        User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'masyarakat',
            'superiority_role' => 'Ayah',
        ]);
        
        User::create([
            'name' => 'Adminrb',
            'email' => 'admin@relasibaik.com',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

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

        $fpqQuestions = [
            'Saya merasa dekat dengan ayah.',
            'Ayah sangat penting bagi saya.',
            'Saya merasa ayah membela dan mendukung pilihan atau kegiatan saya.',
            'Saya menghormati ayah saya.',
            'Saya terinspirasi oleh ayah.',
            'Ayah saya memiliki tempat istimewa dalam hidup saya dan tak seorangpun dapat menggantikannya.',
            'Ayah dan saya menikmati kebersamaan kami.',
            'Saya ingin seperti ayah saya.',
            'Ayah membantu saya mempelajari hal-hal baru.',
            'Saya dapat meminta nasihat dari ayah atau meminta ayah membantu saya menyelesaikan masalah.',
            'Ayah membantu saya memikirkan masa depan saya.',
            'Ayah mendengarkan saya ketika saya berbicara dengannya.',
            'Ayah mendorong/menyemangati saya.',
            'Ayah akan memegang tangan/menggandeng saya atau merangkul saya.',
        ];

        foreach ($fpqQuestions as $index => $text) {
            Question::create([
                'id_instrument' => $insFather->id,
                'question_text' => $text,
                'scoring_type' => 'Favorable',
            ]);
        }

        $mciqQuestions = [
            [
                'text' => 'Ibu saya jarang mengatakan hal-hal baik pada saya.',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Saya adalah orang penting di mata ibuku.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Ibu saya sering bertindak seolah-olah dia tidak peduli dengan saya.',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Ibuku senang menghabiskan waktu bersamaku.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Ibuku mengungkapkan kehangatan dan rasa sayangnya kepadaku.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Saya mudah berbicara dengan ibu.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Saya merasa tegang dan tidak nyaman saat ibu dan saya bersama.',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Saya merasa bahwa ibu lebih sering menyalahkan kesalahan saya.',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Ibu berminat aktif dalam kegiatan/urusan saya.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Saya merasa sangat dekat dengan ibu saya.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Ibu saya tidak memahami saya.',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Ibu mempercayai saya.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Saya tidak merasa ibu senang bersamaku.',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Ibuku tidak benar-benar tahu tipe orang seperti apa saya.',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Ibu saya adalah seorang yang hangat dan penuh perhatian.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Ibu saya tidak merasa saya adalah seorang yang penting dan menarik.',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Ibu saya sangat tertarik dengan hal-hal mengenai saya.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Ibu saya sering mengkritik saya dan tidak ada yang pernah saya bisa lakukan untuk menyenangkannya.',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Ibu saya jarang menunjukkan kasih sayang kepada saya.',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Ibuku menghiburku dan membantuku saat aku tidak bahagia atau bermasalah.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Ibuku umumnya dingin dan "berjarak" saat aku bersamanya.',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Saya banyak menerima penguatan dari ibu saya.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Ibu saya sangat pengertian dan simpatik.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Ibu saya tidak terlalu peduli dengan apa yang terjadi pada diri saya.',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Ibu saya mendorong saya untuk berbicara dengan ayah.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Ibu saya menghormati keputusan ayah.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Ibu saya menghargai apa yang dilakukan ayah untuk kami.',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Saya menyukai cara ibu bercerita tentang ayah.',
                'type' => 'Favorable'
            ],
        ];

        foreach ($mciqQuestions as $item) {
            Question::create([
                'id_instrument' => $insMother->id,
                'question_text' => $item['text'],
                'scoring_type'  => $item['type'],
            ]);
        }

        $fmwbQuestions = [
            [
                'text' => 'Seberapa mengkhawatirkannya kesehatan Anda saat ini? (selama 1 bulan terakhir)',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Seberapa relaks atau tegangnya Anda saat ini (selama 1 bulan terakhir)',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Seberapa besar energi semangat, vitalitas yang Anda rasakan? (selama 1 bulan terakhir)',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Seberapa tertekan atau cerianya Anda saat ini? (selama 1 bulan terakhir)',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Seberapa takut Anda rasakan saat ini? (selama 1 bulan terakhir)',
                'type' => 'Favorable'
            ],
            [
                'text' => 'Seberapa marahkah Anda saat ini? (selama 1 bulan terakhir)',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Seberapa sedihkah Anda saat ini? (selama 1 bulan terakhir)',
                'type' => 'Unfavorable'
            ],
            [
                'text' => 'Seberapa khawatirnya Anda terhadap kesehatan salah satu anggota keluarga saat ini? (selama 1 bulan terakhir)',
                'type' => 'Favorable'
            ],
        ];

        foreach ($fmwbQuestions as $item) {
            Question::create([
                'id_instrument' => $insOther->id,
                'question_text' => $item['text'],
                'scoring_type'  => $item['type'],
            ]);
        }
    }
}