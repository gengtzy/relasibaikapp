<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')]
class Portal extends Component
{
    // Data Dummy Publikasi (5 Jurnal, penulis utamanya adalah 5 member di bawah)
    public $publikasiData = [
        [
            'judul' => 'Model Reasoning Rule-Based pada Sistem Pakar Diagnosa Keharmonisan Keluarga',
            'penulis' => 'Dr. Rani Purbaningtyas, S.Kom., M.T., dkk.',
            'deskripsi' => 'Penelitian mengenai penerapan algoritma rule-based reasoning untuk menentukan tingkat keharmonisan berdasarkan skor instrumen FPQ, MCIQ, dan FMWB.',
            'link' => 'https://scholar.google.com/'
        ],
        [
            'judul' => 'Rancang Bangun Sistem Screening Kualitas Relasi Keluarga Indonesia Berbasis Web',
            'penulis' => 'Ageng Puji Pangestu, dkk.',
            'deskripsi' => 'Pengembangan sistem pakar untuk mendiagnosa kualitas relasi antara ayah, ibu, dan anggota keluarga lain menggunakan instrumen psikologis terukur.',
            'link' => 'https://scholar.google.com/'
        ],
        [
            'judul' => 'Analisis UX/UI pada Sistem Pakar Psikologi Menggunakan Metode System Usability Scale (SUS)',
            'penulis' => 'Agitha Risky Aldiansyah, dkk.',
            'deskripsi' => 'Evaluasi pengalaman pengguna pada antarmuka aplikasi skrining keluarga untuk memastikan kemudahan akses bagi berbagai kalangan usia.',
            'link' => 'https://scholar.google.com/'
        ],
        [
            'judul' => 'Penerapan Framework Laravel dan Livewire pada Pengembangan Aplikasi Skrining Psikologi Skala Besar',
            'penulis' => 'Wahyu Putera Maulana, dkk.',
            'deskripsi' => 'Studi tentang optimasi performa aplikasi Single Page Application (SPA) pada sistem yang mengelola ribuan data respons psikologis.',
            'link' => 'https://scholar.google.com/'
        ],
        [
            'judul' => 'Evaluasi Keamanan Data Medis dan Psikologis pada Platform Berbasis Cloud M-Health',
            'penulis' => 'Dr. Budi Santoso, M.Cs.',
            'deskripsi' => 'Analisis kerentanan sistem dan perlindungan privasi data riwayat psikologis pasien pada sistem pakar berbasis cloud computing.',
            'link' => 'https://scholar.google.com/'
        ]
    ];

    // Data Dummy Member (5 Profil Lengkap dengan masing-masing 3 jurnal)
    public $memberData = [
        [
            'nama' => 'Rani Purbaningtyas, S.Kom., M.T.',
            'nidn' => '0012038203',
            'kampus' => 'Politeknik Negeri Jember',
            'foto' => 'https://ui-avatars.com/api/?name=Rani+Purbaningtyas&background=0D8ABC&color=fff&size=128',
            'jurnal' => [
                ['judul' => 'Model Reasoning Rule-Based pada Sistem Pakar Diagnosa Keharmonisan Keluarga', 'desc' => 'Penerapan algoritma rule-based reasoning berdasarkan skor FPQ, MCIQ, dan FMWB.', 'doi' => '10.1234/jkb.v1i1.001'],
                ['judul' => 'Implementasi Algoritma Forward Chaining untuk Deteksi Dini Stres Remaja', 'desc' => 'Pengembangan mesin inferensi untuk deteksi tingkat stres pada siswa sekolah menengah.', 'doi' => '10.1234/jkb.v1i2.002'],
                ['judul' => 'Pengembangan Aplikasi Mobile Deteksi Tumbuh Kembang Anak', 'desc' => 'Pembuatan sistem pakar pada platform Android untuk memonitor tumbuh kembang.', 'doi' => '10.1234/jkb.v2i1.003'],
            ]
        ],
        [
            'nama' => 'Ageng Puji Pangestu',
            'nidn' => 'Mahasiswa',
            'kampus' => 'Politeknik Negeri Jember',
            'foto' => 'https://ui-avatars.com/api/?name=Ageng+Puji&background=10B981&color=fff&size=128',
            'jurnal' => [
                ['judul' => 'Rancang Bangun Sistem Screening Kualitas Relasi Keluarga Indonesia Berbasis Web', 'desc' => 'Pengembangan sistem pakar untuk mendiagnosa kualitas relasi keluarga.', 'doi' => '10.1234/jif.v3i1.011'],
                ['judul' => 'Integrasi TALL Stack pada Pembuatan Dashboard Analitik Data Psikologi', 'desc' => 'Analisis penggunaan Tailwind, Alpine, Laravel, dan Livewire pada dashboard admin.', 'doi' => '10.1234/jif.v3i2.012'],
                ['judul' => 'Studi Komparasi Kinerja PostgreSQL dan MySQL pada Aplikasi Sistem Pakar', 'desc' => 'Perbandingan waktu eksekusi query kompleks antara dua RDBMS.', 'doi' => '10.1234/jif.v4i1.013'],
            ]
        ],
        [
            'nama' => 'Agitha Risky Aldiansyah',
            'nidn' => 'Mahasiswa',
            'kampus' => 'Politeknik Negeri Jember',
            'foto' => 'https://ui-avatars.com/api/?name=Agitha+Risky&background=F59E0B&color=fff&size=128',
            'jurnal' => [
                ['judul' => 'Analisis UX/UI pada Sistem Pakar Psikologi Menggunakan Metode System Usability Scale (SUS)', 'desc' => 'Evaluasi pengalaman pengguna pada antarmuka aplikasi skrining.', 'doi' => '10.1234/jti.v2i1.021'],
                ['judul' => 'Desain Antarmuka Adaptif untuk Pengguna Lansia pada Aplikasi Kesehatan', 'desc' => 'Penelitian tentang rasio kontras dan ukuran tipografi untuk aksesibilitas.', 'doi' => '10.1234/jti.v2i2.022'],
                ['judul' => 'Implementasi Pendekatan User-Centered Design dalam Aplikasi RelasiBaik', 'desc' => 'Penerapan metode UCD untuk meningkatkan kepuasan pengguna.', 'doi' => '10.1234/jti.v3i1.023'],
            ]
        ],
        [
            'nama' => 'Wahyu Putera Maulana',
            'nidn' => 'Mahasiswa',
            'kampus' => 'Politeknik Negeri Jember',
            'foto' => 'https://ui-avatars.com/api/?name=Wahyu+Putera&background=6366F1&color=fff&size=128',
            'jurnal' => [
                ['judul' => 'Penerapan Framework Laravel dan Livewire pada Pengembangan Aplikasi Skrining Psikologi Skala Besar', 'desc' => 'Studi tentang optimasi performa SPA pada sistem pengelolaan ribuan data.', 'doi' => '10.1234/jse.v1i1.031'],
                ['judul' => 'Optimasi Eager Loading ORM Eloquent untuk Laporan Data Rekam Medis', 'desc' => 'Strategi mengatasi N+1 Query Problem pada pelaporan data berelasi.', 'doi' => '10.1234/jse.v1i2.032'],
                ['judul' => 'Manajemen State pada Aplikasi Single Page Web dengan Alpine.js', 'desc' => 'Eksplorasi penggunaan Alpine.js untuk reaktivitas antarmuka tanpa virtual DOM.', 'doi' => '10.1234/jse.v2i1.033'],
            ]
        ],
        [
            'nama' => 'Dr. Budi Santoso, M.Cs.',
            'nidn' => '0799887766',
            'kampus' => 'Politeknik Negeri Jember',
            'foto' => 'https://ui-avatars.com/api/?name=Budi+Santoso&background=EC4899&color=fff&size=128',
            'jurnal' => [
                ['judul' => 'Evaluasi Keamanan Data Medis dan Psikologis pada Platform Berbasis Cloud M-Health', 'desc' => 'Analisis kerentanan sistem dan perlindungan privasi data pasien.', 'doi' => '10.1234/jcs.v4i1.041'],
                ['judul' => 'Audit Keamanan Sistem Informasi Rumah Sakit Menggunakan Standar ISO 27001', 'desc' => 'Penerapan standar internasional untuk manajemen keamanan informasi.', 'doi' => '10.1234/jcs.v4i2.042'],
                ['judul' => 'Enkripsi End-to-End pada Basis Data Pasien Menggunakan Algoritma AES-256', 'desc' => 'Implementasi algoritma kriptografi untuk mengamankan data sensitif.', 'doi' => '10.1234/jcs.v5i1.043'],
            ]
        ]
    ];

    public function render()
    {
        return view('livewire.portal');
    }
}