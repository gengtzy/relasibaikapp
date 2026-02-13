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
    #[Url(keep: true)]
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

    public function mount()
    {
        // Cek apakah ada ID hasil yang tersimpan di session browser
        if (session()->has('last_screening_id')) {
            $this->finalResultId = session('last_screening_id');
            
            // Jika user me-refresh halaman saat di step 5, pastikan ID-nya terisi
            if ($this->currentStep == 5) {
                $this->isFinished = true; // Opsional: sesuaikan dengan logika tampilan Anda
            }
        }
    }

    #[On('biodataCompleted')]
    public function onBiodataCompleted($biodata)
    {

        $this->biodata = $biodata;

        $this->currentStep = 2;
        $this->dispatch('scroll-to-top');
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
        $this->dispatch('scroll-to-top');
    }

    #[On('motherAnswersCompleted')]
    public function onMotherAnswersCompleted($answers, $score)
    {
        $this->motherAnswers = $answers;
        $this->motherScore = $score;

        // dd($this->motherAnswers, $this->motherScore);

        $this->currentStep = 4;
        $this->dispatch('scroll-to-top');
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
                session()->put('last_screening_id', $result->id);
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
        $this->isFinished = false;
        $this->currentStep = 5;
        $this->dispatch('scroll-to-top');
    }

    public function startNew()
    {
        session()->forget('last_screening_id'); // Hapus session ID lama
        $this->reset(); // Reset semua properti Livewire
        return redirect()->to('/screening-wizard'); // Refresh halaman penuh
    }

    public function render()
    {
        return view('livewire.screening-wizard');
    }
}