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
            'name' => 'RelasiBaik',
            'email' => 'relasibaik@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'masyarakat',
            'superiority_role' => null,
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

        $rules = [
            // 1. Kombinasi Tinggi - Tinggi - Tinggi
            ['TTT', 'Sangat Harmonis, dan anggota keluarga merasakan kesejahteraan psikologis', 'Persepsi anak terhadap relasi dengan kedua orangtua dalam taraf yang harmonis dan anak merasakan gambaran kesejahteraan keluarga yang tinggi.'],

            // Kombinasi dengan dominan Tinggi
            ['TTS', 'Harmonis dengan kesejahteraan psikologis yang memadai', 'Persepsi anak terhadap relasi dengan kedua orangtuanya dalam taraf harmonis, namun anak merasakan kesejahteraan keluarga yang cukup, akibat adanya sumber permasalahan lain.'],
            ['TTR', 'Harmonis relasi orangtua-anak, namun anggota keluarga tidak merasakan kesejahteraan psikologis', 'Persepsi anak terhadap relasi dengan kedua orangtuanya dalam taraf harmonis, namun anak merasakan kesejahteraan keluarga yang rendah, akibat adanya sumber permasalahan lain.'],

            ['TST', 'Harmonis, dan anggota keluarga merasakan kesejahteraan psikologis', 'Relasi orangtua-anak dipersepsikan anak cukup harmonis, meskipun ada resiko konflik relasional dengan ibu, yang tidak berkaitan dengan kondisi kesejahteraan keluarganya.'],
            ['TSS', 'Harmonis dengan kesejahteraan psikologis yang memadai', 'Relasi orangtua-anak dipersepsikan anak cukup harmonis, meskipun terindikasi ada resiko konflik relasional ibu dan anak, yang tampak berkaitan dengan kondisi kesejahteraan keluarganya.'],
            ['TSR', 'Harmonis relasi orangtua-anak, namun anggota keluarga tidak merasakan kesejahteraan psikologis', 'Relasi orangtua-anak dipersepsikan anak cukup harmonis, meskipun terindikasi ada resiko konflik relasional ibu dan anak, yang dirasakan mengganggu kondisi kesejahteraan keluarganya.'],

            ['TRT', 'Cukup Harmonis, dan anggota keluarga merasakan kesejahteraan psikologis', 'Terindikasi terdapat disharmoni dalam relasi ibu-anak, namun tidak berkaitan dengan kesejahteraan keluarga yang dirasakan anak.'],
            ['TRS', 'Cukup Harmonis dengan kesejahteraan psikologis yang memadai', 'Terindikasi terdapat disharmoni dalam relasi ibu-anak, tampaknya berkaitan dengan kesejahteraan keluarga yang dirasakan anak.'],
            ['TRR', 'Cukup Harmonis relasi orangtua-anak, namun anggota keluarga tidak merasakan kesejahteraan psikologis', 'Terindikasi terdapat disharmoni dalam relasi ibu-anak, berkaitan dengan kesejahteraan keluarga yang dirasakan anak rendah.'],

            // Kombinasi dominan Sedang
            ['STT', 'Harmonis, dan anggota keluarga merasakan kesejahteraan psikologis', 'Relasi orangtua-anak dipersepsikan anak cukup harmonis, meskipun ada resiko konflik relasional dengan ayah, yang tidak berkaitan dengan kondisi kesejahteraan keluarganya.'],
            ['STS', 'Harmonis dengan kesejahteraan psikologis yang memadai', 'Relasi orangtua-anak dipersepsikan anak cukup harmonis, meskipun terindikasi ada resiko konflik relasional ayah dan anak, yang tampak berkaitan dengan kondisi kesejahteraan keluarganya.'],
            ['STR', 'Harmonis relasi orangtua-anak, namun anggota keluarga tidak merasakan kesejahteraan psikologis', 'Relasi orangtua-anak dipersepsikan anak cukup harmonis, meskipun terindikasi ada resiko konflik relasional ayah dan anak, yang tampak berkaitan dengan kondisi kesejahteraan keluarganya. (Catatan: Poin ini muncul dua kali di teks asli).'],

            ['SST', 'Cukup Harmonis, dan anggota keluarga merasakan kesejahteraan psikologis', 'Terindikasi adanya relasi orangtua-anak yang dipersepsikan anak ada resiko konflik relasional baik dengan ayah atau ibu, namun tidak berkaitan dengan kesejahteraan keluarga yang dirasakan anak.'],
            ['SSS', 'Cukup Harmonis dengan kesejahteraan psikologis yang memadai', 'Terindikasi adanya relasi orangtua-anak yang dipersepsikan anak ada resiko konflik relasional baik dengan ayah atau ibu, tampak berkaitan dengan kesejahteraan keluarga yang dirasakan anak.'],
            ['SSR', 'Cukup Harmonis relasi orangtua-anak, namun anggota keluarga tidak merasakan kesejahteraan psikologis', 'Terindikasi adanya relasi orangtua-anak yang dipersepsikan anak ada resiko konflik relasional baik dengan ayah atau ibu, yang dirasakan anak dalam kesejahteraan keluarga yang rendah.'],

            ['SRT', 'Kurang Harmonis relasi orangtua-anak, namun anggota keluarga merasakan kesejahteraan psikologis', 'Anak mempersepsikan adanya problem relasional dengan orangtua, khususnya ibu, namun merasakan dukungan dari pihak lain sehingga kesejahteraan keluarganya dirasakan masih tinggi.'],
            ['SRS', 'Kurang Harmonis dengan kesejahteraan psikologis yang memadai', 'Anak mempersepsikan adanya problem relasional dengan orangtua, khususnya ibu, dan tampaknya berkaitan dengan kesejahteraan keluarganya.'],
            ['SRR', 'Kurang Harmonis, dan anggota keluarga tidak merasakan kesejahteraan psikologis', 'Anak mempersepsikan adanya problem relasional dengan orangtua, khususnya ibu, dan tampaknya sangat berkaitan dengan rendahnya kesejahteraan keluarga yang dirasakannya rendah.'],

            // Kombinasi dominan Rendah
            ['RTT', 'Cukup Harmonis, dan anggota keluarga merasakan kesejahteraan psikologis', 'Terindikasi terdapat disharmoni dalam relasi ayah-anak, namun tidak berkaitan dengan kesejahteraan keluarga yang dirasakan anak.'],
            ['RTS', 'Cukup Harmonis dengan kesejahteraan psikologis yang memadai', 'Terindikasi terdapat disharmoni dalam relasi ayah-anak, tampaknya berkaitan dengan kesejahteraan keluarga yang dirasakan anak.'],
            ['RTR', 'Cukup Harmonis relasi orangtua-anak, namun anggota keluarga tidak merasakan kesejahteraan psikologis', 'Terindikasi terdapat disharmoni dalam relasi ayah-anak, yang berkaitan dengan kesejahteraan keluarga yang dirasakan anak rendah.'],

            ['RST', 'Kurang Harmonis relasi orangtua-anak, namun anggota keluarga merasakan kesejahteraan psikologis', 'Anak mempersepsikan adanya problem relasional dengan orangtua, khususnya ayah, namun merasakan dukungan dari pihak lain sehingga kesejahteraan keluarganya dirasakan masih tinggi.'],
            ['RSS', 'Kurang Harmonis dengan kesejahteraan psikologis yang memadai', 'Anak mempersepsikan adanya problem relasional dengan orangtua, khususnya ayah, dan tampaknya berkaitan dengan kesejahteraan keluarganya.'],
            ['RSR', 'Kurang Harmonis, dan anggota keluarga tidak merasakan kesejahteraan psikologis', 'Anak mempersepsikan adanya problem relasional dengan orangtua, khususnya ayah, dan tampaknya sangat berkaitan dengan rendahnya kesejahteraan keluarga yang dirasakannya rendah.'],

            ['RRT', 'Disharmonis relasi orangtua-anak, namun anggota keluarga merasakan kesejahteraan psikologis', 'Anak mempersepsikan adanya problem relasional dengan orangtua yang cukup berat, namun merasakan dukungan dari pihak lain sehingga kesejahteraan keluarganya dirasakan masih tinggi.'],
            ['RRS', 'Disharmonis dengan kesejahteraan psikologis yang memadai', 'Anak mempersepsikan adanya problem relasional dengan orangtua yang cukup berat, dan tampaknya berkaitan dengan kondisi kesejahteraan keluarganya.'],
            ['RRR', 'Sangat Disharmonis, dan anggota keluarga tidak merasakan kesejahteraan psikologis', 'Anak mempersepsikan adanya problem relasional dengan orangtua yang cukup berat, dan berkaitan erat dengan kondisi kesejahteraan keluarga yang rendah.'],
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