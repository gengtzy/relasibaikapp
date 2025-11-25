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
            'name' => 'AgengDev',
            'email' => 'ageng@yopmail.com',
            'password' => Hash::make('akuakuaku'),
            'role' => 'masyarakat',
            'superiority_role' => 'Ayah',
            'email_verified_at' => now(),
        ]);
        
        User::create([
            'name' => 'Adminrb',
            'email' => 'admin@relasibaik.com',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $insFather = Instrument::create(['code' => 'FPQ', 'name' => 'Father Presence Questionnaire']);
        $insMother = Instrument::create(['code' => 'MCIQ', 'name' => 'Mother Child-Interaction Questionnaire']);
        $insOther  = Instrument::create(['code' => 'FMWB', 'name' => 'Family Member Well-Being']);

        // 3. Buat 27 Rule Recommendations (Knowledge Base)
        // Format Code: AYAH-IBU-LAIN (T=Tinggi, S=Sedang, R=Rendah)
        $rules = [
            // 1. Kombinasi Tinggi - Tinggi - Tinggi
            ['TTT', 'Keluarga Sangat Harmonis', 'Selamat! Semua hubungan dalam keluarga berada pada tingkat terbaik.'],

            // Kombinasi dengan dominan Tinggi
            ['TTS', 'Keluarga Harmonis Stabil', 'Orangtua sangat baik, hubungan keluarga lain cukup stabil.'],
            ['TTR', 'Keluarga Harmonis tapi Lingkungan Bermasalah', 'Hubungan inti baik, namun ada masalah di lingkungan keluarga lain.'],

            ['TST', 'Hubungan Baik dengan Dinamika Sedang', 'Hubungan cukup kuat, meskipun ada area yang perlu perhatian.'],
            ['TSS', 'Cukup Harmonis', 'Interaksi dalam keluarga cukup baik secara keseluruhan.'],
            ['TSR', 'Harmonis namun Ada Masalah Sampingan', 'Hubungan orang tua baik, tetapi ada masalah pada anggota keluarga tertentu.'],

            ['TRT', 'Keluarga Cenderung Harmonis', 'Sebagian besar hubungan berjalan baik meski ada satu area rendah.'],
            ['TRS', 'Keluarga Hampir Harmonis', 'Mayoritas hubungan baik, namun beberapa aspek butuh perhatian.'],
            ['TRR', 'Harmonis Terbatas', 'Hanya hubungan inti yang baik, sisanya bermasalah.'],

            // Kombinasi dominan Sedang
            ['STT', 'Potensi Harmonis Tinggi', 'Hubungan keluarga bisa menjadi sangat baik dengan sedikit perbaikan.'],
            ['STS', 'Cukup Stabil', 'Keluarga berada dalam kondisi stabil meski tidak terlalu dekat.'],
            ['STR', 'Stabil tapi Ada Konflik', 'Hubungan keluarga sedang, namun ada area konflik yang perlu diperhatikan.'],

            ['SST', 'Stabil Menuju Harmonis', 'Hubungan keluarga stabil dan dapat meningkat dengan komunikasi lebih baik.'],
            ['SSS', 'Keluarga Rata-Rata', 'Hubungan dalam keluarga berjalan standar, perlu ditingkatkan kehangatannya.'],
            ['SSR', 'Stabil namun Cenderung Melemah', 'Hubungan masih cukup, tetapi mulai ada kendala yang perlu diperbaiki.'],

            ['SRT', 'Hubungan Tidak Stabil tapi Bisa Dipulihkan', 'Ada dinamika rendah, namun masih ada faktor positif.'],
            ['SRS', 'Hubungan Mulai Bermasalah', 'Hubungan cukup renggang, namun masih bisa diperbaiki.'],
            ['SRR', 'Hubungan Banyak Masalah', 'Mayoritas hubungan keluarga memerlukan perhatian serius.'],

            // Kombinasi dominan Rendah
            ['RTT', 'Masalah pada Anggota Tertentu', 'Orangtua baik, tetapi ada masalah serius pada hubungan tertentu.'],
            ['RTS', 'Cenderung Bermasalah', 'Hubungan kurang harmonis, namun masih ada bagian stabil.'],
            ['RTR', 'Masalah Berat pada Lingkungan', 'Hubungan sangat terpengaruh oleh konflik di lingkungan keluarga.'],

            ['RST', 'Hubungan Kurang baik Namun Ada Potensi', 'Dua area rendah, namun ada satu hubungan yang masih baik.'],
            ['RSS', 'Kurang Harmonis', 'Hubungan dalam keluarga cenderung buruk namun masih bisa diperbaiki.'],
            ['RSR', 'Disharmonis Parsial', 'Hubungan tidak stabil dan memerlukan perbaikan signifikan.'],

            ['RRT', 'Banyak Konflik Serius', 'Kondisi keluarga buruk namun masih ada sedikit aspek positif.'],
            ['RRS', 'Keluarga Hampir Disharmonis', 'Mayoritas hubungan buruk, hanya satu yang sedang.'],
            ['RRR', 'Disharmonis Total', 'Kondisi krisis. Disarankan segera mencari dukungan profesional.'],

            // Fallback
            ['BUTUH_KONSELING', 'Perlu Evaluasi Lanjut', 'Silakan hubungi admin.'],
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