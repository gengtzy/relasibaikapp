<?php

namespace App\Livewire;

use App\Services\ScreeningService;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Session;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Log;


#[Layout('layouts.app')]
class ScreeningWizard extends Component
{
    #[Url]
    public $currentStep = 1;

    #[Session]
    public $biodata = [];
    #[Session]
    public $fatherAnswers = [];
    #[Session]
    public $fatherScore = 0;
    #[Session]
    public $motherAnswers = [];
    #[Session]
    public $motherScore =0;
    #[Session]
    public $otherAnswers = [];
    #[Session]
    public $otherScore = 0;
    
    public $finalResultId = null;

    public $isProcessing = false; 
    public $isFinished = false;

    #[On('biodataCompleted')]
    public function onBiodataCompleted($biodata)
    {

        $this->biodata = $biodata;

        // 5. Pindahkan ke langkah berikutnya
        $this->currentStep = 2;
    }

    #[On('goToStep')]
    public function onGoToStep($step)
    {
        $this->currentStep = $step;
    }

    #[On('fatherAnswersCompleted')]
    public function onFatherAnswersCompleted($answers, $score)
    {
        $this->fatherAnswers = $answers;
        $this->fatherScore = $score;

        $this->currentStep = 3;
    }

    #[On('motherAnswersCompleted')]
    public function onMotherAnswersCompleted($answers, $score)
    {
        $this->motherAnswers = $answers;
        $this->motherScore = $score;

        // dd($this->motherAnswers, $this->motherScore);

        $this->currentStep = 4; // Lanjut ke Step Keluarga Lain
    }

    #[On('otherAnswersCompleted')]
    public function onOtherAnswersCompleted($answers, $score)
    {
        $this->otherAnswers = $answers;
        $this->otherScore = $score;

        // --- FINAL PROSES: SIMPAN KE DATABASE ---
        // Kita panggil method khusus di Wizard ini
        $this->submitAllData();
    }

    public function submitAllData()
    {
        $this->isProcessing = true; 

        try {
            $service = app(ScreeningService::class);
            
            // Validasi data session sebelum kirim (Mencegah data kosong)
            if(empty($this->fatherAnswers) || empty($this->motherAnswers)) {
                throw new \Exception("Data jawaban tidak lengkap. Silakan ulangi pengisian.");
            }

            $result = $service->calculateAndSave(
                $this->biodata,
                $this->fatherAnswers,
                $this->motherAnswers,
                $this->otherAnswers
            );

            if ($result) {
                $this->finalResultId = $result->id;
                $this->isProcessing = false; 
                $this->isFinished = true; // TRIGER MODAL SUKSES
            }

        } catch (\Exception $e) {
            $this->isProcessing = false;
            $this->isFinished = false;
            
            // LOG ERROR AGAR BISA DILACAK DI LARAVEL.LOG
            Log::error('Screening Error: ' . $e->getMessage());
            
            // TAMPILKAN ERROR KE USER
            session()->flash('error', 'Gagal menyimpan: ' . $e->getMessage());
            
            // Opsional: dispatch event browser untuk sweetalert jika pakai
            // $this->dispatch('show-error', message: $e->getMessage());
        }
    }

    public function goToResult()
    {
        $this->isFinished = false; // Tutup Modal
        $this->currentStep = 5;    // Pindah Halaman
    }

    public function render()
    {
        return view('livewire.screening-wizard');
    }
}