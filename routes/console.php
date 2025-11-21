<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Screening;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $jumlahDihapus = Screening::where('status', 'preview')
                    ->where('created_at', '<', now()->subDay())
                    ->delete();

    if ($jumlahDihapus > 0) {
        Log::info("SCHEDULER: Berhasil menghapus $jumlahDihapus data sampah (preview).");
    }
})->daily();